<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Services\MediaUploadService;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    /**
     * Display a listing of the sliders.
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('dashboard.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create()
    {
        return view('dashboard.slider.create');
    }

    /**
     * Store a newly created slider in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the slider data
        $sliderData = $request->except(['main_image']);
        $slider = Slider::create($sliderData);

        // Upload the main image
        if ($request->hasFile('main_image')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $slider,
                'sliders/main_images',
                'main'
            );
        }


        return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider)
    {
        return view('dashboard.slider.edit', compact('slider'));
    }

    /**
     * Update the specified slider in the database.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update slider data
        $slider->update($request->except(['main_image', 'images']));

        // Replace the main image if a new one is uploaded
        if ($request->hasFile('main_image')) {
            // Delete the old main image
            if ($slider->mainImage) {
                $s3Key = config('filesystems.disks.s3.key');
                $s3Url = config('filesystems.disks.s3.url');
                $isLocal = app()->environment('local') || !$s3Key || !$s3Url;
                
                if ($isLocal) {
                    // Delete from local storage
                    $filePath = public_path('files/sliders/main_images/' . $slider->mainImage->media);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } else {
                    // Delete from S3
                    $s3Path = 'handco/sliders/main_images/' . $slider->mainImage->media;
                    Storage::disk('s3')->delete($s3Path);
                }
                $slider->mainImage()->delete();
            }

            // Upload the new main image
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $slider,
                'sliders/main_images',
                'main'
            );
        }


        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified slider from the database.
     */
    public function destroy(Slider $slider)
    {
        // Delete the main image
        if ($slider->mainImage) {
            $s3Key = config('filesystems.disks.s3.key');
            $s3Url = config('filesystems.disks.s3.url');
            $isLocal = app()->environment('local') || !$s3Key || !$s3Url;
            
            if ($isLocal) {
                // Delete from local storage
                $filePath = public_path('files/sliders/main_images/' . $slider->mainImage->media);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                // Delete from S3
                $s3Path = 'handco/sliders/main_images/' . $slider->mainImage->media;
                Storage::disk('s3')->delete($s3Path);
            }
            $slider->mainImage()->delete();
        }

        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
