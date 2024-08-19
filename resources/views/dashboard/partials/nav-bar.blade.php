<!-- app-header -->
<header class="app-header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="{{url('/admin')}}" class="header-logo">
                        <img src="{{asset('website/assets/logo.png')}}" alt="logo" class="desktop-logo">
                        <img src="{{asset('website/assets/logo.png')}}" alt="logo" class="toggle-logo">
                        <img src="{{asset('website/assets/logo.png')}}" alt="logo" class="desktop-dark">
                        <img src="{{asset('website/assets/logo.png')}}" alt="logo" class="toggle-dark">
                    </a>
                </div>
            </div>
            <!-- End::header-element -->


        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">





            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting">
                            <span class="light-layout">
                                <!-- Start::header-link-icon -->
                            <i class="bx bx-moon header-link-icon"></i>
                                <!-- End::header-link-icon -->
                            </span>
                    <span class="dark-layout">
                                <!-- Start::header-link-icon -->
                            <i class="bx bx-sun header-link-icon"></i>
                        <!-- End::header-link-icon -->
                            </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="#" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown"
                   data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="{{asset('website/assets/logo.png')}}" alt="img" width="32" height="32"
                                 class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">Admin</p>
                            <span class="op-7 fw-normal d-block fs-11">SUPPOURT@Admin.US</span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">

                    <li><a target="_blank" class="dropdown-item d-flex" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </div>
            <!-- End::header-element -->



        </div>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>
<!-- /app-header -->
