@php
    // Get all categories that have projects (for Buy dropdown - sell properties)
    // Exclude HOTEL_APARTMENT
    $buyCategories = \App\Models\Category::whereHas('projects', function($query) {
        $query->whereRaw('LOWER(rent_or_service) = ?', ['sell']);
    })->where(function($q) {
        $q->whereRaw('LOWER(name) NOT LIKE ?', ['%hotel%apartment%'])
          ->whereRaw('LOWER(name) != ?', ['hotel_apartment'])
          ->whereRaw('LOWER(name) != ?', ['hotel apartment']);
    })->orderBy('name')->get();
    
    // Get all categories that have projects (for Rent dropdown - rent properties)
    // Exclude HOTEL_APARTMENT
    $rentCategories = \App\Models\Category::whereHas('projects', function($query) {
        $query->whereRaw('LOWER(rent_or_service) = ?', ['rent']);
    })->where(function($q) {
        $q->whereRaw('LOWER(name) NOT LIKE ?', ['%hotel%apartment%'])
          ->whereRaw('LOWER(name) != ?', ['hotel_apartment'])
          ->whereRaw('LOWER(name) != ?', ['hotel apartment']);
    })->orderBy('name')->get();
    
@endphp

<style>
    .nav-link.dropdown-toggle::after {
        display: none !important;
    }
    
    #navbarSupportedContent .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }
    
    #navbarSupportedContent .nav-link:hover {
        border-bottom: 3px solid #ffd700;
        padding-bottom: 2px;
    }
    
    #navbarSupportedContent .nav-link.active {
        border-bottom: 3px solid #ffd700;
        padding-bottom: 2px;
    }
    
    /* Dropdown Menu Styling */
    #navbarSupportedContent .dropdown-menu {
        background: white;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 8px 0;
        margin-top: 8px;
        min-width: 200px;
    }
    
    #navbarSupportedContent .dropdown-item {
        color: #001f3f;
        padding: 10px 20px;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    #navbarSupportedContent .dropdown-item:hover {
        background: #f8f9fa;
        color: #aa8453;
    }
    
    #navbarSupportedContent .dropdown-item:active {
        background: #f8f9fa;
        color: #aa8453;
    }
    
    /* Highlight selected category */
    #navbarSupportedContent .dropdown-item[href*="category"]:not([href*="View All"]) {
        color: #001f3f;
    }
    
    /* Active category styling */
    #navbarSupportedContent .dropdown-item.active-category {
        color: #aa8453;
        font-weight: 600;
        background: #f8f9fa;
    }
    
    /* View All styling */
    #navbarSupportedContent .dropdown-item.view-all-item {
        color: #666;
        font-weight: 500;
    }
    
    #navbarSupportedContent .dropdown-divider {
        margin: 8px 0;
        border-top: 1px solid #e9ecef;
    }
