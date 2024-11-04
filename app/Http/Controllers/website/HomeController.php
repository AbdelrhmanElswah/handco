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
            ->get()
            ->map(function ($project) {
                $this->extractLocationDetails($project);
                return $project;
            });

        // Fetch the latest projects for "Recent Projects"
        $recentProjects = Project::latest()
            ->take(3)
            ->get()
            ->map(function ($project) {
                $this->extractLocationDetails($project);
                return $project;
            });

        return view('website.index', compact('popularProjects', 'recentProjects'));
    }

    protected function extractLocationDetails($project)
    {
        if (preg_match('/^(.*)\s+\((https?.*)\)$/', $project->location, $matches)) {
            $project->location_name = $matches[1];
            $project->location_link = $matches[2];
        } else {
            $project->location_name = $project->location;
            $project->location_link = "https://www.google.com/maps/search/?api=1&query=" . urlencode($project->location);
        }

    }


}
