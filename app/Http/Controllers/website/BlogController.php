<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
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
}
