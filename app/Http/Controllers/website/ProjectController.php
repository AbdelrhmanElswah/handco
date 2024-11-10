<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Utility;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        // Start a query for Project model
        $query = Project::query();

        // Apply filters based on request parameters
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('location', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereBetween('price', [
                $request->input('min_price', 0),
                $request->input('max_price', PHP_INT_MAX)
            ]);
        }

        if ($request->filled('bedrooms')) {
            $query->whereHas('utility', function ($q) use ($request) {
                $q->where('bedrooms', $request->bedrooms);
            });
        }

        // Get projects with applied filters and paginate results
        $projects = $query->orderBy('created_at', 'desc')->paginate(9);

        // Fetch unique filter options from the database
        $categories = Category::pluck('name', 'id');
        $locations = Project::distinct()->pluck('location');
        $paymentOptions = ['Cash', 'Installment']; // Define if fixed options
        $bedrooms = Utility::distinct()->pluck('bedrooms');
        $bathrooms = Utility::distinct()->pluck('bathrooms');

        $additionalOptions = [
            'Air Conditioning',
            'Garage Facility',
            'Swimming Pool',
            'Fire Security',
            'Fire Place Facility',
            'Play Ground',
            'Furniture Include',
            'Marble Floor',
            'Store Room',
            'High-Class Door',
            'Floor Heating System',
            'Garden Include',
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


    public function featured()
    {
        $featuredProjects = Project::where('featured', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('website.featured_projects', compact('featuredProjects'));
    }
}
