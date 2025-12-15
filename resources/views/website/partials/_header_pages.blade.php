<header class="header-style nav-on-top bg-secondary">
    <div class="main-nav" style="background: #001f3f; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="/">
                            <img class="nav-logo" src="{{ asset('assets/images/logo/logo-light.png') }}" alt="H&Co Properties" style="height: 50px;">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation"
                                style="border-color: white;">
                            <span class="navbar-toggler-icon" style="background-image: url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e\");"></span>
                        </button>
                        @include('website.partials._navbar')
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
