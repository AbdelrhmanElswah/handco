<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CmsSection;
use App\Models\OffPlanProject;
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
        $sliders = Slider::with(['mainImage', 'mainVideo'])->get();
        
        // Log sliders data for debugging
        \Log::info('Sliders Data:', [
            'count' => $sliders->count(),
            'sliders' => $sliders->map(function($slider) {
                return [
                    'id' => $slider->id,
                    'title' => $slider->title,
                    'subtitle' => $slider->subtitle,
                    'description' => $slider->description ? substr($slider->description, 0, 50) . '...' : null,
                    'button_text' => $slider->button_text,
                    'button_link' => $slider->button_link,
                    'media_type' => $slider->media_type,
                    'has_main_image' => $slider->mainImage ? true : false,
                    'main_image_link' => $slider->mainImage ? $slider->mainImage->media_link : null,
                    'has_main_video' => $slider->mainVideo ? true : false,
                    'main_video_link' => $slider->mainVideo ? $slider->mainVideo->media_link : null,
                ];
            })->toArray()
        ]);
        $latestBlogs = Blog::with('mainImage')->latest()->take(3)->get();

        // Filter by listing type (Buy = sell, Rent = rent, Off Plan = new)
        // Make sure Buy shows only "for Sale" properties, Rent shows only "for Rent" properties, and Off Plan shows "new" properties
        $listingType = strtolower($request->get('listingType', ''));
        if ($listingType === 'buy') {
            // Only show properties for sale (rent_or_service = 'sell')
            // Use LOWER() to handle any case sensitivity issues
            $baseQuery->whereRaw('LOWER(rent_or_service) = ?', ['sell']);
        } elseif ($listingType === 'rent') {
            // Only show properties for rent (rent_or_service = 'rent')
            // Use LOWER() to handle any case sensitivity issues
            $baseQuery->whereRaw('LOWER(rent_or_service) = ?', ['rent']);
        } elseif ($listingType === 'off-plan') {
            // Only show off-plan properties (rent_or_service = 'new')
            // Use LOWER() to handle any case sensitivity issues
            $baseQuery->whereRaw('LOWER(rent_or_service) = ?', ['new']);
        }

        // Exclude HOTEL_APARTMENT properties
        $baseQuery->whereDoesntHave('category', function($q) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%hotel%apartment%'])
              ->orWhereRaw('LOWER(name) = ?', ['hotel_apartment'])
              ->orWhereRaw('LOWER(name) = ?', ['hotel apartment']);
        });

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

        // Handle price range from dropdown or min/max inputs
        if ($request->filled('price_range')) {
            $priceRange = explode('-', $request->price_range);
            if (count($priceRange) == 2) {
                $minPrice = (int) $priceRange[0];
                $maxPrice = (int) $priceRange[1];
                if ($minPrice > 0 && $maxPrice > 0) {
                    $baseQuery->whereBetween('price', [$minPrice, $maxPrice]);
                } elseif ($minPrice > 0) {
                    $baseQuery->where('price', '>=', $minPrice);
                } elseif ($maxPrice > 0) {
                    $baseQuery->where('price', '<=', $maxPrice);
                }
            }
        } elseif ($request->filled('min_price') || $request->filled('max_price')) {
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

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $bedroomsValue = $request->bedrooms;
            $baseQuery->whereHas('utility', function ($q) use ($bedroomsValue) {
                if ($bedroomsValue === '6+') {
                    $q->where('bedrooms', '>=', 6);
                } else {
                    $q->where('bedrooms', $bedroomsValue);
                }
            });
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
        $recentProjectsQuery = clone $baseQuery;

        // Fetch all featured projects for "Off Plan Projects" section from off_plan_projects table
        // Show all featured projects on homepage
        $popularProjects = OffPlanProject::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
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

        // Get current listing type for view
        $currentListingType = $listingType ? strtolower($listingType) : '';

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
            'faqSection',
            'currentListingType'

        ));
    }

}
