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
        $projects = Project::with('utility')->get();
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

        $checkboxFields = [
            'swimming_pool',
            'gym',
            'garden',
            'air_conditioning',
            'furnished',
            'garage_facility',
            'fire_security',
            'fire_place_facility',
            'play_ground',
            'marble_floor',
            'store_room',
            'high_class_door',
            'floor_heating_system',
            'balcony',
            'view_of_landmarks',
            'built_in_wardrobes'

        ];

        foreach ($checkboxFields as $field) {
            $request->merge([
                $field => $request->has($field) ? true : false,
            ]);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'location_name' => 'required|string|max:255',
            'location_link' => 'nullable|url',
            'tags' => 'nullable|array',
            'description' => 'nullable|string',
            'floor_area' => 'nullable|integer',
            'featured' => 'boolean',
            'status' => 'nullable|string|in:available,sold_out',
            'rent_or_service' => 'nullable|string|in:rent,sale',
            'selling_points' => 'nullable|array',
            'selling_points.*.label' => 'required_with:selling_points|string',
            'selling_points.*.value' => 'required_with:selling_points|string',
            'more_information' => 'nullable|array',
            'more_information.*.label' => 'required_with:more_information|string',
            'more_information.*.value' => 'required_with:more_information|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',




            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'swimming_pool' => 'boolean',
            'gym' => 'boolean',
            'garden' => 'boolean',
            'air_conditioning' => 'boolean',
            'furnished' => 'boolean',
            'garage_facility' => 'boolean',
            'fire_security' => 'boolean',
            'fire_place_facility' => 'boolean',
            'play_ground' => 'boolean',
            'marble_floor' => 'boolean',
            'store_room' => 'boolean',
            'high_class_door' => 'boolean',
            'floor_heating_system' => 'boolean',
            'balcony' => 'boolean',
            'view_of_landmarks' => 'boolean',
            'built_in_wardrobes' => 'boolean'
        ]);



        $utilityData = [
            'bedrooms' => max(0, (int)$request->input('bedrooms')),
            'bathrooms' => max(0, (int)$request->input('bathrooms')),
            'swimming_pool' => $request->input('swimming_pool'),
            'gym' => $request->input('gym'),
            'garden' => $request->input('garden'),
            'air_conditioning' => $request->input('air_conditioning'),
            'furnished' => $request->input('furnished'),
            'garage_facility' => $request->input('garage_facility'),
            'fire_security' => $request->input('fire_security'),
            'fire_place_facility' => $request->input('fire_place_facility'),
            'play_ground' => $request->input('play_ground'),
            'marble_floor' => $request->input('marble_floor'),
            'store_room' => $request->input('store_room'),
            'high_class_door' => $request->input('high_class_door'),
            'floor_heating_system' => $request->input('floor_heating_system'),
            'balcony' => $request->input('balcony'),
            'view_of_landmarks' => $request->input('view_of_landmarks'),
            'built_in_wardrobes' => $request->input('built_in_wardrobes'),

        ];


        // Create the utility record
        $utility = Utility::create($utilityData);

        // Include the combined `location` field in the data to be saved
        $projectData = $request->except(['main_image', 'images', 'utilities_id']);
        $projectData['utilities_id'] = $utility->id;
        $projectData['rent_or_service'] = $request->rent_or_service;

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
        $checkboxFields = [
            'swimming_pool',
            'gym',
            'garden',
            'air_conditioning',
            'furnished',
            'garage_facility',
            'fire_security',
            'fire_place_facility',
            'play_ground',
            'marble_floor',
            'store_room',
            'high_class_door',
            'floor_heating_system',
            'balcony',
            'view_of_landmarks',
            'built_in_wardrobes'
        ];

        foreach ($checkboxFields as $field) {
            $request->merge([
                $field => $request->has($field) ? true : false,
            ]);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'category_id' => 'sometimes|required|exists:categories,id',
            'location_name' => 'sometimes|string',
            'location_link' => 'sometimes|nullable|url',
            'tags' => 'sometimes|nullable|array',
            'description' => 'sometimes|nullable|string',
            'floor_area' => 'sometimes|nullable|integer',
            'featured' => 'sometimes|required|boolean',
            'status' => 'sometimes|required|string|in:available,sold_out',
            'rent_or_service' => 'nullable|string|in:rent,sale',
            'selling_points' => 'sometimes|nullable|array',
            'selling_points.*.label' => 'sometimes|required_with:selling_points|string',
            'selling_points.*.value' => 'sometimes|required_with:selling_points|string',
            'more_information' => 'sometimes|nullable|array',
            'more_information.*.label' => 'sometimes|required_with:more_information|string',
            'more_information.*.value' => 'sometimes|required_with:more_information|string',
            'main_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',



            // Validate utility fields
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'swimming_pool' => 'boolean',
            'gym' => 'boolean',
            'garden' => 'boolean',
            'air_conditioning' => 'boolean',
            'furnished' => 'boolean',
            'garage_facility' => 'boolean',
            'fire_security' => 'boolean',
            'fire_place_facility' => 'boolean',
            'play_ground' => 'boolean',
            'marble_floor' => 'boolean',
            'store_room' => 'boolean',
            'high_class_door' => 'boolean',
            'floor_heating_system' => 'boolean',
            'balcony' => 'boolean',
            'view_of_landmarks' => 'boolean',
            'built_in_wardrobes' => 'boolean'
        ]);

        // Prepare utility data
        $utilityData = [
            'bedrooms' => max(0, (int)$request->input('bedrooms')),
            'bathrooms' => max(0, (int)$request->input('bathrooms')),
            'swimming_pool' => $request->input('swimming_pool'),
            'gym' => $request->input('gym'),
            'garden' => $request->input('garden'),
            'air_conditioning' => $request->input('air_conditioning'),
            'furnished' => $request->input('furnished'),
            'garage_facility' => $request->input('garage_facility'),
            'fire_security' => $request->input('fire_security'),
            'fire_place_facility' => $request->input('fire_place_facility'),
            'play_ground' => $request->input('play_ground'),
            'marble_floor' => $request->input('marble_floor'),
            'store_room' => $request->input('store_room'),
            'high_class_door' => $request->input('high_class_door'),
            'floor_heating_system' => $request->input('floor_heating_system'),
            'balcony' => $request->input('balcony'),
            'view_of_landmarks' => $request->input('view_of_landmarks'),
            'built_in_wardrobes' => $request->input('built_in_wardrobes'),
        ];

        $utility = $project->utility;
        $utility->update($utilityData);


        // Prepare data for updating
        $projectData = $request->except(['main_image', 'images', 'utilities_id']);
        $projectData['rent_or_service'] = $request->rent_or_service;

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
