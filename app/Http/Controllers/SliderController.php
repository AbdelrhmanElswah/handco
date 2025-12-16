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
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the slider data
        $sliderData = $request->except(['main_image', 'main_video']);
        // Set media_type based on what was uploaded
        if ($request->hasFile('main_video')) {
            $sliderData['media_type'] = 'video';
        } elseif ($request->hasFile('main_image')) {
            $sliderData['media_type'] = 'image';
        } else {
            $sliderData['media_type'] = $request->input('media_type', 'image');
        }
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

        // Upload the main video
        if ($request->hasFile('main_video')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('main_video'),
                $slider,
                'sliders/main_videos',
                'video'
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
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|url',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_video' => 'nullable|mimes:mp4,webm,ogg|max:10240', // Max 10MB
            'media_type' => 'nullable|in:image,video',
        ]);

        // Update slider data
        $updateData = $request->except(['main_image', 'main_video', 'images']);
        // Set media_type based on what was uploaded
        if ($request->hasFile('main_video')) {
            $updateData['media_type'] = 'video';
        } elseif ($request->hasFile('main_image')) {
            $updateData['media_type'] = 'image';
        } elseif ($request->has('media_type')) {
            $updateData['media_type'] = $request->input('media_type');
        }
        $slider->update($updateData);

        // Delete old media if switching type
        if ($request->has('media_type') && $request->input('media_type') != $slider->media_type) {
            if ($slider->mainImage) {
                $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
                $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
                $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
                $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
                $isLocal = in_array(app()->environment(), ['local', 'testing']) || !$s3Configured;
                
                if ($isLocal) {
                    $filePath = public_path('files/sliders/main_images/' . $slider->mainImage->media);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } else {
                    $s3Path = 'handco/sliders/main_images/' . $slider->mainImage->media;
                    Storage::disk('s3')->delete($s3Path);
                }
                $slider->mainImage()->delete();
            }
            if ($slider->mainVideo) {
                $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
                $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
                $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
                $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
                $isLocal = in_array(app()->environment(), ['local', 'testing']) || !$s3Configured;
                
                if ($isLocal) {
                    $filePath = public_path('files/sliders/main_videos/' . $slider->mainVideo->media);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } else {
                    $s3Path = 'handco/sliders/main_videos/' . $slider->mainVideo->media;
                    Storage::disk('s3')->delete($s3Path);
                }
                $slider->mainVideo()->delete();
            }
        }

        // Replace the main image if a new one is uploaded
        if ($request->hasFile('main_image')) {
            // Delete the old main image
            if ($slider->mainImage) {
                // Use env() directly as fallback in case config cache is stale
                $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
                $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
                $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
                $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
                $isLocal = in_array(app()->environment(), ['local', 'testing']) || !$s3Configured;
                
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

        // Replace the main video if a new one is uploaded
        if ($request->hasFile('main_video')) {
            // Delete the old main video
            if ($slider->mainVideo) {
                // Use env() directly as fallback in case config cache is stale
                $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
                $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
                $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
                $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
                $isLocal = in_array(app()->environment(), ['local', 'testing']) || !$s3Configured;
                
                if ($isLocal) {
                    // Delete from local storage
                    $filePath = public_path('files/sliders/main_videos/' . $slider->mainVideo->media);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } else {
                    // Delete from S3
                    $s3Path = 'handco/sliders/main_videos/' . $slider->mainVideo->media;
                    Storage::disk('s3')->delete($s3Path);
                }
                $slider->mainVideo()->delete();
            }

            // Upload the new main video
            $this->mediaUploadService->uploadMedia(
                $request->file('main_video'),
                $slider,
                'sliders/main_videos',
                'video'
            );
        }

        // Delete main image if checkbox is checked
        if ($request->has('delete_main_image') && $request->input('delete_main_image') == '1') {
            if ($slider->mainImage) {
                $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
                $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
                $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
                $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
                $isLocal = in_array(app()->environment(), ['local', 'testing']) || !$s3Configured;
                
                if ($isLocal) {
                    $filePath = public_path('files/sliders/main_images/' . $slider->mainImage->media);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } else {
                    $s3Path = 'handco/sliders/main_images/' . $slider->mainImage->media;
                    Storage::disk('s3')->delete($s3Path);
                }
                $slider->mainImage()->delete();
            }
            // If deleting image and no video, set media_type to null or keep current
            if (!$slider->mainVideo) {
                $slider->update(['media_type' => 'image']);
            }
        }

        // Delete main video if checkbox is checked
        if ($request->has('delete_main_video') && $request->input('delete_main_video') == '1') {
            if ($slider->mainVideo) {
                $s3Key = config('filesystems.disks.s3.key') ?: env('AWS_ACCESS_KEY_ID');
                $s3Secret = config('filesystems.disks.s3.secret') ?: env('AWS_SECRET_ACCESS_KEY');
                $s3Url = config('filesystems.disks.s3.url') ?: env('AWS_URL');
                $s3Configured = !empty($s3Key) && !empty($s3Secret) && !empty($s3Url);
                $isLocal = in_array(app()->environment(), ['local', 'testing']) || !$s3Configured;
                
                if ($isLocal) {
                    $filePath = public_path('files/sliders/main_videos/' . $slider->mainVideo->media);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                } else {
                    $s3Path = 'handco/sliders/main_videos/' . $slider->mainVideo->media;
                    Storage::disk('s3')->delete($s3Path);
                }
                $slider->mainVideo()->delete();
            }
            // If deleting video and no image, set media_type to image
            if (!$slider->mainImage) {
                $slider->update(['media_type' => 'image']);
            }
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

        // Delete the main video
        if ($slider->mainVideo) {
            $s3Key = config('filesystems.disks.s3.key');
            $s3Url = config('filesystems.disks.s3.url');
            $isLocal = app()->environment('local') || !$s3Key || !$s3Url;
            
            if ($isLocal) {
                // Delete from local storage
                $filePath = public_path('files/sliders/main_videos/' . $slider->mainVideo->media);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                // Delete from S3
                $s3Path = 'handco/sliders/main_videos/' . $slider->mainVideo->media;
                Storage::disk('s3')->delete($s3Path);
            }
            $slider->mainVideo()->delete();
        }

        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