</style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto align-items-center justify-content-center">
        <!-- Home -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') && !request('listingType') ? 'active' : '' }}" 
               href="{{ route('home') }}"
               style="color: white; font-weight: {{ Request::is('/') && !request('listingType') ? '600' : '400' }};">
                Home
            </a>
        </li>
        
        <!-- Buy Dropdown -->
        <li class="nav-item dropdown" id="buyDropdownContainer">
            <a class="nav-link dropdown-toggle {{ (request('listingType') == 'buy' || Request::is('buy*')) ? 'active' : '' }}" 
               href="{{ route('home', ['listingType' => 'buy']) }}" 
               id="buyDropdown" 
               role="button" 
               aria-expanded="false"
               style="color: white; font-weight: {{ (request('listingType') == 'buy' || Request::is('buy*')) ? '600' : '400' }};">
                Buy
            </a>
            <ul class="dropdown-menu" aria-labelledby="buyDropdown">
                @foreach($buyCategories as $category)
                    <li>
                        <a class="dropdown-item {{ request('category') == $category->name ? 'active-category' : '' }}" 
                           href="{{ route('home', ['listingType' => 'buy', 'category' => $category->name]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
                @if($buyCategories->count() > 0)
                    <li><hr class="dropdown-divider"></li>
                @endif
                <li>
                    <a class="dropdown-item view-all-item" href="{{ route('home', ['listingType' => 'buy']) }}">
                        View All
                    </a>
                </li>
            </ul>
        </li>

        <!-- Rent Dropdown -->
        <li class="nav-item dropdown" id="rentDropdownContainer">
            <a class="nav-link dropdown-toggle {{ (request('listingType') == 'rent' || Request::is('rent*')) ? 'active' : '' }}" 
               href="{{ route('home', ['listingType' => 'rent']) }}" 
               id="rentDropdown" 
               role="button" 
               aria-expanded="false"
               style="color: white; font-weight: {{ (request('listingType') == 'rent' || Request::is('rent*')) ? '600' : '400' }};">
                Rent
            </a>
            <ul class="dropdown-menu" aria-labelledby="rentDropdown">
                @foreach($rentCategories as $category)
                    <li>
                        <a class="dropdown-item {{ request('category') == $category->name ? 'active-category' : '' }}" 
                           href="{{ route('home', ['listingType' => 'rent', 'category' => $category->name]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
                @if($rentCategories->count() > 0)
                    <li><hr class="dropdown-divider"></li>
                @endif
                <li>
                    <a class="dropdown-item view-all-item" href="{{ route('home', ['listingType' => 'rent']) }}">
                        View All
                    </a>
                </li>
            </ul>
        </li>

        <!-- Sell -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('sell') ? 'active' : '' }}"
               href="{{ route('sell') }}"
               style="color: white; font-weight: {{ Request::is('sell') ? '600' : '400' }};">
                Sell
            </a>
        </li>

        <!-- Off Plan Dropdown -->
        <li class="nav-item dropdown" id="offPlanDropdownContainer">
            <a class="nav-link dropdown-toggle" 
               href="{{ route('home', ['listingType' => 'off-plan']) }}" 
               id="offPlanDropdown" 
               role="button" 
               aria-expanded="false"
               style="color: white; font-weight: 400;">
                Off Plan
            </a>
            <ul class="dropdown-menu" aria-labelledby="offPlanDropdown">
                <li>
                    <a class="dropdown-item {{ Request::is('featured-projects*') ? 'active-category' : '' }}" 
                       href="{{ route('featured_projects') }}">
                        Off Plan Projects
                    </a>
                </li>
                <li>
                    <a class="dropdown-item {{ Request::is('off-plan-listing*') ? 'active-category' : '' }}" 
                       href="{{ route('off_plan_listing') }}">
                        Off Plan Listing
                    </a>
                </li>
            </ul>
        </li>

        <!-- Contact -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('contact') ? 'active' : '' }}" 
               href="{{ route('contact') }}"
               style="color: white; font-weight: {{ Request::is('contact') ? '600' : '400' }};">
                Contact
            </a>
        </li>

        <!-- More Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" 
               href="#" 
               id="moreDropdown" 
               role="button" 
               data-bs-toggle="dropdown" 
               aria-expanded="false"
               style="color: white;">
                More
            </a>
            <ul class="dropdown-menu" aria-labelledby="moreDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('blogs') }}">Blogs</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('communities') }}">Communities</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('about') }}">About Us</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
    // Handle Buy and Rent navbar links: allow navigation on click, dropdown on hover
    document.addEventListener('DOMContentLoaded', function() {
        const buyLink = document.getElementById('buyDropdown');
        const buyContainer = document.getElementById('buyDropdownContainer');
        const buyMenu = buyContainer ? buyContainer.querySelector('.dropdown-menu') : null;
        
        const rentLink = document.getElementById('rentDropdown');
        const rentContainer = document.getElementById('rentDropdownContainer');
        const rentMenu = rentContainer ? rentContainer.querySelector('.dropdown-menu') : null;
        
        // Handle Buy dropdown - show on hover, navigate on click
        if (buyLink && buyContainer && buyMenu) {
            let buyTimeout;
            
            // Show dropdown on hover
            buyContainer.addEventListener('mouseenter', function() {
                clearTimeout(buyTimeout);
                buyMenu.classList.add('show');
                buyContainer.classList.add('show');
                buyLink.setAttribute('aria-expanded', 'true');
            });
            
            // Hide dropdown when mouse leaves
            buyContainer.addEventListener('mouseleave', function() {
                buyTimeout = setTimeout(function() {
                    buyMenu.classList.remove('show');
                    buyContainer.classList.remove('show');
                    buyLink.setAttribute('aria-expanded', 'false');
                }, 100);
            });
            
            // Keep dropdown open when hovering over it
            buyMenu.addEventListener('mouseenter', function() {
                clearTimeout(buyTimeout);
            });
        }
        
        // Handle Rent dropdown - show on hover, navigate on click
        if (rentLink && rentContainer && rentMenu) {
            let rentTimeout;
            
            // Show dropdown on hover
            rentContainer.addEventListener('mouseenter', function() {
                clearTimeout(rentTimeout);
                rentMenu.classList.add('show');
                rentContainer.classList.add('show');
                rentLink.setAttribute('aria-expanded', 'true');
            });
            
            // Hide dropdown when mouse leaves
            rentContainer.addEventListener('mouseleave', function() {
                rentTimeout = setTimeout(function() {
                    rentMenu.classList.remove('show');
                    rentContainer.classList.remove('show');
                    rentLink.setAttribute('aria-expanded', 'false');
                }, 100);
            });
            
            // Keep dropdown open when hovering over it
            rentMenu.addEventListener('mouseenter', function() {
                clearTimeout(rentTimeout);
            });
        }
        
        // Handle Off Plan dropdown - show on hover, navigate on click
        const offPlanLink = document.getElementById('offPlanDropdown');
        const offPlanContainer = document.getElementById('offPlanDropdownContainer');
        const offPlanMenu = offPlanContainer ? offPlanContainer.querySelector('.dropdown-menu') : null;
        
        if (offPlanLink && offPlanContainer && offPlanMenu) {
            let offPlanTimeout;
            
            // Show dropdown on hover
            offPlanContainer.addEventListener('mouseenter', function() {
                clearTimeout(offPlanTimeout);
                offPlanMenu.classList.add('show');
                offPlanContainer.classList.add('show');
                offPlanLink.setAttribute('aria-expanded', 'true');
            });
            
            // Hide dropdown when mouse leaves
            offPlanContainer.addEventListener('mouseleave', function() {
                offPlanTimeout = setTimeout(function() {
                    offPlanMenu.classList.remove('show');
                    offPlanContainer.classList.remove('show');
                    offPlanLink.setAttribute('aria-expanded', 'false');
                }, 100);
            });
            
            // Keep dropdown open when hovering over it
            offPlanMenu.addEventListener('mouseenter', function() {
                clearTimeout(offPlanTimeout);
            });
        }
    });
</script>
