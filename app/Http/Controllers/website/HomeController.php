<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CmsSection;
use App\Models\Project;
use App\Models\Slider;
use App\Models\Utility;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Initialize base query for filtered projects
        $baseQuery = Project::query();
        $sliders = Slider::with('mainImage')->get();
        $latestBlogs = Blog::with('mainImage')->latest()->take(3)->get();


        // Apply search filters
        if ($request->filled('keyword')) {
            $baseQuery->where('title', 'like', '%' . $request->keyword . '%');
        }

        // Filter by category (by name)
        if ($request->filled('category')) {
            $categoryName = $request->category;
            $baseQuery->whereHas('category', function ($q) use ($categoryName) {
                $q->where('name', 'like', '%' . $categoryName . '%');
            });
        }

        if ($request->filled('location')) {
            $baseQuery->where('location_name', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->filled('min_price') ? (int) $request->min_price : null;
            $maxPrice = $request->filled('max_price') ? (int) $request->max_price : null;

            if ($minPrice && $maxPrice) {
                $baseQuery->whereBetween('price', [$minPrice, $maxPrice]);
            } elseif ($minPrice) {
                $baseQuery->where('price', '>=', $minPrice);
            } elseif ($maxPrice) {
                $baseQuery->where('price', '<=', $maxPrice);
            }
        }

        if ($request->filled('additional_options')) {
            $options = $request->additional_options;

            $baseQuery->whereHas('utility', function ($q) use ($options) {
                foreach ($options as $option) {
                    $q->where($option, 1); // Assuming each option corresponds to a boolean column in utilities
                }
            });
        }

        // Clone base query to use for different sections with additional conditions
        $popularProjectsQuery = clone $baseQuery;
        $recentProjectsQuery = clone $baseQuery;

        // Fetch the top 3 featured off-plan projects for "Featured Projects"
        $popularProjects = $popularProjectsQuery->where('featured', true)
            ->where('rent_or_service', 'sell')
            ->where('payment_option', 'off-plan')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Fetch the latest projects for "Recent Projects"
        $recentProjects = $recentProjectsQuery->latest()
            ->take(3)
            ->get();

        // Execute the filtered projects query with pagination for main listing
        $filteredProjects = $baseQuery->orderBy('created_at', 'desc')->paginate(9)->appends($request->query());

        // Fetch unique filter options from the database
        $categories = Category::pluck('name', 'id');
        $locations = Project::distinct()->pluck('location_name');
        $paymentOptions = ['Off-Plan', 'Ready'];
        $bedrooms = Utility::distinct()->pluck('bedrooms');
        $bathrooms = Utility::distinct()->pluck('bathrooms');
        $additionalOptions = [
            'air_conditioning', 'garage_facility', 'swimming_pool', 'fire_security',
            'fire_place_facility', 'play_ground', 'furniture_include', 'marble_floor',
            'store_room', 'high_class_door', 'floor_heating_system', 'garden_include',
            'smart_home_system', 'central_heating_hvac', 'walk_in_closets', 'en_suite_bathrooms',
            'built_in_kitchen_appliances', 'laundry_room', 'bbq_area', 'gated_community_access',
            'guest_house_maids_room', 'private_pool', 'landscaped_garden', 'covered_parking',
            'balcony',
        ];

        // Fetch All Categories For Section
        $allCategories = Category::all();

        // Fetch CMS Sections
        $mainServicesSection = CmsSection::getByKey('main_services');
        $countingSection = CmsSection::getByKey('counting_section');
        $testimonialsSection = CmsSection::getByKey('testimonials_section');
        $faqSection = CmsSection::getByKey('faq_section');

        // Pass variables to the view
        return view('website.index', compact(
            'popularProjects',
            'recentProjects',
            'filteredProjects',
            'categories',
            'locations',
            'paymentOptions',
            'bedrooms',
            'bathrooms',
            'additionalOptions',
            'sliders',
            'latestBlogs',
            'allCategories',
            'mainServicesSection',
            'countingSection',
            'testimonialsSection',
            'faqSection'

        ));
    }

}
