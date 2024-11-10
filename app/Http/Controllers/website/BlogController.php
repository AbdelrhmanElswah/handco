<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Project;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function showBlogs()
    {
        $blogs = Blog::with('category') // Load category relationship if exists
        ->orderBy('created_at', 'desc')
            ->paginate(6); // Paginate with 6 items per page

        return view('website.blogs', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::with('category', 'mainImage')->findOrFail($id);
        $recentProjects = Project::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        return view('website.blog_show', compact('blog','recentProjects'));
    }

}
