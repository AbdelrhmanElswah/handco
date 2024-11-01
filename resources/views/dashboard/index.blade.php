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
                                                <h4 class="fw-semibold mt-1"> <!-- Display total categories here --></h4>
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
                                                <h4 class="fw-semibold mt-1"> <!-- Display total utilities here --></h4>
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
                                                <h4 class="fw-semibold mt-1"> <!-- Display total projects here --></h4>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group">
                        <a href="javascript:void(0);" class="input-group-text" id="Search-Grid">
                            <i class="fe fe-search header-link-icon fs-18"></i>
                        </a>
                        <input type="search" class="form-control border-0 px-2" placeholder="Search" aria-label="Search">
                        <a href="javascript:void(0);" class="input-group-text" id="voice-search">
                            <i class="fe fe-mic header-link-icon"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fe fe-more-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <p class="font-weight-semibold text-muted mb-2">Are You Looking For...</p>
                        <span class="search-tags">
                            <i class="fe fe-user me-2"></i>People<a href="javascript:void(0)" class="tag-addon">
                                <i class="fe fe-x"></i></a>
                        </span>
                        <span class="search-tags">
                            <i class="fe fe-file-text me-2"></i>Pages<a href="javascript:void(0)" class="tag-addon">
                                <i class="fe fe-x"></i></a>
                        </span>
                        <span class="search-tags">
                            <i class="fe fe-align-left me-2"></i>Articles<a href="javascript:void(0)" class="tag-addon">
                                <i class="fe fe-x"></i></a>
                        </span>
                        <span class="search-tags">
                            <i class="fe fe-server me-2"></i>Tags<a href="javascript:void(0)" class="tag-addon">
                                <i class="fe fe-x"></i></a>
                        </span>
                    </div>
                    <div class="my-4">
                        <p class="font-weight-semibold text-muted mb-2">Recent Search:</p>
                        <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                            <a href="notifications.html"><span>Notifications</span></a>
                            <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fe fe-x text-muted"></i>
                            </a>
                        </div>
                        <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                            <a href="alerts.html"><span>Alerts</span></a>
                            <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fe fe-x text-muted"></i>
                            </a>
                        </div>
                        <div class="p-2 border br-5 d-flex align-items-center text-muted mb-0 alert">
                            <a href="mail.html"><span>Mail</span></a>
                            <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fe fe-x text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group ms-auto">
                        <button class="btn btn-sm btn-primary-light">Search</button>
                        <button class="btn btn-sm btn-primary">Clear Recents</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
