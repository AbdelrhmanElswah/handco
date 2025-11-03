<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('/admin') }}" class="header-logo">
            <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Main section -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <li class="slide">
                    <a href="https://handcoproperties.com/" class="side-menu__item">
                        <i class="fe fe-globe side-menu__icon"></i>
                        <span class="side-menu__label">Website</span>
                    </a>
                </li>

                <!-- Bookings section -->
                <li class="slide__category"><span class="category-name">Leads</span></li>
                <li class="slide">
                    <a href="{{ route('booking.index') }}" class="side-menu__item">
                        <i class="fe fe-briefcase side-menu__icon"></i>
                        <span class="side-menu__label">Leads</span>
                    </a>
                </li>


                <!-- Contact Us section -->
                {{--                <li class="slide__category"><span class="category-name">Contact Us</span></li> --}}
                {{--                <li class="slide"> --}}
                {{--                    <a href="{{ route('contact-us.index') }}" class="side-menu__item"> --}}
                {{--                        <i class="fe fe-users side-menu__icon"></i> --}}
                {{--                        <span class="side-menu__label">Contact Us</span> --}}
                {{--                    </a> --}}
                {{--                </li> --}}

                <!-- Category section -->
                {{--                <li class="slide__category"><span class="category-name">Category</span></li> --}}
                {{--                <li class="slide has-sub {{ request()->routeIs('category.*') }}"> --}}
                {{--                    <a href="javascript:void(0);" class="side-menu__item"> --}}
                {{--                        <i class="fe fe-folder side-menu__icon"></i> --}}
                {{--                        <span class="side-menu__label">Category</span> --}}
                {{--                        <i class="fe fe-chevron-right side-menu__angle"></i> --}}
                {{--                    </a> --}}
                {{--                    <ul class="slide-menu child1"> --}}
                {{--                        <li><a href="{{ route('category.create') }}" class="side-menu__item">Add Category</a></li> --}}
                {{--                        <li><a href="{{ route('category.index') }}" class="side-menu__item">Show Categories</a></li> --}}
                {{--                    </ul> --}}
                {{--                </li> --}}

                <!-- Sliders section -->
                <li class="slide__category"><span class="category-name">Sliders</span></li>
                <li class="slide has-sub {{ request()->routeIs('sliders.*') }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fe fe-image side-menu__icon"></i>
                        <span class="side-menu__label">Sliders</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li><a href="{{ route('sliders.create') }}" class="side-menu__item">Add Slider</a></li>
                        <li><a href="{{ route('sliders.index') }}" class="side-menu__item">Show Sliders</a></li>
                    </ul>
                </li>


                <!-- Utilities section -->
                {{--                <li class="slide__category"><span class="category-name">Utilities</span></li> --}}
                {{--                <li class="slide has-sub {{ request()->routeIs('utilities.*') }}"> --}}
                {{--                    <a href="javascript:void(0);" class="side-menu__item"> --}}
                {{--                        <i class="fe fe-settings side-menu__icon"></i> --}}
                {{--                        <span class="side-menu__label">Utilities</span> --}}
                {{--                        <i class="fe fe-chevron-right side-menu__angle"></i> --}}
                {{--                    </a> --}}
                {{--                    <ul class="slide-menu child1"> --}}
                {{--                        <li><a href="{{ route('utilities.create') }}" class="side-menu__item">Add Utility</a></li> --}}
                {{--                        <li><a href="{{ route('utilities.index') }}" class="side-menu__item">Show Utilities</a></li> --}}
                {{--                    </ul> --}}
                {{--                </li> --}}

                <!-- Projects section -->
                <li class="slide__category"><span class="category-name">Properties</span></li>
                <li class="slide has-sub {{ request()->routeIs('projects.*') }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fe fe-briefcase side-menu__icon"></i>
                        <span class="side-menu__label">Properties</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li><a href="{{ route('projects.create') }}" class="side-menu__item">Add Property</a></li>
                        <li><a href="{{ route('projects.index') }}" class="side-menu__item">Show Property</a></li>
                    </ul>
                </li>

                <!-- Blogs section -->
                <li class="slide__category"><span class="category-name">Blogs</span></li>
                <li class="slide has-sub {{ request()->routeIs('blogs.*') }}">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="fe fe-file-text side-menu__icon"></i>
                        <span class="side-menu__label">Blogs</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li><a href="{{ route('blog.create') }}" class="side-menu__item">Add Blog</a></li>
                        <li><a href="{{ route('blog.index') }}" class="side-menu__item">Show Blogs</a></li>
                    </ul>
                </li>

                <!-- CMS section -->
                <li class="slide__category"><span class="category-name">CMS</span></li>
                <li class="slide {{ request()->routeIs('cms.*') ? 'active' : '' }}">
                    <a href="{{ route('cms.index') }}" class="side-menu__item">
                        <i class="fe fe-edit side-menu__icon"></i>
                        <span class="side-menu__label">Content Management</span>
                    </a>
                </li>

              <!-- Pixxi CRM section -->
<li class="slide__category"><span class="category-name">Pixxi CRM</span></li>
<li class="slide has-sub {{ request()->routeIs('pixxi.properties.*') ? 'active' : '' }}">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="fe fe-database side-menu__icon"></i>
        <span class="side-menu__label">Pixxi Properties</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">

        <li>
            <a href="{{ route('pixxi.properties.index', ['listingType' => 'SELL', 'status' => 'ACTIVE']) }}"
               class="side-menu__item {{ request('listingType') === 'SELL' && request('status') === 'ACTIVE' ? 'active' : '' }}">
               For Sale
            </a>
        </li>
        <li>
            <a href="{{ route('pixxi.properties.index', ['listingType' => 'RENT', 'status' => 'ACTIVE']) }}"
               class="side-menu__item {{ request('listingType') === 'RENT' && request('status') === 'ACTIVE' ? 'active' : '' }}">
               For Rent
            </a>
        </li>
    </ul>
</li>


                <!-- Logout section -->
                <li class="slide__category"><span class="category-name">Log out</span></li>
                <li class="slide">
                    <a href="{{ route('logout') }}" class="side-menu__item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-log-out side-menu__icon"></i>
                        <span class="side-menu__label">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
