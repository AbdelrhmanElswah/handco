@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Off Plan Project</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('off-plan-projects.index') }}">Off Plan Projects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Project</li>
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
                    <form method="POST" action="{{ route('off-plan-projects.update', $offPlanProject->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <!-- Project Name -->
                            <div class="col-md-12 mb-3">
                                <label for="project_name" style="font-size: 21px">Project Name <span class="text-danger">*</span></label>
                                <input type="text" name="project_name" class="form-control" placeholder="Enter project name" value="{{ old('project_name', $offPlanProject->project_name) }}" required>
                            </div>

                            <!-- Developer -->
                            <div class="col-md-6 mb-3">
                                <label for="developer" style="font-size: 21px">Developer <span class="text-danger">*</span></label>
                                <input type="text" name="developer" class="form-control" placeholder="Enter developer name" value="{{ old('developer', $offPlanProject->developer) }}" required>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6 mb-3">
                                <label for="location" style="font-size: 21px">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control" placeholder="Enter location" value="{{ old('location', $offPlanProject->location) }}" required>
                            </div>

                            <!-- Location Link -->
                            <div class="col-md-6 mb-3">
                                <label for="location_link" style="font-size: 21px">Google Maps Link</label>
                                <input type="url" name="location_link" class="form-control" placeholder="Enter Google Maps link" value="{{ old('location_link', $offPlanProject->location_link) }}">
                            </div>

                            <!-- Development Type -->
                            <div class="col-md-6 mb-3">
                                <label for="development_type" style="font-size: 21px">Development Type</label>
                                <input type="text" name="development_type" class="form-control" placeholder="e.g., Apartments, Villas, Townhouses" value="{{ old('development_type', $offPlanProject->development_type) }}">
                            </div>

                            <!-- Starting Price -->
                            <div class="col-md-6 mb-3">
                                <label for="starting_price" style="font-size: 21px">Starting Price (AED)</label>
                                <input type="text" name="starting_price" class="form-control" placeholder="Enter starting price (e.g., 1,450,000 or Contact for pricing)" value="{{ old('starting_price', $offPlanProject->starting_price) }}">
                            </div>

                            <!-- Completion Date -->
                            <div class="col-md-6 mb-3">
                                <label for="completion_date" style="font-size: 21px">Completion Date</label>
                                <input type="text" name="completion_date" class="form-control" placeholder="e.g., June 2030" value="{{ old('completion_date', $offPlanProject->completion_date) }}">
                            </div>

                            <!-- Overview (WYSIWYG) -->
                            <div class="col-md-12 mb-3">
                                <label for="overview" style="font-size: 21px">Overview</label>
                                <textarea name="overview" id="overview" class="form-control">{{ old('overview', $offPlanProject->overview) }}</textarea>
                            </div>

                            <!-- Description (WYSIWYG) -->
                            <div class="col-md-12 mb-3">
                                <label for="description" style="font-size: 21px">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $offPlanProject->description) }}</textarea>
                            </div>

                            <!-- Key Features (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="key_features" style="font-size: 21px">Key Features & Amenities</label>
                                <div id="key_features_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addKeyFeature()">+ Add Feature</button>
                                    @if(old('key_features') || $offPlanProject->key_features)
                                        @php
                                            $features = old('key_features', $offPlanProject->key_features ?? []);
                                        @endphp
                                        @foreach($features as $index => $feature)
                                            <div class="input-group mb-2" id="key_feature_{{ $index }}">
                                                <input type="text" name="key_features[]" class="form-control" placeholder="Enter feature name" value="{{ $feature }}">
                                                <button type="button" class="btn btn-danger" onclick="removeKeyFeature({{ $index }})">Remove</button>
                                            </div>
                                        @endforeach
                                        @php $keyFeatureCount = count($features); @endphp
                                    @else
                                        <div class="input-group mb-2" id="key_feature_0">
                                            <input type="text" name="key_features[]" class="form-control" placeholder="Enter feature name">
                                            <button type="button" class="btn btn-danger" onclick="removeKeyFeature(0)">Remove</button>
                                        </div>
                                        @php $keyFeatureCount = 1; @endphp
                                    @endif
                                </div>
                            </div>

                            <!-- Payment Plan (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="payment_plan" style="font-size: 21px">Payment Plan</label>
                                <div id="payment_plan_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addPaymentPlan()">+ Add Payment Plan</button>
                                    @if(old('payment_plan_title') || $offPlanProject->payment_plan)
                                        @php
                                            $paymentPlans = old('payment_plan_title') ? 
                                                array_map(function($i) {
                                                    return [
                                                        'title' => old('payment_plan_title')[$i] ?? '',
                                                        'percentage' => old('payment_plan_percentage')[$i] ?? '',
                                                        'description' => old('payment_plan_description')[$i] ?? ''
                                                    ];
                                                }, array_keys(old('payment_plan_title'))) : 
                                                ($offPlanProject->payment_plan ?? []);
                                        @endphp
                                        @foreach($paymentPlans as $index => $plan)
                                            <div class="row mb-2" id="payment_plan_{{ $index }}">
                                                <div class="col-md-4">
                                                    <input type="text" name="payment_plan_title[]" class="form-control" placeholder="Title" value="{{ $plan['title'] ?? '' }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" name="payment_plan_percentage[]" class="form-control" placeholder="Percentage" value="{{ $plan['percentage'] ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="payment_plan_description[]" class="form-control" placeholder="Description" value="{{ $plan['description'] ?? '' }}">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger" onclick="removePaymentPlan({{ $index }})">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                        @php $paymentPlanCount = count($paymentPlans); @endphp
                                    @else
                                        <div class="row mb-2" id="payment_plan_0">
                                            <div class="col-md-4">
                                                <input type="text" name="payment_plan_title[]" class="form-control" placeholder="Title">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="payment_plan_percentage[]" class="form-control" placeholder="Percentage">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="payment_plan_description[]" class="form-control" placeholder="Description">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger" onclick="removePaymentPlan(0)">Remove</button>
                                            </div>
                                        </div>
                                        @php $paymentPlanCount = 1; @endphp
                                    @endif
                                </div>
                            </div>

                            <!-- Nearby Attractions (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="nearby_attractions" style="font-size: 21px">Nearby Attractions</label>
                                <div id="nearby_attractions_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addNearbyAttraction()">+ Add Attraction</button>
                                    @if(old('nearby_attractions_name') || $offPlanProject->nearby_attractions)
                                        @php
                                            $attractions = old('nearby_attractions_name') ? 
                                                array_map(function($i) {
                                                    return [
                                                        'time' => old('nearby_attractions_time')[$i] ?? '',
                                                        'name' => old('nearby_attractions_name')[$i] ?? ''
                                                    ];
                                                }, array_keys(old('nearby_attractions_name'))) : 
                                                ($offPlanProject->nearby_attractions ?? []);
                                        @endphp
                                        @foreach($attractions as $index => $attraction)
                                            <div class="row mb-2" id="nearby_attraction_{{ $index }}">
                                                <div class="col-md-5">
                                                    <input type="text" name="nearby_attractions_time[]" class="form-control" placeholder="Time" value="{{ $attraction['time'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="nearby_attractions_name[]" class="form-control" placeholder="Name" value="{{ $attraction['name'] ?? '' }}">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger" onclick="removeNearbyAttraction({{ $index }})">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                        @php $nearbyAttractionCount = count($attractions); @endphp
                                    @else
                                        <div class="row mb-2" id="nearby_attraction_0">
                                            <div class="col-md-5">
                                                <input type="text" name="nearby_attractions_time[]" class="form-control" placeholder="Time">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="nearby_attractions_name[]" class="form-control" placeholder="Name">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger" onclick="removeNearbyAttraction(0)">Remove</button>
                                            </div>
                                        </div>
                                        @php $nearbyAttractionCount = 1; @endphp
                                    @endif
                                </div>
                            </div>

                            <!-- Main Image -->
                            <div class="col-md-6 mb-3">
                                <label for="main_image" style="font-size: 21px">Main Image</label>
                                @if($offPlanProject->mainImage)
                                    <div class="mb-2 position-relative" style="display: inline-block;">
                                        <img src="{{ $offPlanProject->mainImage->media_link }}" alt="Current image" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e0e0e0;">
                                        <button type="button" 
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-main-image-btn" 
                                                data-project-id="{{ $offPlanProject->id }}"
                                                onclick="deleteMainImage({{ $offPlanProject->id }}, this)"
                                                style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <p class="text-muted">Current image (click trash icon to delete)</p>
                                @endif
                                <input type="file" name="main_image" class="form-control" accept="image/*">
                                <small class="text-muted">{{ $offPlanProject->mainImage ? 'Upload a new image to replace the current one' : 'Upload main image' }}</small>
                            </div>

                            <!-- Gallery Images -->
                            <div class="col-md-6 mb-3">
                                <label for="gallery_images" style="font-size: 21px">Gallery Images</label>
                                @if($offPlanProject->galleryImages->count() > 0)
                                    <div class="mb-3">
                                        <div class="row g-2" id="current-gallery-images">
                                            @foreach($offPlanProject->galleryImages as $image)
                                                <div class="col-6 col-md-4 col-lg-3 position-relative gallery-image-item" data-image-id="{{ $image->id }}">
                                                    <div class="position-relative" style="border-radius: 8px; overflow: hidden; border: 2px solid #e0e0e0;">
                                                        <img src="{{ $image->media_link }}" alt="Gallery image" class="w-100" style="height: 120px; object-fit: cover;">
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-gallery-image-btn" 
                                                                data-image-id="{{ $image->id }}"
                                                                onclick="deleteGalleryImage({{ $image->id }}, this)"
                                                                style="padding: 4px 8px; font-size: 12px;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p class="text-muted mt-2">Current gallery images (click trash icon to delete)</p>
                                    </div>
                                @endif
                                <input type="file" name="gallery_images[]" id="gallery_images" class="form-control" multiple accept="image/*">
                                <small class="text-muted">You can select multiple images at once to add to gallery (hold Ctrl/Cmd to select multiple files)</small>
                                <div id="gallery_images_count" class="text-primary mt-2" style="display: none;"></div>
                            </div>

                            <!-- Featured for Homepage -->
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="is_featured" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured', $offPlanProject->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Featured for Homepage</label>
                                </div>
                            </div>

                            <!-- Active -->
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="is_active" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $offPlanProject->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Update Off Plan Project</button>
                                <a href="{{ route('off-plan-projects.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@push('script')
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('overview');
        // description is handled globally

        // Dynamic fields counters - use var for global scope
        var keyFeatureCount = {{ $keyFeatureCount ?? 1 }};
        var paymentPlanCount = {{ $paymentPlanCount ?? 1 }};
        var nearbyAttractionCount = {{ $nearbyAttractionCount ?? 1 }};

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
                '<input type="text" name="payment_plan_title[]" class="form-control" placeholder="Title">' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input type="text" name="payment_plan_percentage[]" class="form-control" placeholder="Percentage">' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input type="text" name="payment_plan_description[]" class="form-control" placeholder="Description">' +
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
                '<input type="text" name="nearby_attractions_time[]" class="form-control" placeholder="Time">' +
                '</div>' +
                '<div class="col-md-6">' +
                '<input type="text" name="nearby_attractions_name[]" class="form-control" placeholder="Name">' +
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

        // Delete Gallery Image Function
        function deleteGalleryImage(imageId, buttonElement) {
            if (!confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
                return;
            }

            fetch('{{ url("/admin/off-plan-projects/gallery-image") }}/' + imageId + '/delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the image from the grid
                    const imageItem = buttonElement.closest('.gallery-image-item');
                    if (imageItem) {
                        imageItem.remove();
                    }
                    
                    // Show message if no images left
                    const remainingImages = document.querySelectorAll('.gallery-image-item');
                    if (remainingImages.length === 0) {
                        const container = document.getElementById('current-gallery-images');
                        if (container) {
                            container.innerHTML = '<p class="text-muted">No gallery images. Upload new images below.</p>';
                        }
                    }
                    
                    // Show success message
                    alert('Image deleted successfully!');
                } else {
                    alert('Error deleting image: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting image. Please try again.');
            });
        }

        // Delete Main Image Function
        function deleteMainImage(projectId, buttonElement) {
            if (!confirm('Are you sure you want to delete the main image? This action cannot be undone.')) {
                return;
            }

            fetch('{{ url("/admin/off-plan-projects") }}/' + projectId + '/main-image/delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the image display
                    const imageContainer = buttonElement.closest('.mb-2');
                    if (imageContainer) {
                        imageContainer.remove();
                    }
                    
                    // Update the small text
                    const smallText = document.querySelector('input[name="main_image"]').nextElementSibling;
                    if (smallText) {
                        smallText.textContent = 'Upload main image';
                    }
                    
                    // Show success message
                    alert('Main image deleted successfully!');
                } else {
                    alert('Error deleting image: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting image. Please try again.');
            });
        }
    </script>
@endpush
@endsection

