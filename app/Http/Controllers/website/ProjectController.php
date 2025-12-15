<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CmsSection;
use App\Models\OffPlanProject;
use App\Models\Project;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        // Log all request parameters for debugging
        Log::info('Projects Index - All Request Parameters', [
            'all_params' => $request->all(),
            'garage_param' => $request->garage,
            'garage_filled' => $request->filled('garage'),
            'url' => $request->fullUrl(),
        ]);
        
        // Start a query for Project model
        $query = Project::query();
        
        // Filter by listing type (Buy = sell, Rent = rent, Off Plan = new)
        // Make sure Buy shows only "for Sale" properties, Rent shows only "for Rent" properties, and Off Plan shows "new" properties
        $listingType = strtolower($request->get('listingType', ''));
        if ($listingType === 'buy') {
            // Only show properties for sale (rent_or_service = 'sell')
            // Use LOWER() to handle any case sensitivity issues
            $query->whereRaw('LOWER(rent_or_service) = ?', ['sell']);
        } elseif ($listingType === 'rent') {
            // Only show properties for rent (rent_or_service = 'rent')
            // Use LOWER() to handle any case sensitivity issues
            $query->whereRaw('LOWER(rent_or_service) = ?', ['rent']);
        } elseif ($listingType === 'off-plan') {
            // Only show off-plan properties (rent_or_service = 'new')
            // Use LOWER() to handle any case sensitivity issues
            $query->whereRaw('LOWER(rent_or_service) = ?', ['new']);
        }

        // Exclude HOTEL_APARTMENT properties
        $query->whereDoesntHave('category', function($q) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%hotel%apartment%'])
              ->orWhereRaw('LOWER(name) = ?', ['hotel_apartment'])
              ->orWhereRaw('LOWER(name) = ?', ['hotel apartment']);
        });
        
        // Apply filters based on request parameters
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // Filter by category (by name)
        if ($request->filled('category')) {
            $categoryName = $request->category;
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', 'like', '%' . $categoryName . '%');
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location_name', 'like', '%' . $request->location . '%');
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->filled('min_price') ? (int) $request->min_price : null;
            $maxPrice = $request->filled('max_price') ? (int) $request->max_price : null;

            if ($minPrice && $maxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            } elseif ($minPrice) {
                $query->where('price', '>=', $minPrice);
            } elseif ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
            }
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $bedroomsValue = $request->bedrooms;
            $query->whereHas('utility', function ($q) use ($bedroomsValue) {
                if ($bedroomsValue === '6+') {
                    $q->where('bedrooms', '>=', 6);
                } else {
                    $q->where('bedrooms', $bedroomsValue);
                }
            });
        }

        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('bathrooms', $request->bathrooms);
            });
        }

        // Filter by garage availability
        if ($request->filled('garage')) {
            $garageValue = $request->garage;
            $garageBoolean = $garageValue == 'Yes' ? 1 : 0;
            
            Log::info('Garage Filter Debug', [
                'garage_request_value' => $garageValue,
                'garage_value_type' => gettype($garageValue),
                'garage_value_length' => strlen($garageValue),
                'garage_boolean_value' => $garageBoolean,
                'comparison_Yes' => $garageValue == 'Yes',
                'comparison_Yes_strict' => $garageValue === 'Yes',
                'projects_count_before' => $query->count(),
            ]);
            
            $query->whereHas('utility', function ($q) use ($garageBoolean, $garageValue) {
                Log::info('Garage Query Inside whereHas', [
                    'garage_boolean' => $garageBoolean,
                    'garage_original_value' => $garageValue,
                ]);
                $q->where('garage_facility', $garageBoolean);
            });
            
            Log::info('Garage Filter Applied', [
                'projects_count_after' => $query->count(),
                'sql_query' => $query->toSql(),
                'sql_bindings' => $query->getBindings(),
            ]);
        }

        // Filter by payment option
        if ($request->filled('payment_option')) {
            $query->where('payment_option', $request->payment_option);
        }

        // Filter by additional options
        if ($request->filled('additional_options')) {
            $options = $request->additional_options;

            $query->whereHas('utility', function ($q) use ($options) {
                foreach ($options as $option) {
                    $q->where($option, 1); // Each option should have a corresponding column in the `utility` table
                }
            });
        }

        // Get projects with applied filters and paginate results
        $projects = $query->orderBy('created_at', 'desc')->paginate(9)->appends($request->query());

        // Log database statistics for garage
        $projectsWithGarage = Project::whereHas('utility', function ($q) {
            $q->where('garage_facility', 1);
        })->count();
        $projectsWithoutGarage = Project::whereHas('utility', function ($q) {
            $q->where('garage_facility', 0);
        })->count();
        $projectsWithoutUtility = Project::whereDoesntHave('utility')->count();
        $totalProjects = Project::count();
        
        // Sample some utility records to see actual values
        $sampleUtilities = Utility::select('id', 'garage_facility')
            ->whereNotNull('garage_facility')
            ->take(5)
            ->get()
            ->toArray();
        
        Log::info('Garage Database Statistics', [
            'projects_with_garage' => $projectsWithGarage,
            'projects_without_garage' => $projectsWithoutGarage,
            'projects_without_utility' => $projectsWithoutUtility,
            'total_projects' => $totalProjects,
            'filtered_results_count' => $projects->total(),
            'sample_utilities' => $sampleUtilities,
        ]);

        // Fetch unique filter options from the database
        $categories = Category::pluck('name', 'id');
        $locations = Project::distinct()->pluck('location_name');
        $paymentOptions = ['Off-Plan', 'Ready'];
        
        // Bedrooms options: 1, 2, 3, 4, 5, 6, 6+
        $bedrooms = collect([1, 2, 3, 4, 5, 6, '6+']);
        
        // Get bathrooms from database and merge with common default values
        $bathroomsFromDb = Utility::distinct()->whereNotNull('bathrooms')->pluck('bathrooms')->filter()->sort()->values();
        $defaultBathrooms = collect([1, 2, 3, 4, 5, 6]);
        $bathrooms = $defaultBathrooms->merge($bathroomsFromDb)->unique()->sort()->values();

        $additionalOptions = [
            'air_conditioning', 'garage_facility', 'swimming_pool', 'fire_security',
            'fire_place_facility', 'play_ground', 'furniture_include', 'marble_floor',
            'store_room', 'high_class_door', 'floor_heating_system', 'garden_include',
            'smart_home_system', 'central_heating_hvac', 'walk_in_closets', 'en_suite_bathrooms',
            'built_in_kitchen_appliances', 'laundry_room', 'bbq_area', 'gated_community_access',
            'guest_house_maids_room', 'private_pool', 'landscaped_garden', 'covered_parking',
            'balcony',
        ];

        // Pass projects and filter options to the view
        return view('website.projects', compact('projects', 'categories', 'locations', 'paymentOptions', 'bedrooms', 'bathrooms', 'additionalOptions'));
    }


    public function show($id)
    {
        $project = Project::findOrFail($id);
        $recentProjects = Project::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        return view('website.projects_show', compact('project', 'recentProjects'));
    }


    public function featured(Request $request)
    {
        // Show off-plan projects from off_plan_projects table (dashboard managed)
        $query = OffPlanProject::where('is_active', true);

        // Initialize an array to collect the active filters
        $activeFilters = [];

        // Apply filters based on request parameters
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('project_name', 'like', '%' . $keyword . '%')
                  ->orWhere('location', 'like', '%' . $keyword . '%')
                  ->orWhere('developer', 'like', '%' . $keyword . '%');
            });
            $activeFilters['keyword'] = $keyword;
        }

        if (!empty($request->category)) {
            $categoryName = $request->category;
            $query->where('development_type', 'like', '%' . $categoryName . '%');
            $activeFilters['category'] = $categoryName;
        }

        if (!empty($request->location)) {
            $query->where('location', 'like', '%' . $request->location . '%');
            $activeFilters['location'] = $request->location;
        }

        // Apply price filter - handle price_range dropdown or min/max inputs
        if ($request->filled('price_range')) {
            $priceRange = explode('-', $request->price_range);
            if (count($priceRange) == 2) {
                $minPrice = (int) $priceRange[0];
                $maxPrice = (int) $priceRange[1];
                if ($minPrice > 0 && $maxPrice > 0) {
                    $query->whereBetween('starting_price', [$minPrice, $maxPrice]);
                    $activeFilters['price_range'] = 'AED ' . number_format($minPrice) . ' - AED ' . number_format($maxPrice);
                } elseif ($minPrice > 0) {
                    $query->where('starting_price', '>=', $minPrice);
                    $activeFilters['price_range'] = 'Min: AED ' . number_format($minPrice);
                } elseif ($maxPrice > 0) {
                    $query->where('starting_price', '<=', $maxPrice);
                    $activeFilters['price_range'] = 'Max: AED ' . number_format($maxPrice);
                }
            }
        } elseif ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->filled('min_price') ? (int) $request->min_price : null;
            $maxPrice = $request->filled('max_price') ? (int) $request->max_price : null;

            if ($minPrice && $maxPrice) {
                $query->whereBetween('starting_price', [$minPrice, $maxPrice]);
                $activeFilters['price_range'] = 'AED ' . number_format($minPrice) . ' - AED ' . number_format($maxPrice);
            } elseif ($minPrice) {
                $query->where('starting_price', '>=', $minPrice);
                $activeFilters['price_range'] = 'Min: AED ' . number_format($minPrice);
            } elseif ($maxPrice) {
                $query->where('starting_price', '<=', $maxPrice);
                $activeFilters['price_range'] = 'Max: AED ' . number_format($maxPrice);
            }
        }

        // Retrieve the filtered and paginated results (including featured projects)
        $featuredProjects = $query->orderBy('created_at', 'desc')->paginate(9)->appends($request->query());

        // Other data for filters
        $categories = OffPlanProject::distinct()->whereNotNull('development_type')->pluck('development_type');
        $locations = OffPlanProject::distinct()->pluck('location');
        
        // Bedrooms options: 1, 2, 3, 4, 5, 6, 6+
        $bedrooms = collect([1, 2, 3, 4, 5, 6, '6+']);
        
        // Payment options
        $paymentOptions = ['Off-Plan', 'Ready'];
        
        // Bathrooms options
        $bathrooms = collect([1, 2, 3, 4, 5, 6]);
        
        // Additional options
        $additionalOptions = [
            'air_conditioning', 'garage_facility', 'swimming_pool', 'fire_security',
            'fire_place_facility', 'play_ground', 'furniture_include', 'marble_floor',
            'store_room', 'high_class_door', 'floor_heating_system', 'garden_include',
            'smart_home_system', 'central_heating_hvac', 'walk_in_closets', 'en_suite_bathrooms',
            'built_in_kitchen_appliances', 'laundry_room', 'bbq_area', 'gated_community_access',
            'guest_house_maids_room', 'private_pool', 'landscaped_garden', 'covered_parking',
            'balcony',
        ];

        // Get header section from CMS
        $headerSection = CmsSection::getByKey('off_plan_projects_header');

        return view('website.featured_projects', compact(
            'featuredProjects', 'categories', 'locations', 'bedrooms', 'paymentOptions', 'bathrooms', 'additionalOptions', 'activeFilters', 'headerSection'
        ));
    }

    public function offPlanListing(Request $request)
    {
        // Show all off-plan projects from Project table (Pixxi data)
        // Get projects where payment_option is 'off-plan' OR rent_or_service is 'new'
        $query = Project::where(function($q) {
            $q->where('payment_option', 'off-plan')
              ->orWhereRaw('LOWER(rent_or_service) = ?', ['new']);
        });
        
        // Exclude HOTEL_APARTMENT properties
        $query->whereDoesntHave('category', function($q) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%hotel%apartment%'])
              ->orWhereRaw('LOWER(name) = ?', ['hotel_apartment'])
              ->orWhereRaw('LOWER(name) = ?', ['hotel apartment']);
        });                

        // Initialize an array to collect the active filters
        $activeFilters = [];

        // Apply filters based on request parameters
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('location_name', 'like', '%' . $keyword . '%')
                  ->orWhere('developer_name', 'like', '%' . $keyword . '%');
            });
            $activeFilters['keyword'] = $keyword;
        }

        if (!empty($request->category)) {
            $categoryName = $request->category;
            $query->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', 'like', '%' . $categoryName . '%');
            });
            $activeFilters['category'] = $categoryName;
        }

        // Apply price filter - handle price_range dropdown
        if ($request->filled('price_range')) {
            $priceRange = explode('-', $request->price_range);
            if (count($priceRange) == 2) {
                $minPrice = (int) $priceRange[0];
                $maxPrice = (int) $priceRange[1];
                if ($maxPrice > 0) {
                    if ($minPrice >= 0 && $maxPrice < 999999999) {
                        $query->whereBetween('price', [$minPrice, $maxPrice]);
                        $activeFilters['price_range'] = 'AED ' . number_format($minPrice) . ' - AED ' . number_format($maxPrice);
                    } elseif ($minPrice >= 0) {
                        $query->where('price', '>=', $minPrice);
                        $activeFilters['price_range'] = 'Min: AED ' . number_format($minPrice);
                    } else {
                        $query->where('price', '<=', $maxPrice);
                        $activeFilters['price_range'] = 'Max: AED ' . number_format($maxPrice);
                    }
                }
            }
        }

        if ($request->filled('bedrooms')) {
            $bedroomsValue = $request->bedrooms;
            $query->whereHas('utility', function ($q) use ($bedroomsValue) {
                if ($bedroomsValue === '6+') {
                    $q->where('bedrooms', '>=', 6);
                } else {
                    $q->where('bedrooms', $bedroomsValue);
                }
            });
            $activeFilters['bedrooms'] = $bedroomsValue;
        }

        // Retrieve the filtered and paginated results
        $offPlanProjects = $query->orderBy('created_at', 'desc')->paginate(9)->appends($request->query());

        // Other data for filters
        $categories = Category::pluck('name', 'id');
        $locations = Project::distinct()->pluck('location_name');
        
        // Bedrooms options: 1, 2, 3, 4, 5, 6, 6+
        $bedrooms = collect([1, 2, 3, 4, 5, 6, '6+']);

        return view('website.off_plan_listing', compact(
            'offPlanProjects', 'categories', 'locations', 'bedrooms', 'activeFilters'
        ));
    }

    public function showOffPlanProject($id)
    {
        $project = OffPlanProject::findOrFail($id);
        // Get only the latest project (excluding current project)
        $latestProject = OffPlanProject::where('id', '!=', $id)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->first();
        return view('website.off_plan_project_show', compact('project', 'latestProject'));
    }




}
