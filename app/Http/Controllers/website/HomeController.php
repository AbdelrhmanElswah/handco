<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch the top 3 featured projects for "Most Popular Projects"
        $popularProjects = Project::where('featured', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Fetch the latest projects for "Recent Projects"
        $recentProjects = Project::latest()
            ->take(3)
            ->get();

        return view('website.index', compact('popularProjects', 'recentProjects'));
    }



}
