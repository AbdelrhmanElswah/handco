<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        // Apply filters based on request parameters
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
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
        // Show only off-plan projects
        $query = Project::where('featured', true)
            ->where('payment_option', 'off-plan');                

        // Initialize an array to collect the active filters
        $activeFilters = [];

        // Apply filters based on request parameters
        if (!empty($request->keyword)) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
            $activeFilters['keyword'] = $request->keyword;
        }

        if (!empty($request->category)) {
            $query->where('category_id', $request->category);
            $activeFilters['category'] = Category::find($request->category)->name ?? 'Unknown Category';
        }

        if (!empty($request->location)) {
            $query->where('location_name', 'like', '%' . $request->location . '%');
            $activeFilters['location'] = $request->location;
        }

        // Apply price filter
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->filled('min_price') ? (int) $request->min_price : null;
            $maxPrice = $request->filled('max_price') ? (int) $request->max_price : null;

            if ($minPrice && $maxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
                $activeFilters['price_range'] = '$' . number_format($minPrice) . ' - $' . number_format($maxPrice);
            } elseif ($minPrice) {
                $query->where('price', '>=', $minPrice);
                $activeFilters['price_range'] = 'Min: $' . number_format($minPrice);
            } elseif ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
                $activeFilters['price_range'] = 'Max: $' . number_format($maxPrice);
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

        if ($request->filled('bathrooms')) {
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('bathrooms', $request->bathrooms);
            });
            $activeFilters['bathrooms'] = $request->bathrooms;
        }

        if ($request->filled('garage')) {
            $garageValue = $request->garage;
            $garageBoolean = $garageValue == 'Yes' ? 1 : 0;
            
            Log::info('Featured Projects - Garage Filter Debug', [
                'garage_request_value' => $garageValue,
                'garage_value_type' => gettype($garageValue),
                'garage_boolean_value' => $garageBoolean,
                'comparison_Yes' => $garageValue == 'Yes',
                'comparison_Yes_strict' => $garageValue === 'Yes',
            ]);
            
            $query->whereHas('utility', function ($q) use ($garageBoolean) {
                $q->where('garage_facility', $garageBoolean);
            });
            $activeFilters['garage'] = $garageValue;
        }

        if (!empty($request->payment_option)) {
            $query->where('payment_option', $request->payment_option);
            $activeFilters['payment_option'] = $request->payment_option;
        }

        // Apply filters for additional options
        if ($request->filled('additional_options')) {
            $options = $request->additional_options;

            $query->whereHas('utility', function ($q) use ($options) {
                foreach ($options as $option) {
                    $q->where($option, 1); // Each option should have a corresponding column in the `utility` table
                }
            });

            $activeFilters['additional_options'] = $options;
        }

        // Retrieve the filtered and paginated results
        $featuredProjects = $query->orderBy('created_at', 'desc')->paginate(9)->appends($request->query());

        // Other data for filters
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

        return view('website.featured_projects', compact(
            'featuredProjects', 'categories', 'locations', 'paymentOptions', 'bedrooms', 'bathrooms', 'additionalOptions', 'activeFilters'
        ));
    }




}
