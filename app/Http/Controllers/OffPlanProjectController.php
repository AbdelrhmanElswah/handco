<?php

namespace App\Http\Controllers;

use App\Models\OffPlanProject;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OffPlanProjectController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    public function index()
    {
        $projects = OffPlanProject::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.off-plan-projects.index', compact('projects'));
    }

    public function create()
    {
        return view('dashboard.off-plan-projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'location_link' => 'nullable|url',
            'starting_price' => 'nullable|numeric',
            'completion_date' => 'nullable|string|max:255',
            'development_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'overview' => 'nullable|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['main_image', 'gallery_images', 'key_features', 'payment_plan', 'nearby_attractions']);

        // Handle key_features
        if ($request->filled('key_features')) {
            $keyFeatures = [];
            foreach ($request->key_features as $feature) {
                if (!empty($feature)) {
                    $keyFeatures[] = $feature;
                }
            }
            $data['key_features'] = !empty($keyFeatures) ? $keyFeatures : null;
        }

        // Handle payment_plan
        if ($request->filled('payment_plan_title') && $request->filled('payment_plan_percentage')) {
            $paymentPlan = [];
            for ($i = 0; $i < count($request->payment_plan_title); $i++) {
                if (!empty($request->payment_plan_title[$i])) {
                    $paymentPlan[] = [
                        'title' => $request->payment_plan_title[$i],
                        'percentage' => $request->payment_plan_percentage[$i] ?? null,
                        'description' => $request->payment_plan_description[$i] ?? null,
                    ];
                }
            }
            $data['payment_plan'] = !empty($paymentPlan) ? $paymentPlan : null;
        }

        // Handle nearby_attractions
        if ($request->filled('nearby_attractions_time') && $request->filled('nearby_attractions_name')) {
            $attractions = [];
            for ($i = 0; $i < count($request->nearby_attractions_name); $i++) {
                if (!empty($request->nearby_attractions_name[$i])) {
                    $attractions[] = [
                        'time' => $request->nearby_attractions_time[$i] ?? null,
                        'name' => $request->nearby_attractions_name[$i],
                    ];
                }
            }
            $data['nearby_attractions'] = !empty($attractions) ? $attractions : null;
        }

        // Create the project
        $project = OffPlanProject::create($data);

        // Upload main image
        if ($request->hasFile('main_image')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $project,
                'off-plan-projects/main_images',
                'main'
            );
        }

        // Upload gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $this->mediaUploadService->uploadMedia(
                    $image,
                    $project,
                    'off-plan-projects/gallery',
                    'gallery'
                );
            }
        }

        return redirect()->route('off-plan-projects.index')->with('success', 'Off Plan Project created successfully.');
    }

    public function edit(OffPlanProject $offPlanProject)
    {
        return view('dashboard.off-plan-projects.edit', compact('offPlanProject'));
    }

    public function update(Request $request, OffPlanProject $offPlanProject)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'location_link' => 'nullable|url',
            'starting_price' => 'nullable|numeric',
            'completion_date' => 'nullable|string|max:255',
            'development_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'overview' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['main_image', 'gallery_images', 'key_features', 'payment_plan', 'nearby_attractions']);

        // Handle key_features
        if ($request->filled('key_features')) {
            $keyFeatures = [];
            foreach ($request->key_features as $feature) {
                if (!empty($feature)) {
                    $keyFeatures[] = $feature;
                }
            }
            $data['key_features'] = !empty($keyFeatures) ? $keyFeatures : null;
        } else {
            $data['key_features'] = null;
        }

        // Handle payment_plan
        if ($request->filled('payment_plan_title') && $request->filled('payment_plan_percentage')) {
            $paymentPlan = [];
            for ($i = 0; $i < count($request->payment_plan_title); $i++) {
                if (!empty($request->payment_plan_title[$i])) {
                    $paymentPlan[] = [
                        'title' => $request->payment_plan_title[$i],
                        'percentage' => $request->payment_plan_percentage[$i] ?? null,
                        'description' => $request->payment_plan_description[$i] ?? null,
                    ];
                }
            }
            $data['payment_plan'] = !empty($paymentPlan) ? $paymentPlan : null;
        } else {
            $data['payment_plan'] = null;
        }

        // Handle nearby_attractions
        if ($request->filled('nearby_attractions_time') && $request->filled('nearby_attractions_name')) {
            $attractions = [];
            for ($i = 0; $i < count($request->nearby_attractions_name); $i++) {
                if (!empty($request->nearby_attractions_name[$i])) {
                    $attractions[] = [
                        'time' => $request->nearby_attractions_time[$i] ?? null,
                        'name' => $request->nearby_attractions_name[$i],
                    ];
                }
            }
            $data['nearby_attractions'] = !empty($attractions) ? $attractions : null;
        } else {
            $data['nearby_attractions'] = null;
        }

        // Update the project
        $offPlanProject->update($data);

        // Replace main image if a new one is uploaded
        if ($request->hasFile('main_image')) {
            if ($offPlanProject->mainImage) {
                Storage::disk('public')->delete('files/off-plan-projects/main_images/' . $offPlanProject->mainImage->media);
                $offPlanProject->mainImage()->delete();
            }
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $offPlanProject,
                'off-plan-projects/main_images',
                'main'
            );
        }

        // Add new gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $this->mediaUploadService->uploadMedia(
                    $image,
                    $offPlanProject,
                    'off-plan-projects/gallery',
                    'gallery'
                );
            }
        }

        return redirect()->route('off-plan-projects.index')->with('success', 'Off Plan Project updated successfully.');
    }

    public function destroy(OffPlanProject $offPlanProject)
    {
        // Delete main image
        if ($offPlanProject->mainImage) {
            Storage::disk('public')->delete('files/off-plan-projects/main_images/' . $offPlanProject->mainImage->media);
            $offPlanProject->mainImage()->delete();
        }

        // Delete gallery images
        foreach ($offPlanProject->galleryImages as $image) {
            Storage::disk('public')->delete('files/off-plan-projects/gallery/' . $image->media);
            $image->delete();
        }

        $offPlanProject->delete();
        return redirect()->route('off-plan-projects.index')->with('success', 'Off Plan Project deleted successfully.');
    }
}

