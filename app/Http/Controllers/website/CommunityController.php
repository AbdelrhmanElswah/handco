<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Project;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function showCommunities(Request $request)
    {
        $query = Community::query();

        // Filter by keyword (Enter Project)
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // Filter by Community Name
        if ($request->filled('community_name')) {
            $query->where('title', 'like', '%' . $request->community_name . '%');
        }

        // Filter by Developer - filter communities that have projects with this developer
        if ($request->filled('developer')) {
            $communityNames = Project::where('developer_name', 'like', '%' . $request->developer . '%')
                ->whereNotNull('location_name')
                ->pluck('location_name')
                ->unique()
                ->toArray();
            
            if (!empty($communityNames)) {
                $query->where(function($q) use ($communityNames) {
                    foreach ($communityNames as $name) {
                        $q->orWhere('title', 'like', '%' . $name . '%');
                    }
                });
            } else {
                // If no projects found, return empty result
                $query->whereRaw('1 = 0');
            }
        }

        // Filter by Property Type - filter communities that have projects with this property type
        if ($request->filled('property_type')) {
            $communityNames = Project::whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->property_type . '%');
            })
            ->whereNotNull('location_name')
            ->pluck('location_name')
            ->unique()
            ->toArray();
            
            if (!empty($communityNames)) {
                $query->where(function($q) use ($communityNames) {
                    foreach ($communityNames as $name) {
                        $q->orWhere('title', 'like', '%' . $name . '%');
                    }
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        // Filter by Status - filter communities that have projects with this status
        if ($request->filled('status')) {
            $statusMap = [
                'Available' => 'available',
                'Sold Out' => 'sold',
                'Under Construction' => 'under_construction'
            ];
            
            $statusValue = $statusMap[$request->status] ?? $request->status;
            
            $communityNames = Project::where('status', $statusValue)
                ->whereNotNull('location_name')
                ->pluck('location_name')
                ->unique()
                ->toArray();
            
            if (!empty($communityNames)) {
                $query->where(function($q) use ($communityNames) {
                    foreach ($communityNames as $name) {
                        $q->orWhere('title', 'like', '%' . $name . '%');
                    }
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $communities = $query->orderBy('created_at', 'desc')
            ->paginate(6);

        // Get filter options for dropdowns
        // Community Name: All communities
        $allCommunities = Community::pluck('title')->unique()->sort()->values();
        
        // Developer: Only developers that have projects in communities (match by location_name)
        $allCommunityTitles = Community::pluck('title')->toArray();
        
        if (!empty($allCommunityTitles)) {
            $developers = Project::whereNotNull('developer_name')
                ->where(function($q) use ($allCommunityTitles) {
                    foreach ($allCommunityTitles as $communityTitle) {
                        $q->orWhere('location_name', 'like', '%' . $communityTitle . '%');
                    }
                })
                ->distinct()
                ->pluck('developer_name')
                ->filter()
                ->unique()
                ->sort()
                ->values();
            
            // Property Type: Only categories that have projects in communities
            $propertyTypes = Project::where(function($q) use ($allCommunityTitles) {
                    foreach ($allCommunityTitles as $communityTitle) {
                        $q->orWhere('location_name', 'like', '%' . $communityTitle . '%');
                    }
                })
                ->whereHas('category')
                ->with('category')
                ->get()
                ->pluck('category.name')
                ->filter()
                ->unique()
                ->sort()
                ->values();
        } else {
            // If no communities exist, show all options
            $developers = Project::whereNotNull('developer_name')
                ->distinct()
                ->pluck('developer_name')
                ->filter()
                ->unique()
                ->sort()
                ->values();
            
            $propertyTypes = \App\Models\Category::pluck('name')->unique()->sort()->values();
        }
        
        // Status: Fixed list
        $statuses = ['Available', 'Sold Out', 'Under Construction'];

        return view('website.communities', compact('communities', 'allCommunities', 'developers', 'propertyTypes', 'statuses'));
    }

    public function show($id, Request $request)
    {
        $community = Community::with('mainImage')->findOrFail($id);
        
        // Get listing type from request (for_sale, for_rent, off_plan)
        $listingType = $request->get('type', 'for_sale');
        
        // Prepare community name variations for better matching
        $communityTitle = trim($community->title);
        $communityTitleLower = strtolower($communityTitle);
        
        // Create variations of the community name for flexible matching
        // Example: "Downtown Dubai" -> ["Downtown Dubai", "downtown dubai", "Downtown", "Dubai"]
        $nameVariations = [
            $communityTitle,                    // Exact match: "Downtown Dubai"
            $communityTitleLower,                // Lowercase: "downtown dubai"
            ucwords($communityTitleLower),       // Title case: "Downtown Dubai"
        ];
        
        // Split into words for partial matching (e.g., "Downtown" or "Dubai" separately)
        $words = array_filter(explode(' ', $communityTitle));
        foreach ($words as $word) {
            if (strlen(trim($word)) > 2) { // Only add words longer than 2 characters
                $nameVariations[] = trim($word);
                $nameVariations[] = strtolower(trim($word));
            }
        }
        
        // Remove duplicates
        $nameVariations = array_unique($nameVariations);
        
        // Base query for properties in this community
        // Use STRICT matching - only properties that match the community name exactly or contain it as a whole
        $baseQuery = Project::with('mainImage', 'category', 'utility')
            ->where(function($query) use ($communityTitle, $communityTitleLower) {
                // Priority 1: Exact match (case insensitive, trimmed)
                $query->whereRaw('LOWER(TRIM(location_name)) = ?', [strtolower(trim($communityTitle))]);
                
                // Priority 2: Location name starts with community name (e.g., "Downtown Dubai, ...")
                $query->orWhereRaw('LOWER(location_name) LIKE ?', [strtolower(trim($communityTitle)) . '%']);
                
                // Priority 3: Location name contains community name with separators (comma, dash, etc.)
                $query->orWhereRaw('LOWER(location_name) LIKE ?', ['%, ' . $communityTitleLower . '%'])
                      ->orWhereRaw('LOWER(location_name) LIKE ?', ['%- ' . $communityTitleLower . '%'])
                      ->orWhereRaw('LOWER(location_name) LIKE ?', ['%' . $communityTitleLower . ',%'])
                      ->orWhereRaw('LOWER(location_name) LIKE ?', ['%' . $communityTitleLower . ' -%']);
                
                // Priority 4: Location name contains the full community name (but not individual words)
                // This ensures "Downtown Dubai" matches but doesn't match just "Dubai" or just "Downtown"
                $query->orWhereRaw('LOWER(location_name) LIKE ?', ['%' . $communityTitleLower . '%']);
            });
        
        // Filter by listing type
        if ($listingType === 'for_sale') {
            $baseQuery->whereRaw('LOWER(rent_or_service) = ?', ['sell']);
        } elseif ($listingType === 'for_rent') {
            $baseQuery->whereRaw('LOWER(rent_or_service) = ?', ['rent']);
        } elseif ($listingType === 'off_plan') {
            $baseQuery->where(function($q) {
                $q->where('payment_option', 'off-plan')
                  ->orWhereRaw('LOWER(rent_or_service) = ?', ['new']);
            });
        }
        
        // Get featured properties (limit to 4) - ONLY properties that match the community
        $featuredProperties = $baseQuery
            ->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        // NO FALLBACK - If no properties found, return empty collection
        // This ensures we only show properties that actually match the community name
        
        // Get other communities (exclude current one)
        $otherCommunities = Community::where('id', '!=', $id)
            ->with('mainImage')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('website.community_show', compact('community', 'featuredProperties', 'otherCommunities', 'listingType'));
    }
}
