<header class="header-style nav-on-top bg-secondary">
    <div class="main-nav">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg nav-white nav-primary-hover nav-line-active">
                        <a class="navbar-brand" href="#"><img class="nav-logo" src="{{ asset('assets/images/logo/logo-dark.png') }}"
                                                              alt="Image not found !"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon flaticon-menu flat-small text-primary"></span>
                        </button>
                        @include('website.partials._navbar')
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
