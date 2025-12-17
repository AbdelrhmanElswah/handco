<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    public function index()
    {
        $communities = Community::all();
        return view('dashboard.community.index', compact('communities'));
    }

    public function create()
    {
        return view('dashboard.community.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'subtitle' => 'nullable|string|max:255',
            'location_link' => 'nullable|url',
            'main_image' => 'required|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'subtitle', 'location_link']);

        // Create the community without the main image first
        $community = Community::create($data);

        // Upload the main image and associate it with the community
        if ($request->hasFile('main_image')) {
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $community,
                'communities/main_images',
                'main'
            );
        }

        return redirect()->route('community.index')->with('success', 'Community created successfully.');
    }

    public function edit(Community $community)
    {
        return view('dashboard.community.edit', compact('community'));
    }

    public function update(Request $request, Community $community)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'subtitle' => 'nullable|string|max:255',
            'location_link' => 'nullable|url',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'subtitle', 'location_link']);

        // Update the community data first
        $community->update($data);

        // Update the main image if a new one is uploaded
        if ($request->hasFile('main_image')) {
            // Delete the existing main image if it exists
            if ($community->mainImage) {
                $community->mainImage->delete();
            }

            // Upload the new main image and associate it with the community
            $this->mediaUploadService->uploadMedia(
                $request->file('main_image'),
                $community,
                'communities/main_images',
                'main'
            );
        }

        return redirect()->route('community.index')->with('success', 'Community updated successfully.');
    }

    public function destroy(Community $community)
    {
        $community->delete();
        return redirect()->route('community.index')->with('success', 'Community deleted successfully.');
    }
}
