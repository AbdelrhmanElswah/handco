@php
    $currentListingType = request('listingType', 'buy');
    
    // Fixed categories mapping: Display Name (plural) => Filter Value (singular)
    $fixedCategoriesMap = [
        'Apartments' => 'Apartment',
        'Villas' => 'Villa',
        'Townhouses' => 'Townhouse',
        'Penthouses' => 'Penthouse',
        'Duplex' => 'Duplex',
        'Commercial Spaces' => 'Commercial Spaces'
    ];
    
    // Get categories from API/database
    $apiCategories = \App\Models\Category::whereHas('projects', function($query) use ($currentListingType) {
        if ($currentListingType == 'buy') {
            $query->whereRaw('LOWER(rent_or_service) = ?', ['sell']);
        } elseif ($currentListingType == 'rent') {
            $query->whereRaw('LOWER(rent_or_service) = ?', ['rent']);
        } elseif ($currentListingType == 'off-plan') {
            $query->whereRaw('LOWER(rent_or_service) = ?', ['new']);
        }
    })->where(function($q) {
        $q->whereRaw('LOWER(name) NOT LIKE ?', ['%hotel%apartment%'])
          ->whereRaw('LOWER(name) != ?', ['hotel_apartment'])
          ->whereRaw('LOWER(name) != ?', ['hotel apartment']);
    })->orderBy('name')->get();
    
    // Get API category names (case-insensitive comparison)
    $apiCategoryNames = $apiCategories->map(function($cat) {
        return strtolower($cat->name);
    })->toArray();
    
    // Create reverse map: singular => plural for display
    $singularToPluralMap = array_flip($fixedCategoriesMap);
    
    // Process fixed categories and API categories
    $processedCategories = collect();
    
    // First, process API categories - if they match fixed categories, use plural display
    foreach ($apiCategories as $apiCat) {
        $apiCatLower = strtolower($apiCat->name);
        
        // Check if this API category matches a fixed category (singular form)
        if (isset($singularToPluralMap[$apiCat->name]) || 
            in_array($apiCatLower, array_map('strtolower', array_values($fixedCategoriesMap)))) {
            // Find the matching plural display name
            $pluralDisplay = null;
            foreach ($fixedCategoriesMap as $plural => $singular) {
                if (strtolower($singular) === $apiCatLower) {
                    $pluralDisplay = $plural;
                    break;
                }
            }
            
            // Create object with plural display but singular filter value
            $category = new \stdClass();
            $category->display_name = $pluralDisplay ?? $apiCat->name;
            $category->name = $apiCat->name; // Keep original for filtering
            $processedCategories->push($category);
        } else {
            // Not a fixed category, add as is
            $processedCategories->push($apiCat);
        }
    }
    
    // Then, add fixed categories that don't exist in API
    foreach ($fixedCategoriesMap as $pluralDisplay => $singularValue) {
        $singularLower = strtolower($singularValue);
        
        // Check if this fixed category already exists in processed categories
        $exists = $processedCategories->contains(function($cat) use ($singularLower) {
            return strtolower($cat->name) === $singularLower;
        });
        
        if (!$exists) {
            // Create a custom object with display name (plural) and filter value (singular)
            $category = new \stdClass();
            $category->display_name = $pluralDisplay;
            $category->name = $singularValue;
            $processedCategories->prepend($category); // Add at beginning
        }
    }
    
    // Sort: fixed categories first, then API categories
    $categories = $processedCategories->sortBy(function($cat) use ($fixedCategoriesMap) {
        $singularValues = array_values($fixedCategoriesMap);
        $index = array_search(strtolower($cat->name), array_map('strtolower', $singularValues));
        return $index !== false ? $index : 999; // Fixed categories first
    })->values();
@endphp

