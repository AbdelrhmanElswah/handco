@extends('dashboard.partials.app')
@section('content')

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <p class="fw-semibold fs-18 mb-0">Welcome back, Admin!</p>
                    <span class="fs-semibold text-muted">Track your activity</span>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row-1 -->
            <div class="col-xxl-12 col-xl-12">
                <div class="row">
                    <!-- Card for Category -->
                    <div class="col-xxl-6 col-lg-4 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                    <span class="avatar avatar-md avatar-rounded bg-warning">
                                        <i class="fa fa-folder"></i> <!-- Icon for Category -->
                                    </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Total Categories</p>
                                                <h4 class="fw-semibold mt-1">{{ \App\Models\Category::count() }}</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                            <div>
                                                <a class="text-warning" href="{{ route('category.index') }}">View All
                                                    <i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                            </div>
                                            <div class="text-end"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card for Utilities -->
                    <div class="col-xxl-6 col-lg-4 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                    <span class="avatar avatar-md avatar-rounded bg-info">
                                        <i class="fa fa-tools"></i> <!-- Icon for Utilities -->
                                    </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Total Utilities</p>
                                                <h4 class="fw-semibold mt-1">{{ \App\Models\Utility::count() }}</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                            <div>
                                                <a class="text-info" href="{{ route('utilities.index') }}">View All
                                                    <i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                            </div>
                                            <div class="text-end"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card for Projects -->
                    <div class="col-xxl-6 col-lg-4 col-md-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex align-items-top justify-content-between">
                                    <div>
                                    <span class="avatar avatar-md avatar-rounded bg-secondary">
                                        <i class="fa fa-briefcase"></i> <!-- Icon for Projects -->
                                    </span>
                                    </div>
                                    <div class="flex-fill ms-3">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                <p class="text-muted mb-0">Total Projects</p>
                                                <h4 class="fw-semibold mt-1">{{ \App\Models\Project::count() }}</h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                            <div>
                                                <a class="text-secondary" href="{{ route('projects.index') }}">View All
                                                    <i class="ti ti-arrow-narrow-right ms-2 fw-semibold d-inline-block"></i></a>
                                            </div>
                                            <div class="text-end"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End::row-1 -->

        </div>
    </div>
    <!-- End::app-content -->

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
        <!-- Modal content here -->
    </div>

@endsection
