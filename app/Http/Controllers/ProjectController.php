<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Utility;
use Illuminate\Http\Request;
use App\Services\MediaUploadService;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::all();
        $utilities = Utility::all();
        return view('projects.create', compact('categories', 'utilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string',
            'tags' => 'nullable|array',
            'description' => 'nullable|string',
            'utilities_id' => 'required|exists:utilities,id',
            'floor_area' => 'nullable|integer',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the project without images
        $project = Project::create($request->except(['main_image', 'images']));

        // Upload the main image
        if ($request->hasFile('main_image')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $project,
                'projects/main_images',
                'main'
            );
        }

        // Upload additional images
        if ($request->hasFile('images')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('images'),
                $project,
                'projects/images',
                'additional'
            );
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $categories = Category::all();
        $utilities = Utility::all();
        return view('projects.edit', compact('project', 'categories', 'utilities'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string',
            'tags' => 'nullable|array',
            'description' => 'nullable|string',
            'utilities_id' => 'required|exists:utilities,id',
            'floor_area' => 'nullable|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update project details
        $project->update($request->except(['main_image', 'images']));

        // Replace main image if a new one is uploaded
        if ($request->hasFile('main_image')) {
            if ($project->mainImage) {
                Storage::disk('public')->delete('files/projects/main_images/' . $project->mainImage->media);
                $project->mainImage()->delete();
            }
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $project,
                'projects/main_images',
                'main'
            );
        }

        // Replace additional images if new ones are uploaded
        if ($request->hasFile('images')) {
            foreach ($project->images as $oldImage) {
                Storage::disk('public')->delete('files/projects/images/' . $oldImage->media);
                $oldImage->delete();
            }
            $this->mediaUploadService->uploadMedia(
                $request->file('images'),
                $project,
                'projects/images',
                'additional'
            );
        }

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Delete the main image if it exists
        if ($project->mainImage) {
            Storage::disk('public')->delete('files/projects/main_images/' . $project->mainImage->media);
            $project->mainImage()->delete();
        }

        // Delete additional images
        foreach ($project->images as $image) {
            Storage::disk('public')->delete('files/projects/images/' . $image->media);
            $image->delete();
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