<div class="full-row p-0 property-search-form on-slider" style="margin-top: -200px !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <!-- Search Form Container -->
                <div class="bg-white rounded shadow-sm" style="overflow: visible;">
                    <!-- Tabs Navigation -->
                    <div class="border-bottom" style="background: #f8f9fa;">
                        <ul class="nav nav-tabs border-0 mb-0" id="listingTypeTabs" role="tablist" style="background: transparent;">
                            <li class="nav-item" role="presentation">
                                <button type="button" 
                                        class="nav-link listing-type-tab {{ (!request('listingType') || request('listingType') == 'buy') ? 'active' : '' }}" 
                                        data-listing-type="buy"
                                        style="border: none; 
                                               border-bottom: 3px solid {{ (!request('listingType') || request('listingType') == 'buy') ? '#001f3f' : 'transparent' }}; 
                                               color: {{ (!request('listingType') || request('listingType') == 'buy') ? '#001f3f' : '#999' }}; 
                                               font-weight: {{ (!request('listingType') || request('listingType') == 'buy') ? '600' : '400' }}; 
                                               padding: 15px 25px;
                                               background: {{ (!request('listingType') || request('listingType') == 'buy') ? '#fff' : 'transparent' }};
                                               opacity: {{ (!request('listingType') || request('listingType') == 'buy') ? '1' : '0.5' }};
                                               border-radius: 0;
                                               cursor: pointer;
                                               background-color: transparent;">
                                    Buy
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" 
                                        class="nav-link listing-type-tab {{ request('listingType') == 'rent' ? 'active' : '' }}" 
                                        data-listing-type="rent"
                                        style="border: none; 
                                               border-bottom: 3px solid {{ request('listingType') == 'rent' ? '#001f3f' : 'transparent' }}; 
                                               color: {{ request('listingType') == 'rent' ? '#001f3f' : '#999' }}; 
                                               font-weight: {{ request('listingType') == 'rent' ? '600' : '400' }}; 
                                               padding: 15px 25px;
                                               background: {{ request('listingType') == 'rent' ? '#fff' : 'transparent' }};
                                               opacity: {{ request('listingType') == 'rent' ? '1' : '0.5' }};
                                               border-radius: 0;
                                               cursor: pointer;
                                               background-color: transparent;">
                                    Rent
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" 
                                        class="nav-link listing-type-tab {{ request('listingType') == 'off-plan' ? 'active' : '' }}" 
                                        data-listing-type="off-plan"
                                        style="border: none; 
                                               border-bottom: 3px solid {{ request('listingType') == 'off-plan' ? '#001f3f' : 'transparent' }}; 
                                               color: {{ request('listingType') == 'off-plan' ? '#001f3f' : '#999' }}; 
                                               font-weight: {{ request('listingType') == 'off-plan' ? '600' : '400' }}; 
                                               padding: 15px 25px;
                                               background: {{ request('listingType') == 'off-plan' ? '#fff' : 'transparent' }};
                                               opacity: {{ request('listingType') == 'off-plan' ? '1' : '0.5' }};
                                               border-radius: 0;
                                               cursor: pointer;
                                               background-color: transparent;">
                                    Off Plan
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('projects') }}" method="GET" class="p-4" style="position: relative; overflow: visible;" id="propertySearchForm">
                        <input type="hidden" name="listingType" id="listingTypeInput" value="{{ request('listingType', 'buy') }}">
                        
                        <div class="row g-3 align-items-end" style="position: relative; overflow: visible;">
                            <!-- Location Input -->
                            <div class="col-md-3 col-sm-6">
                                <div class="position-relative">
                                    <input type="text" 
                                           class="form-control" 
                                           name="location" 
                                           placeholder="Area or project name" 
                                           value="{{ request('location') }}"
                                           style="border: 1px solid #ddd; padding: 10px 12px; border-radius: 4px;">
                                    <i class="fas fa-map-marker-alt position-absolute" 
                                       style="right: 12px; top: 50%; transform: translateY(-50%); color: #001f3f; font-size: 14px; pointer-events: none;"></i>
                                </div>
                            </div>

                            <!-- Property Type Dropdown -->
                            <div class="col-md-2 col-sm-6">
                                <select class="form-control" 
                                        name="category"
                                        id="propertyTypeSelect"
                                        style="border: 1px solid #ddd; padding: 10px 12px; border-radius: 4px; appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23001f3f\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center; padding-right: 35px;">
                                    <option value="">Property Type</option>
                                    @foreach($categories as $category)
                                        @php
                                            // Use display_name if available (for fixed categories with plural), otherwise use name
                                            $displayName = isset($category->display_name) ? $category->display_name : $category->name;
                                            $filterValue = $category->name; // Always use name (singular) for filtering
                                            $isSelected = request('category') == $filterValue || request('category') == $displayName;
                                        @endphp
                                        <option value="{{ $filterValue }}" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $displayName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Beds Dropdown -->
                            <div class="col-md-2 col-sm-6">
                                <select class="form-control" 
                                        name="bedrooms"
                                        style="border: 1px solid #ddd; padding: 10px 12px; border-radius: 4px; appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23001f3f\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center; padding-right: 35px;">
                                    <option value="">Beds</option>
                                    <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>1 Bed</option>
                                    <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>2 Beds</option>
                                    <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>3 Beds</option>
                                    <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>4 Beds</option>
                                    <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>5 Beds</option>
                                    <option value="6" {{ request('bedrooms') == '6' ? 'selected' : '' }}>6 Beds</option>
                                    <option value="6+" {{ request('bedrooms') == '6+' ? 'selected' : '' }}>6+ Beds</option>
                                </select>
                            </div>

                            <!-- Price Dropdown -->
                            <div class="col-md-2 col-sm-6">
                                <div class="position-relative" style="overflow: visible !important;">
                                    <button type="button" 
                                            class="form-control price-toggle toggle-btn text-start" 
                                            id="price-toggle-btn"
                                            data-target="#data-range-price" 
                                            style="border: 1px solid #ddd; padding: 10px 12px; border-radius: 4px; background: white; appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23001f3f\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center; padding-right: 35px;">
                                        Price
                                    </button>
                                    <div id="data-range-price" 
                                         class="price_range price-range-toggle d-none position-absolute" 
                                         style="display: none; z-index: 99999; width: 100%; left: 0; top: 100%; margin-top: 8px; padding: 24px; min-width: 300px; min-height: 200px; background-color: #ffffff !important; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                        <!-- Min Price Dropdown -->
                                        <div class="mb-4" style="background-color: transparent;">
                                            <label class="text-dark fw-semibold mb-2 d-block" style="font-size: 13px; color: #333;">Min Price</label>
                                            <select class="form-control w-100" 
                                                    name="min_price"
                                                    style="border: 1px solid #ddd; padding: 10px 12px; border-radius: 6px; appearance: none; background-color: #ffffff; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23001f3f\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center; padding-right: 35px; font-size: 14px; color: #333; width: 100%;">
                                                <option value="">No Min</option>
                                                <option value="300000" {{ request('min_price') == '300000' ? 'selected' : '' }}>300,000 AED</option>
                                                <option value="400000" {{ request('min_price') == '400000' ? 'selected' : '' }}>400,000 AED</option>
                                                <option value="500000" {{ request('min_price') == '500000' ? 'selected' : '' }}>500,000 AED</option>
                                                <option value="600000" {{ request('min_price') == '600000' ? 'selected' : '' }}>600,000 AED</option>
                                                <option value="700000" {{ request('min_price') == '700000' ? 'selected' : '' }}>700,000 AED</option>
                                                <option value="800000" {{ request('min_price') == '800000' ? 'selected' : '' }}>800,000 AED</option>
                                                <option value="900000" {{ request('min_price') == '900000' ? 'selected' : '' }}>900,000 AED</option>
                                                <option value="1000000" {{ request('min_price') == '1000000' ? 'selected' : '' }}>1,000,000 AED</option>
                                                <option value="1500000" {{ request('min_price') == '1500000' ? 'selected' : '' }}>1,500,000 AED</option>
                                                <option value="2000000" {{ request('min_price') == '2000000' ? 'selected' : '' }}>2,000,000 AED</option>
                                                <option value="3000000" {{ request('min_price') == '3000000' ? 'selected' : '' }}>3,000,000 AED</option>
                                                <option value="5000000" {{ request('min_price') == '5000000' ? 'selected' : '' }}>5,000,000 AED</option>
                                                <option value="10000000" {{ request('min_price') == '10000000' ? 'selected' : '' }}>10,000,000 AED</option>
                                            </select>
                                        </div>
                                        <!-- Max Price Dropdown -->
                                        <div style="background-color: transparent;">
                                            <label class="text-dark fw-semibold mb-2 d-block" style="font-size: 13px; color: #333;">Max Price</label>
                                            <select class="form-control w-100" 
                                                    name="max_price"
                                                    style="border: 1px solid #ddd; padding: 10px 12px; border-radius: 6px; appearance: none; background-color: #ffffff; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23001f3f\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center; padding-right: 35px; font-size: 14px; color: #333; width: 100%;">
                                                <option value="">No Max</option>
                                                <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>500,000 AED</option>
                                                <option value="600000" {{ request('max_price') == '600000' ? 'selected' : '' }}>600,000 AED</option>
                                                <option value="700000" {{ request('max_price') == '700000' ? 'selected' : '' }}>700,000 AED</option>
                                                <option value="800000" {{ request('max_price') == '800000' ? 'selected' : '' }}>800,000 AED</option>
                                                <option value="900000" {{ request('max_price') == '900000' ? 'selected' : '' }}>900,000 AED</option>
                                                <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>1,000,000 AED</option>
                                                <option value="1500000" {{ request('max_price') == '1500000' ? 'selected' : '' }}>1,500,000 AED</option>
                                                <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>2,000,000 AED</option>
                                                <option value="3000000" {{ request('max_price') == '3000000' ? 'selected' : '' }}>3,000,000 AED</option>
                                                <option value="5000000" {{ request('max_price') == '5000000' ? 'selected' : '' }}>5,000,000 AED</option>
                                                <option value="10000000" {{ request('max_price') == '10000000' ? 'selected' : '' }}>10,000,000 AED</option>
                                                <option value="20000000" {{ request('max_price') == '20000000' ? 'selected' : '' }}>20,000,000 AED</option>
                                                <option value="50000000" {{ request('max_price') == '50000000' ? 'selected' : '' }}>50,000,000 AED</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" 
                                        class="btn w-100 d-flex align-items-center justify-content-center" 
                                        style="background: #001f3f; color: white; border: none; padding: 12px 20px; border-radius: 4px; font-weight: 600; height: 42px;">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure Price dropdown container has solid background covering all content */
    #data-range-price {
        background-color: #ffffff !important;
        display: block !important;
    }
    
    /* Ensure parent containers don't clip the dropdown */
    .property-search-form,
    .property-search-form .container,
    .property-search-form .row,
    .property-search-form .col-lg-10,
    .property-search-form .bg-white.rounded.shadow-sm,
    .property-search-form .row.g-3 {
        overflow: visible !important;
    }
    
    /* Ensure dropdown is fully visible and on top */
    #data-range-price.position-absolute {
        position: absolute !important;
        z-index: 99999 !important;
        background-color: #ffffff !important;
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        min-height: 200px !important;
        padding: 24px !important;
        height: auto !important;
    }
    
    /* Ensure selects inside dropdown have proper background */
    #data-range-price select {
        background-color: #ffffff !important;
    }
    
    /* Ensure container wraps content properly */
    #data-range-price {
        display: block !important;
        overflow: visible !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tab switching - update categories dropdown based on selected tab
    const tabs = document.querySelectorAll('.listing-type-tab');
    const listingTypeInput = document.getElementById('listingTypeInput');
    const propertyTypeSelect = document.getElementById('propertyTypeSelect');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            const listingType = this.getAttribute('data-listing-type');
            
            // Update hidden input
            listingTypeInput.value = listingType;
            
            // Update active tab styles
            tabs.forEach(t => {
                const isActive = t === this;
                t.classList.toggle('active', isActive);
                t.style.borderBottom = isActive ? '3px solid #001f3f' : 'transparent';
                t.style.color = isActive ? '#001f3f' : '#999';
                t.style.fontWeight = isActive ? '600' : '400';
                t.style.background = isActive ? '#fff' : 'transparent';
                t.style.opacity = isActive ? '1' : '0.5';
            });
            
            // Load and update categories for this listing type
            loadCategoriesForListingType(listingType);
        });
    });
    
    function loadCategoriesForListingType(listingType) {
        // Show loading state
        if (propertyTypeSelect) {
            propertyTypeSelect.innerHTML = '<option value="">Loading...</option>';
            propertyTypeSelect.disabled = true;
        }
        
        // Make AJAX request to get categories
        fetch(`{{ route('home') }}?listingType=${listingType}&getCategories=1`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (propertyTypeSelect && data.categories) {
                // Clear existing options except the first one
                propertyTypeSelect.innerHTML = '<option value="">Property Type</option>';
                
                // Add new categories
                data.categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.value;
                    option.textContent = category.display;
                    propertyTypeSelect.appendChild(option);
                });
                
                propertyTypeSelect.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading categories:', error);
            if (propertyTypeSelect) {
                propertyTypeSelect.innerHTML = '<option value="">Property Type</option>';
                propertyTypeSelect.disabled = false;
            }
        });
    }
});
</script>



