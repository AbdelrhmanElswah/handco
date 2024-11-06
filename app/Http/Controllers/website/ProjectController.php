<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(9);
        return view('website.projects', compact('projects'));
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
