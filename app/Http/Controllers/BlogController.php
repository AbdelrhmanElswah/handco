<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }
    public function index()
    {
        $blogs = Blog::all();
        return view('dashboard.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);

        // Create the blog without the main image first
        $blog = Blog::create($data);

        // Upload the main image and associate it with the blog
        if ($request->hasFile('main_image')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $blog,
                'blogs/main_images',
                'main'
            );
        }

        return redirect()->route('blog.index')->with('success', 'Blog post created successfully.');
    }


    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('dashboard.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);

        // Update the blog data first
        $blog->update($data);

        // Update the main image if a new one is uploaded
        if ($request->hasFile('main_image')) {
            // Delete the existing main image if it exists
            if ($blog->mainImage) {
                $blog->mainImage->delete();
            }

            // Upload the new main image and associate it with the blog
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $blog,
                'blogs/main_images',
                'main'
            );
        }

        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully.');
    }


    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
