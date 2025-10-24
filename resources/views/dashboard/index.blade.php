@extends('dashboard.partials.app')
@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
      <!-- ✅ Success Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
                <!-- Card for Projects -->
                <div class="col-xxl-6 col-lg-4 col-md-6">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-top justify-content-between">
                                <div>
                                    <span class="avatar avatar-md avatar-rounded bg-secondary">
                                        <i class="fa fa-briefcase"></i>
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

                <!-- Pixxi Sync Buttons -->
                <div class="col-xxl-6 col-lg-8 col-md-6">
                    <div class="card custom-card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="mb-3">Sync Pixxi Properties</h5>
                            <a href="{{ url('/sync-pixxi?listingType=SELL') }}" class="btn btn-primary me-2">
                                Sync SELL Listings
                            </a>
                            <a href="{{ url('/sync-pixxi?listingType=RENT') }}" class="btn btn-success">
                                Sync RENT Listings
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End:: Pixxi Sync Buttons -->

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
