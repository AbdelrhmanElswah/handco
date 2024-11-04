<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->take(3)->get();
        return view('website.index', compact('projects'));
    }
}
