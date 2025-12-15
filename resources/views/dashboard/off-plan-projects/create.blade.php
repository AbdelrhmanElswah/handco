@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add Off Plan Project</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('off-plan-projects.index') }}">Off Plan Projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Project</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('off-plan-projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Project Name -->
                            <div class="col-md-12 mb-3">
                                <label for="project_name" style="font-size: 21px">Project Name <span class="text-danger">*</span></label>
                                <input type="text" name="project_name" class="form-control" placeholder="Enter project name" value="{{ old('project_name') }}" required>
                            </div>

                            <!-- Developer -->
                            <div class="col-md-6 mb-3">
                                <label for="developer" style="font-size: 21px">Developer <span class="text-danger">*</span></label>
                                <input type="text" name="developer" class="form-control" placeholder="Enter developer name" value="{{ old('developer') }}" required>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6 mb-3">
                                <label for="location" style="font-size: 21px">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control" placeholder="Enter location" value="{{ old('location') }}" required>
                            </div>

                            <!-- Location Link -->
                            <div class="col-md-6 mb-3">
                                <label for="location_link" style="font-size: 21px">Google Maps Link</label>
                                <input type="url" name="location_link" class="form-control" placeholder="Enter Google Maps link" value="{{ old('location_link') }}">
                            </div>

                            <!-- Development Type -->
                            <div class="col-md-6 mb-3">
                                <label for="development_type" style="font-size: 21px">Development Type</label>
                                <input type="text" name="development_type" class="form-control" placeholder="e.g., Apartments, Villas, Townhouses" value="{{ old('development_type') }}">
                            </div>

                            <!-- Starting Price -->
                            <div class="col-md-6 mb-3">
                                <label for="starting_price" style="font-size: 21px">Starting Price (AED)</label>
                                <input type="number" name="starting_price" class="form-control" placeholder="Enter starting price" value="{{ old('starting_price') }}" step="0.01">
                            </div>

                            <!-- Completion Date -->
                            <div class="col-md-6 mb-3">
                                <label for="completion_date" style="font-size: 21px">Completion Date</label>
                                <input type="text" name="completion_date" class="form-control" placeholder="e.g., June 2030" value="{{ old('completion_date') }}">
                            </div>

                            <!-- Overview (WYSIWYG) -->
                            <div class="col-md-12 mb-3">
                                <label for="overview" style="font-size: 21px">Overview</label>
                                <textarea name="overview" id="overview" class="form-control">{{ old('overview') }}</textarea>
                            </div>

                            <!-- Description (WYSIWYG) -->
                            <div class="col-md-12 mb-3">
                                <label for="description" style="font-size: 21px">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <!-- Key Features (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="key_features" style="font-size: 21px">Key Features & Amenities</label>
                                <div id="key_features_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addKeyFeature()">+ Add Feature</button>
                                    <div class="input-group mb-2" id="key_feature_0">
                                        <input type="text" name="key_features[]" class="form-control" placeholder="Enter feature name">
                                        <button type="button" class="btn btn-danger" onclick="removeKeyFeature(0)">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Plan (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="payment_plan" style="font-size: 21px">Payment Plan</label>
                                <div id="payment_plan_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addPaymentPlan()">+ Add Payment Plan</button>
                                    <div class="row mb-2" id="payment_plan_0">
                                        <div class="col-md-4">
                                            <input type="text" name="payment_plan_title[]" class="form-control" placeholder="Title (e.g., First Installment)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="payment_plan_percentage[]" class="form-control" placeholder="Percentage (e.g., 75%)">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="payment_plan_description[]" class="form-control" placeholder="Description (e.g., During construction)">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger" onclick="removePaymentPlan(0)">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nearby Attractions (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="nearby_attractions" style="font-size: 21px">Nearby Attractions</label>
                                <div id="nearby_attractions_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addNearbyAttraction()">+ Add Attraction</button>
                                    <div class="row mb-2" id="nearby_attraction_0">
                                        <div class="col-md-5">
                                            <input type="text" name="nearby_attractions_time[]" class="form-control" placeholder="Time (e.g., 15 Minutes)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="nearby_attractions_name[]" class="form-control" placeholder="Name (e.g., Sports City, Motor City)">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger" onclick="removeNearbyAttraction(0)">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Image -->
                            <div class="col-md-6 mb-3">
                                <label for="main_image" style="font-size: 21px">Main Image <span class="text-danger">*</span></label>
                                <input type="file" name="main_image" class="form-control" required accept="image/*">
                            </div>

                            <!-- Gallery Images -->
                            <div class="col-md-6 mb-3">
                                <label for="gallery_images" style="font-size: 21px">Gallery Images</label>
                                <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple accept="image/*">
                                <small class="text-muted">You can select multiple images at once (hold Ctrl/Cmd to select multiple files)</small>
                                <div id="gallery_images_count" class="text-primary mt-2" style="display: none;"></div>
                            </div>

                            <!-- Featured for Homepage -->
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="is_featured" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured for Homepage</label>
                                </div>
                            </div>

                            <!-- Active -->
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="is_active" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Add Off Plan Project</button>
                                <a href="{{ route('off-plan-projects.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- WYSIWYG Editor Scripts -->
    <script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('overview');
        CKEDITOR.replace('description');

        // Dynamic fields counters - use var for global scope
        var keyFeatureCount = 1;
        var paymentPlanCount = 1;
        var nearbyAttractionCount = 1;

        // Key Features functions
        function addKeyFeature() {
            var currentCount = keyFeatureCount;
            var html = '<div class="input-group mb-2" id="key_feature_' + currentCount + '">' +
                '<input type="text" name="key_features[]" class="form-control" placeholder="Enter feature name">' +
                '<button type="button" class="btn btn-danger" onclick="removeKeyFeature(' + currentCount + ')">Remove</button>' +
                '</div>';
            document.getElementById('key_features_wrapper').insertAdjacentHTML('beforeend', html);
            keyFeatureCount++;
        }

        function removeKeyFeature(id) {
            var element = document.getElementById('key_feature_' + id);
            if (element) {
                element.remove();
            }
        }

        // Payment Plan functions
        function addPaymentPlan() {
            var currentCount = paymentPlanCount;
            var html = '<div class="row mb-2" id="payment_plan_' + currentCount + '">' +
                '<div class="col-md-4">' +
                '<input type="text" name="payment_plan_title[]" class="form-control" placeholder="Title (e.g., First Installment)">' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input type="text" name="payment_plan_percentage[]" class="form-control" placeholder="Percentage (e.g., 75%)">' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input type="text" name="payment_plan_description[]" class="form-control" placeholder="Description (e.g., During construction)">' +
                '</div>' +
                '<div class="col-md-1">' +
                '<button type="button" class="btn btn-danger" onclick="removePaymentPlan(' + currentCount + ')">Remove</button>' +
                '</div>' +
                '</div>';
            document.getElementById('payment_plan_wrapper').insertAdjacentHTML('beforeend', html);
            paymentPlanCount++;
        }

        function removePaymentPlan(id) {
            var element = document.getElementById('payment_plan_' + id);
            if (element) {
                element.remove();
            }
        }

        // Nearby Attractions functions
        function addNearbyAttraction() {
            var currentCount = nearbyAttractionCount;
            var html = '<div class="row mb-2" id="nearby_attraction_' + currentCount + '">' +
                '<div class="col-md-5">' +
                '<input type="text" name="nearby_attractions_time[]" class="form-control" placeholder="Time (e.g., 15 Minutes)">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<input type="text" name="nearby_attractions_name[]" class="form-control" placeholder="Name (e.g., Sports City, Motor City)">' +
                '</div>' +
                '<div class="col-md-1">' +
                '<button type="button" class="btn btn-danger" onclick="removeNearbyAttraction(' + currentCount + ')">Remove</button>' +
                '</div>' +
                '</div>';
            document.getElementById('nearby_attractions_wrapper').insertAdjacentHTML('beforeend', html);
            nearbyAttractionCount++;
        }

        function removeNearbyAttraction(id) {
            var element = document.getElementById('nearby_attraction_' + id);
            if (element) {
                element.remove();
            }
        }

        // Show count of selected gallery images
        document.getElementById('gallery_images').addEventListener('change', function(e) {
            var count = e.target.files.length;
            var countDiv = document.getElementById('gallery_images_count');
            if (count > 0) {
                countDiv.textContent = count + ' image(s) selected';
                countDiv.style.display = 'block';
            } else {
                countDiv.style.display = 'none';
            }
        });
    </script>

@endsection

