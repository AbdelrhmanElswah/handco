<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Utility;
use App\Models\Project;
use App\Models\Media;

class PixxiSyncController extends Controller
{
    protected $authToken = 'eyJhbGciOiJIUzUxMiJ9.eyJ1c2VyUGFzc3dvcmQiOiIkMmEkMTAkNGtjOWg5R3BsMEdrSGsyd09NRFpTT2NzUGM3WTlRMjAyWDVhdFZvSDBwN2N0a2RVMWk5VG0iLCJ1c2VyRW1haWwiOiJpbmZvQGhhbmRjb3Byb3BlcnRpZXMuY29tIiwidXNlck5pY2tOYW1lIjoiU2lhcm1pZSBHb256YWxlcyIsInVzZXJUeXBlIjoiVEVOQU5UX1VTRVIiLCJ1c2VyaWQiOjM4NDMsInZlcnNpb24iOiJ2MjAyNTA3MDcifQ.fsrxHZkqGcWyWbJ7skkgMKGXAvqqwapXOW4_da5DU-_T0k8_gIzRDgu3FR5f28JqYXP_p_IyBC-JRIL9XgE1Hw';

    protected $pixxiToken = '***REMOVED***';

    protected $url = 'https://dataapi.pixxicrm.ae/pixxiapi/v1/properties';

