<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{url('/admin')}}" class="header-logo">
            <img src="{{asset('dashboard/assets/logo.png')}}" alt="logo" class="desktop-logo">
            <img src="{{asset('dashboard/assets/logo.png')}}" alt="logo" class="toggle-logo">
            <img src="{{asset('dashboard/assets/logo.png')}}" alt="logo" class="desktop-dark">
            <img src="{{asset('dashboard/assets/logo.png')}}" alt="logo" class="toggle-dark">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->
                <li class="slide">
                    <a href=""
                       class="side-menu__item">
                        <i class="fe fe-users side-menu__icon"></i>
                        <span class="side-menu__label">Website</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                </li>

                <li class="slide__category"><span class="category-name">Contact Us</span></li>
                <!-- End::slide__category -->
                <li class="slide">
                    <a href="{{route('contact')}}"
                       class="side-menu__item">
                        <i class="fe fe-users side-menu__icon"></i>
                        <span class="side-menu__label">Contact Us</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                </li>
                <li class="slide__category"><span class="category-name">Product</span></li>

                <li class="slide has-sub {{Request::route()->getName() == 'products'  || Request::route()->getName() == 'products.create' }} ">
                    <a href="javascript:void(0);"
                       class="side-menu__item " {{Request::route()->getName() == 'products'  || Request::route()->getName() == 'products.create'}}>
                        <i class="fe fe-package side-menu__icon"></i>
                        <span class="side-menu__label">Product</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" data-popper-placement="bottom"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 275px);">

                        <li class="slide">
                            <a href="{{route('blog')}}"
                               class="side-menu__item {{Request::route()->getName() == 'products'}}">Show
                                All</a>
                        </li>

                        <li class="slide">
                            <a href="{{route('products.create')}}"
                               class="side-menu__item ">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="slide__category"><span class="category-name">Category</span></li>

                 <li class="slide has-sub {{Request::route()->getName() == 'category'  || Request::route()->getName() == 'category.create' }} ">
                    <a href="javascript:void(0);"
                       class="side-menu__item " {{Request::route()->getName() == 'category'  || Request::route()->getName() == 'category.create'}}>
                        <i class="fe fe-grid side-menu__icon"></i>
                        <span class="side-menu__label">Category</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1" data-popper-placement="bottom"
                        style="position: relative; left: 0px; top: 0px; margin: 0px; transform: translate(120px, 275px);">

                        <li class="slide">
                            <a href="{{route('category')}}"
                               class="side-menu__item " {{Request::route()->getName() == 'category'}}>Show
                                All</a>
                        </li>

                        <li class="slide">
                            <a href="{{route('category.create')}}"
                               class="side-menu__item ">Create</a>
                        </li>

                    </ul>
                </li>

                <!-- Start::logout -->
                <li class="slide__category"><span class="category-name">Log out</span></li>
                <li class="slide">
                    <a href="{{ route('logout') }}"
                       class="side-menu__item"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-log-out side-menu__icon"></i>
                        <span class="side-menu__label">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <!-- End::logout -->
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
