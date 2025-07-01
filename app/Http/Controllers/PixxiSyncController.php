<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Utility;
use App\Models\Project;
use App\Models\Media;

class PixxiSyncController extends Controller
{
    protected $authToken = 'Bearer eyJhbGciOiJIUzUxMiJ9.eyJ1c2VyUGFzc3dvcmQiOiIkMmEkMTAkNGtjOWg5R3BsMEdrSGsyd09NRFpTT2NzUGM3WTlRMjAyWDVhdFZvSDBwN2N0a2RVMWk5VG0iLCJ1c2VyRW1haWwiOiJpbmZvQGhhbmRjb3Byb3BlcnRpZXMuY29tIiwidXNlck5pY2tOYW1lIjoiU2lhcm1pZSBHb256YWxlcyIsInVzZXJUeXBlIjoiVEVOQU5UX1VTRVIiLCJ1c2VyaWQiOjM4NDMsInZlcnNpb24iOiJ2MjAyNTA3MDcifQ.fsrxHZkqGcWyWbJ7skkgMKGXAvqqwapXOW4_da5DU-_T0k8_gIzRDgu3FR5f28JqYXP_p_IyBC-JRIL9XgE1Hw';

    protected $pixxiToken = '***REMOVED***';

    protected $url = 'https://dataapi.pixxicrm.ae/pixxiapi/v1/properties';

    public function sync(Request $request)
    {
        $listingType = strtoupper($request->get('listingType', 'SELL'));

        $response = Http::withHeaders([
            'Authorization' => $this->authToken,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'X-PIXXI-TOKEN'   => $this->pixxiToken,
        ])->post($this->url, [
            'status'      => 'ACTIVE',
            'listingType' => $listingType,
            'page'        => 1,
            'size'        => 1000
        ]);

        $properties = $response->json()['data']['list'] ?? [];

        foreach ($properties as $property) {
            $existingProject = Project::where('property_id', $property['propertyId'])->first();

            $categoryName = $property['propertyType'][0] ?? 'OTHER';
            $category = Category::firstOrCreate(['name' => $categoryName]);

            $utilityData = [
                'bedrooms'             => $property['bedRooms'],
                'bathrooms'            => $property['sellParam']['bathrooms'] ?? null,
                'parking_spaces'       => $property['sellParam']['parking'] ?? null,
                'balcony'              => in_array('Balcony', $property['amenities']),
                'swimming_pool'        => in_array('Shared Pool', $property['amenities']),
                'gym'                  => in_array('Shared Gym', $property['amenities']),
                'air_conditioning'     => in_array('CentralA/C', $property['amenities']),
                'furnished'            => $property['isFurniture'] !== 'NONE',
                'security'             => in_array('Security', $property['amenities']),
                'garden'               => in_array('Parks & Gardens', $property['amenities']),
                'view_of_landmarks'    => in_array('View of Landmark', $property['amenities']),
                'built_in_wardrobes'   => in_array('Built-in Wardrobes', $property['amenities']),
                'covered_parking'      => in_array('Covered Parking', $property['amenities']),
                'lobby_in_building'    => in_array('Lobby in Building', $property['amenities']),
                'shared_spa'           => in_array('Shared Spa', $property['amenities']),
                'view_of_water'        => in_array('View of Water', $property['amenities']),
            ];

            $utility = $existingProject
                ? tap($existingProject->utility)->update($utilityData)
                : Utility::create($utilityData);

            $projectData = [
                'price'            => $property['price'],
                'category_id'      => $category->id,
                'utilities_id'     => $utility->id,
                'title'            => $property['title'],
                'description'      => $property['description'],
                'location_name'    => $property['region'],
                'location_link'    => null,
                'tags'             => $property['amenities'],
                'rent_or_service'  => strtolower($listingType),
                'status'           => 'available',
                'property_id'      => $property['propertyId'],
                'developer_name'   => $property['developer'],
                'floor_area'       => $property['size'],
                'featured'         => false,
            ];

            if ($existingProject) {
                $existingProject->update($projectData);
                $project = $existingProject;
            } else {
                $project = Project::create($projectData);

                if (!empty($property['photos'][0])) {
                    Media::create([
                        'modelable_type' => Project::class,
                        'modelable_id'   => $project->id,
                        'media'          => $property['photos'][0],
                        'path_file_name' => 'external',
                        'info'           => 'main',
                        'file_type'      => 'image'
                    ]);
                }

                foreach (array_slice($property['photos'], 1) as $img) {
                    Media::create([
                        'modelable_type' => Project::class,
                        'modelable_id'   => $project->id,
                        'media'          => $img,
                        'path_file_name' => 'external',
                        'info'           => 'additional',
                        'file_type'      => 'image'
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', '✅ Pixxi properties synchronized successfully.');
    }
}
