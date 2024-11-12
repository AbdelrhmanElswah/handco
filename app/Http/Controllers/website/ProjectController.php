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
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('bedrooms', $request->bedrooms);
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
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('garage_facility', $request->garage == 'Yes' ? 1 : 0);
            });
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
        $projects = $query->orderBy('created_at', 'desc')->paginate(9);

        // Fetch unique filter options from the database
        $categories = Category::pluck('name', 'id');
        $locations = Project::distinct()->pluck('location_name');
        $paymentOptions = ['Cash', 'Installment'];
        $bedrooms = Utility::distinct()->pluck('bedrooms');
        $bathrooms = Utility::distinct()->pluck('bathrooms');

        $additionalOptions = [
            'air_conditioning', 'garage_facility', 'swimming_pool', 'fire_security',
            'fire_place_facility', 'play_ground', 'furniture_include', 'marble_floor',
            'store_room', 'high_class_door', 'floor_heating_system', 'garden_include',
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
        $query = Project::where('featured', true);

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
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('bedrooms', $request->bedrooms);
            });
            $activeFilters['bedrooms'] = $request->bedrooms;
        }

        if ($request->filled('bathrooms')) {
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('bathrooms', $request->bathrooms);
            });
            $activeFilters['bathrooms'] = $request->bathrooms;
        }

        if ($request->filled('garage')) {
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('garage_facility', $request->garage == 'Yes' ? 1 : 0);
            });
            $activeFilters['garage'] = $request->garage;
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
        $featuredProjects = $query->orderBy('created_at', 'desc')->paginate(9);

        // Other data for filters
        $categories = Category::pluck('name', 'id');
        $locations = Project::distinct()->pluck('location_name');
        $paymentOptions = ['Cash', 'Installment'];
        $bedrooms = Utility::distinct()->pluck('bedrooms');
        $bathrooms = Utility::distinct()->pluck('bathrooms');
        $additionalOptions = [
            'air_conditioning', 'garage_facility', 'swimming_pool', 'fire_security',
            'fire_place_facility', 'play_ground', 'furniture_include', 'marble_floor',
            'store_room', 'high_class_door', 'floor_heating_system', 'garden_include',
        ];

        return view('website.featured_projects', compact(
            'featuredProjects', 'categories', 'locations', 'paymentOptions', 'bedrooms', 'bathrooms', 'additionalOptions', 'activeFilters'
        ));
    }




}
