<?php

namespace App\Http\Controllers;

use App\Models\CmsSection;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    /**
     * Display a listing of CMS sections
     */
    public function index()
    {
        // Auto-seed CMS sections if table is empty
        if (CmsSection::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\CmsSectionSeeder']);
        }
        $sections = CmsSection::orderBy('section_name')->get();
        return view('dashboard.cms.index', compact('sections'));
    }

    /**
     * Show the form for editing the specified CMS section
     */
    public function edit(CmsSection $cms)
    {
        return view('dashboard.cms.edit', compact('cms'));
    }

    /**
     * Update the specified CMS section
     */
    public function update(Request $request, CmsSection $cms)
    {
        $validationRules = [
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'content' => 'nullable|string',
            'list_items' => 'nullable|array',
            'list_items.*' => 'nullable|string',
            'stats_items' => 'nullable|array',
            'stats_items.*.value' => 'nullable|string',
            'stats_items.*.description' => 'nullable|string',
            'testimonials' => 'nullable|array',
            'testimonials.*.quote' => 'nullable|string',
            'testimonials.*.author' => 'nullable|string',
            'testimonials.*.position' => 'nullable|string',
            'accordion_items' => 'nullable|array',
            'accordion_items.*.title' => 'nullable|string',
            'accordion_items.*.content' => 'nullable|string',
            'accordion_items.*.is_active' => 'nullable|boolean',
            'is_active' => 'boolean',
        ];

        // Add validation for partner logos if editing about_partners section
        if ($cms->section_key === 'about_partners') {
            $validationRules['partner_logos.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $validationRules['existing_logos'] = 'nullable|array';
        }

        // Add validation for background image if editing about_hero_banner or mission_vision_section
        if (in_array($cms->section_key, ['about_hero_banner', 'mission_vision_section'])) {
            $validationRules['background_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        // Footer CTA validation
        if ($cms->section_key === 'footer_register_cta') {
            $validationRules['button_text'] = 'nullable|string|max:255';
            $validationRules['button_link'] = 'nullable|string|max:1024';
        }

        // Validation for contact info section
        if ($cms->section_key === 'contact_info_section') {
            $validationRules['contact_phones'] = 'nullable|array';
            $validationRules['contact_phones.*.title'] = 'nullable|string|max:255';
            $validationRules['contact_phones.*.number'] = 'nullable|string|max:255';
            $validationRules['contact_addresses'] = 'nullable|array';
            $validationRules['contact_addresses.*.title'] = 'nullable|string|max:255';
            $validationRules['contact_addresses.*.content'] = 'nullable|string';
            $validationRules['contact_emails'] = 'nullable|array';
            $validationRules['contact_emails.*'] = 'nullable|email';
        }

        // Social links validation
        if ($cms->section_key === 'social_links_section') {
            $validationRules['social_links'] = 'nullable|array';
            $validationRules['social_links.*.platform'] = 'nullable|string|max:100';
            $validationRules['social_links.*.url'] = 'nullable|url|max:1024';
            $validationRules['social_links.*.icon_class'] = 'nullable|string|max:100';
        }

        $request->validate($validationRules);

        // Handle background image upload for hero / section banners
        if (in_array($cms->section_key, ['about_hero_banner', 'mission_vision_section']) && $request->hasFile('background_image')) {
            $uploadPath = 'cms/about-us';

            // Delete old background image from S3 if exists
            if ($cms->backgroundImage) {
                $oldS3Path = 'handco/' . $cms->backgroundImage->path_file_name . '/' . $cms->backgroundImage->media;
                if (Storage::disk('s3')->exists($oldS3Path)) {
                    Storage::disk('s3')->delete($oldS3Path);
                }
                $cms->backgroundImage()->delete();
            }

            // Upload new background image to S3
            $file = $request->file('background_image');
            $now = Carbon::now();
            $randomString = Str::random(10);
            $filename = $now->format('Ymdh') . '_' . $randomString . '.' . $file->getClientOriginalExtension();
            $s3Path = 'handco/' . $uploadPath . '/' . $filename;

            try {
                // Upload to S3
                $fileContents = file_get_contents($file->getRealPath());

                if ($fileContents === false) {
                    throw new \Exception('Failed to read file contents');
                }

                $uploaded = Storage::disk('s3')->put($s3Path, $fileContents);

                if (!$uploaded) {
                    throw new \Exception('Failed to upload file to S3');
                }

                // Set visibility to public
                Storage::disk('s3')->setVisibility($s3Path, 'public');
            } catch (\Exception $e) {
                Log::error('S3 Upload Error (Background Image): ' . $e->getMessage(), [
                    'path' => $s3Path ?? null,
                    'filename' => $filename,
                ]);
                throw $e;
            }

            // Create media record using backgroundImage relationship
            $cms->backgroundImage()->create([
                'media' => $filename,
                'info' => 'background',
                'path_file_name' => $uploadPath,
            ]);
        }

        // Handle partner logo uploads for about_partners section
        if ($cms->section_key === 'about_partners') {
            $listItems = [];

            // Keep existing logos that weren't removed
            if ($request->has('existing_logos')) {
                $listItems = $request->existing_logos ?? [];
            }

            // Handle new logo uploads
            if ($request->hasFile('partner_logos')) {
                $uploadPath = 'partners';

                foreach ($request->file('partner_logos') as $file) {
                    if ($file && $file->isValid()) {
                        $now = Carbon::now();
                        $randomString = Str::random(10);
                        $filename = $now->format('Ymdh') . '_' . $randomString . '.' . $file->getClientOriginalExtension();
                        $s3Path = 'handco/' . $uploadPath . '/' . $filename;

                        try {
                            // Upload to S3
                            $fileContents = file_get_contents($file->getRealPath());

                            if ($fileContents === false) {
                                throw new \Exception('Failed to read file contents');
                            }

                            $uploaded = Storage::disk('s3')->put($s3Path, $fileContents);

                            if (!$uploaded) {
                                throw new \Exception('Failed to upload file to S3');
                            }

                            // Set visibility to public
                            Storage::disk('s3')->setVisibility($s3Path, 'public');

                            // Store the full S3 URL - use config instead of env() for production compatibility
                            $s3Url = config('filesystems.disks.s3.url');
                            if ($s3Url) {
                                $listItems[] = rtrim($s3Url, '/') . '/handco/' . $uploadPath . '/' . $filename;
                            } else {
                                // Fallback to asset if AWS_URL is not set
                                $listItems[] = asset('files/' . $uploadPath . '/' . $filename);
                            }
                        } catch (\Exception $e) {
                            Log::error('S3 Upload Error (Partner Logo): ' . $e->getMessage(), [
                                'path' => $s3Path,
                                'filename' => $filename,
                            ]);
                            // Continue with next file instead of breaking
                            continue;
                        }
                    }
                }
            }
        } else if ($cms->section_key === 'contact_info_section') {
            // For contact info section, list_items not used; keep as is
            $listItems = null;
        } else if ($cms->section_key === 'footer_register_cta') {
            $listItems = [
                'button_text' => $request->input('button_text'),
                'button_link' => $request->input('button_link'),
            ];
        } else {
            // Process list items - remove empty items for other sections
            $listItems = $request->list_items ?? [];
            $listItems = array_filter($listItems, function($item) {
                return !empty(trim($item));
            });
            $listItems = array_values($listItems); // Re-index array
        }

        // Process stats items - remove empty items
        $statsItems = $request->stats_items ?? [];
        $statsItems = array_filter($statsItems, function($item) {
            return !empty(trim($item['value'] ?? '')) || !empty(trim($item['description'] ?? ''));
        });
        $statsItems = array_values($statsItems); // Re-index array

        // Process testimonials - remove empty items
        $testimonials = $request->testimonials ?? [];
        $testimonials = array_filter($testimonials, function($item) {
            return !empty(trim($item['quote'] ?? '')) || !empty(trim($item['author'] ?? ''));
        });
        $testimonials = array_values($testimonials); // Re-index array

        // Process accordion items - remove empty items
        $accordionItems = $request->accordion_items ?? [];
        $accordionItems = array_filter($accordionItems, function($item) {
            return !empty(trim($item['title'] ?? '')) || !empty(trim($item['content'] ?? ''));
        });
        $accordionItems = array_values($accordionItems); // Re-index array

        // Prepare contact info arrays if applicable
        $contactPhones = null;
        $contactAddresses = null;
        $contactEmails = null;
        $socialLinks = null;
        if ($cms->section_key === 'contact_info_section') {
            $contactPhones = array_values(array_filter(($request->contact_phones ?? []), function ($item) {
                return !empty(trim($item['title'] ?? '')) || !empty(trim($item['number'] ?? ''));
            }));
            $contactAddresses = array_values(array_filter(($request->contact_addresses ?? []), function ($item) {
                return !empty(trim($item['title'] ?? '')) || !empty(trim($item['content'] ?? ''));
            }));
            $contactEmails = array_values(array_filter(($request->contact_emails ?? []), function ($item) {
                return !empty(trim($item ?? ''));
            }));
        } elseif ($cms->section_key === 'social_links_section') {
            $socialLinks = array_values(array_filter(($request->social_links ?? []), function ($item) {
                return !empty(trim($item['platform'] ?? '')) || !empty(trim($item['url'] ?? ''));
            }));
        }

        $cms->update([
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'content' => $request->input('content'),
            'list_items' => !empty($listItems) ? $listItems : null,
            'stats_items' => !empty($statsItems) ? $statsItems : null,
            'testimonials' => !empty($testimonials) ? $testimonials : null,
            'accordion_items' => !empty($accordionItems) ? $accordionItems : null,
            'contact_phones' => !empty($contactPhones) ? $contactPhones : null,
            'contact_addresses' => !empty($contactAddresses) ? $contactAddresses : null,
            'contact_emails' => !empty($contactEmails) ? $contactEmails : null,
            'social_links' => !empty($socialLinks) ? $socialLinks : null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('cms.index')->with('success', 'CMS section updated successfully.');
    }
}