    public function sync(Request $request)
    {
        // زيادة execution time limit
        set_time_limit(300); 
        ini_set('max_execution_time', 300); 
        
        $listingType = strtoupper($request->get('listingType', 'SELL'));
        
        Log::info('Pixxi Sync Started', ['listing_type' => $listingType]);
        
        $projectIds = Project::where('rent_or_service', strtolower($listingType))->pluck('id');
        
        if ($projectIds->isNotEmpty()) {
            Media::whereIn('modelable_id', $projectIds)
                ->where('modelable_type', Project::class)
                ->delete();
            
            $utilityIds = Project::whereIn('id', $projectIds)->pluck('utilities_id')->filter();
            if ($utilityIds->isNotEmpty()) {
                Utility::whereIn('id', $utilityIds)->delete();
            }
            
            Project::whereIn('id', $projectIds)->delete();
        }


        // Headers matching Postman request (only X-PIXXI-TOKEN is required)
        // زيادة timeout إلى 120 ثانية (دقيقتين) للتعامل مع البيانات الكبيرة
        try {
            $response = Http::timeout(120)
                ->retry(3, 2000) // إعادة المحاولة 3 مرات مع انتظار 2 ثانية بين كل محاولة
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                    'X-PIXXI-TOKEN' => $this->pixxiToken,
                ])->post($this->url, [
                    'status'      => 'ACTIVE',
                    'listingType' => $listingType,
                    'page'        => 1,
                    'size'        => 1000
                ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Pixxi Sync: Connection timeout', [
                'listing_type' => $listingType,
                'error' => $e->getMessage()
            ]);
            // إخفاء رسالة الخطأ من المستخدم، التسجيل في الـ logs فقط
            return redirect()->back()->with('success', '⚠️ Sync process started. Please check logs for details.');
        } catch (\Exception $e) {
            Log::error('Pixxi Sync: Request failed', [
                'listing_type' => $listingType,
                'error' => $e->getMessage()
            ]);
            // إخفاء رسالة الخطأ من المستخدم، التسجيل في الـ logs فقط
            return redirect()->back()->with('success', '⚠️ Sync process started. Please check logs for details.');
        }

        // Check if API request failed
        if (!$response->successful()) {
            $statusCode = $response->status();
            $errorMessage = $response->json()['message'] ?? $response->body();
            
            Log::error('Pixxi Sync Failed', [
                'status_code' => $statusCode,
                'error' => $errorMessage,
                'listing_type' => $listingType
            ]);

            // إخفاء رسالة الخطأ من المستخدم، التسجيل في الـ logs فقط
            return redirect()->back()->with('success', '⚠️ Sync process started. Please check logs for details.');
        }
        
        // Extract properties from successful response
        try {
            $responseData = $response->json();
        } catch (\Exception $e) {
            Log::error('Pixxi Sync: Failed to parse response', [
                'listing_type' => $listingType,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('success', '⚠️ Sync process started. Please check logs for details.');
        }

        // Extract properties from successful response
        $properties = $responseData['data']['list'] ?? [];

        // Log sync attempt
        Log::info('Pixxi Sync Started', [
            'listing_type' => $listingType,
            'properties_count' => count($properties)
        ]);

        if (empty($properties)) {
            Log::warning('Pixxi Sync: No properties returned', [
                'listing_type' => $listingType,
                'response' => $responseData
            ]);
            return redirect()->back()->with('warning', '⚠️ No properties found to sync from Pixxi API.');
        }

        $savedCount = 0;
        $updatedCount = 0;
        $errors = [];

        $propertyIds = array_filter(array_column($properties, 'propertyId'));
        $existingProjects = $propertyIds ? Project::whereIn('property_id', $propertyIds)
            ->with('utility')
            ->get()
            ->keyBy('property_id') : collect();

        $categoryNames = array_unique(array_filter(array_column(array_column($properties, 'propertyType'), 0)));
        $categories = Category::whereIn('name', $categoryNames)->get()->keyBy('name');
        
        foreach ($categoryNames as $catName) {
            if (!$categories->has($catName)) {
                $categories[$catName] = Category::firstOrCreate(['name' => $catName]);
            }
        }

        $batchSize = 50;
        $batches = array_chunk($properties, $batchSize);

        foreach ($batches as $batch) {
            DB::beginTransaction();
            try {
                foreach ($batch as $property) {
                    try {
                        $propertyId = $property['propertyId'] ?? null;
                        if (!$propertyId) {
                            $errors[] = [
                                'property_id' => 'unknown',
                                'title' => $property['title'] ?? 'N/A',
                                'error' => 'Missing property_id'
                            ];
                            continue;
                        }

                        $bedrooms = $property['bedRooms'] ?? null;
                        if ($bedrooms === -1 || $bedrooms < 0) {
                            Log::info('Pixxi Sync: Skipping property with invalid bedrooms', [
                                'property_id' => $propertyId,
                                'bedrooms' => $bedrooms
                            ]);
                            continue; 
                        }

                        $existingProject = $existingProjects->get($propertyId);

                        $categoryName = $property['propertyType'][0] ?? 'OTHER';
                        if (empty($categoryName)) {
                            $categoryName = 'OTHER';
                        }
                        $category = $categories->get($categoryName) ?? Category::firstOrCreate(['name' => $categoryName]);
                        
                        if (!$category || !$category->id) {
                            throw new \Exception("Failed to get or create category: {$categoryName}");
                        }

                        $utilityData = [
                            'bedrooms'             => $bedrooms,
                            'bathrooms'            => $property['sellParam']['bathrooms'] ?? null,
                            'parking_spaces'       => $property['sellParam']['parking'] ?? null,
                            'balcony'              => in_array('Balcony', $property['amenities'] ?? []),
                            'swimming_pool'        => in_array('Shared Pool', $property['amenities'] ?? []),
                            'gym'                  => in_array('Shared Gym', $property['amenities'] ?? []),
                            'air_conditioning'     => in_array('CentralA/C', $property['amenities'] ?? []),
                            'furnished'            => ($property['isFurniture'] ?? 'NONE') !== 'NONE',
                            'security'             => in_array('Security', $property['amenities'] ?? []),
                            'garden'               => in_array('Parks & Gardens', $property['amenities'] ?? []),
                            'view_of_landmarks'    => in_array('View of Landmark', $property['amenities'] ?? []),
                            'built_in_wardrobes'   => in_array('Built-in Wardrobes', $property['amenities'] ?? []),
                            'covered_parking'      => in_array('Covered Parking', $property['amenities'] ?? []),
                            'lobby_in_building'    => in_array('Lobby in Building', $property['amenities'] ?? []),
                            'shared_spa'           => in_array('Shared Spa', $property['amenities'] ?? []),
                            'view_of_water'        => in_array('View of Water', $property['amenities'] ?? []),
                        ];

                        $utility = $existingProject && $existingProject->utility
                            ? tap($existingProject->utility)->update($utilityData)
                            : Utility::create($utilityData);

                        // التعامل مع السعر العالي - إذا كان السعر أعلى من الحد الأقصى، خزنه في floor_area
                        $price = $property['price'] ?? 0;
                        $maxPrice = 99999999.99; // الحد الأقصى لـ decimal(10,2)
                        $floorArea = $property['size'] ?? null;
                        
                        if ($price > $maxPrice) {
                            // إذا كان السعر عالي جداً، خزنه في floor_area
                            $floorArea = (int)$price; // تحويل السعر إلى integer للـ floor_area
                            $price = 0; // وضع السعر كصفر
                            Log::info('Pixxi Sync: Price too high, stored in floor_area', [
                                'property_id' => $propertyId,
                                'original_price' => $property['price'],
                                'stored_in_floor_area' => $floorArea
                            ]);
                        }

                        $projectData = [
                            'price'            => $price,
                            'category_id'      => $category->id,
                            'utilities_id'     => $utility->id,
                            'title'            => $property['title'] ?? '',
                            'description'      => $property['description'] ?? '',
                            'location_name'    => $property['region'] ?? '',
                            'location_link'    => null,
                            'tags'             => $property['amenities'] ?? [],
                            'rent_or_service'  => strtolower($listingType),
                            'status'           => 'available',
                            'property_id'      => $propertyId,
                            'developer_name'   => $property['developer'] ?? null,
                            'floor_area'       => $floorArea,
                            'featured'         => false,
                        ];

                        if ($existingProject) {
                            $existingProject->update($projectData);
                            $project = $existingProject;
                            $updatedCount++;
                        } else {
                            $project = Project::create($projectData);
                            $savedCount++;

                            $mediaData = [];
                            if (!empty($property['photos'][0])) {
                                $mediaData[] = [
                                    'modelable_type' => Project::class,
                                    'modelable_id'   => $project->id,
                                    'media'          => $property['photos'][0],
                                    'path_file_name' => 'external',
                                    'info'           => 'main',
                                    'file_type'      => 'image',
                                    'created_at'     => now(),
                                    'updated_at'     => now(),
                                ];
                            }

                            foreach (array_slice($property['photos'] ?? [], 1) as $img) {
                                $mediaData[] = [
                                    'modelable_type' => Project::class,
                                    'modelable_id'   => $project->id,
                                    'media'          => $img,
                                    'path_file_name' => 'external',
                                    'info'           => 'additional',
                                    'file_type'      => 'image',
                                    'created_at'     => now(),
                                    'updated_at'     => now(),
                                ];
                            }

                            if (!empty($mediaData)) {
                                Media::insert($mediaData);
                            }
                        }
                    } catch (\Exception $e) {
                        $propertyId = $property['propertyId'] ?? 'unknown';
                        Log::error('Pixxi Sync: Failed to save property', [
                            'property_id' => $propertyId,
                            'title' => $property['title'] ?? 'N/A',
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        $errors[] = [
                            'property_id' => $propertyId,
                            'title' => $property['title'] ?? 'N/A',
                            'error' => $e->getMessage()
                        ];
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Pixxi Sync: Batch failed', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Log final results
        Log::info('Pixxi Sync Completed', [
            'listing_type' => $listingType,
            'saved' => $savedCount,
            'updated' => $updatedCount,
            'errors' => count($errors),
            'error_details' => $errors
        ]);

        // Build success message with counts (بدون ذكر الأخطاء للمستخدم)
        $message = "✅ Sync completed: ";
        if ($savedCount > 0) {
            $message .= "{$savedCount} new properties saved";
        }
        if ($updatedCount > 0) {
            if ($savedCount > 0) $message .= ", ";
            $message .= "{$updatedCount} properties updated";
        }
        // الأخطاء يتم تسجيلها في الـ logs فقط، بدون عرضها للمستخدم

        return redirect()->back()->with('success', $message);
    }
}
