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
        return view('dashboard.project.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::all();
        $utilities = Utility::all();
        return view('dashboard.project.create', compact('categories', 'utilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'location_name' => 'required|string|max:255',
            'location_link' => 'required|url', // Validate the Google Maps link
            'tags' => 'nullable|array',
            'description' => 'nullable|string',
            'utilities_id' => 'required|exists:utilities,id',
            'floor_area' => 'nullable|integer',
            'featured' => 'boolean',
            'status' => 'required|string|in:available,sold_out', // Validation for status
            'selling_points' => 'nullable|array', // Validation for selling_points as an array
            'selling_points.*.label' => 'required_with:selling_points|string', // Label for each selling point
            'selling_points.*.value' => 'required_with:selling_points|string', // Value for each selling point
            'more_information' => 'nullable|array', // Validation for more_information as an array
            'more_information.*.label' => 'required_with:more_information|string', // Label for each additional info
            'more_information.*.value' => 'required_with:more_information|string', // Value for each additional info
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Include the combined `location` field in the data to be saved
        $projectData = $request->except(['main_image', 'images']);

        // Create the project without images
        $project = Project::create($projectData);

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

    public function edit(Project $project)
    {
        $categories = Category::all();
        $utilities = Utility::all();

        return view('dashboard.project.edit', compact('project', 'categories', 'utilities'));
    }


    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'category_id' => 'sometimes|required|exists:categories,id',
            'location_name' => 'sometimes|string',
            'location_link' => 'sometimes|url',
            'tags' => 'sometimes|nullable|array',
            'description' => 'sometimes|nullable|string',
            'utilities_id' => 'sometimes|required|exists:utilities,id',
            'floor_area' => 'sometimes|nullable|integer',
            'featured' => 'sometimes|required|boolean',
            'status' => 'sometimes|required|string|in:available,sold_out',
            'selling_points' => 'sometimes|nullable|array',
            'selling_points.*.label' => 'sometimes|required_with:selling_points|string',
            'selling_points.*.value' => 'sometimes|required_with:selling_points|string',
            'more_information' => 'sometimes|nullable|array',
            'more_information.*.label' => 'sometimes|required_with:more_information|string',
            'more_information.*.value' => 'sometimes|required_with:more_information|string',
            'main_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data for updating
        $projectData = $request->except(['main_image', 'images']);

        // Update the project
        $project->update($projectData);

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
