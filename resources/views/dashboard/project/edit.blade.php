@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Project</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
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
                    <form method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Title and Price -->
                            <div class="col-md-6 mb-3">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter project title" value="{{ old('title', $project->title) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter price" value="{{ old('price', $project->price) }}" step="0.01">
                            </div>

                            <!-- Category -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location Name and Google Maps Link -->
                            <div class="col-md-6 mb-3">
                                <label for="location_name">Location Name</label>
                                <input type="text" name="location_name" class="form-control" placeholder="Enter location name" value="{{ old('location_name', $project->location_name ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location_link">Google Maps Link</label>
                                <input type="url" name="location_link" class="form-control" placeholder="Enter Google Maps link" value="{{ old('location_link', $project->location_link ?? '') }}">
                            </div>

                            <!-- Tags (Bootstrap Tags Input) -->
                            <div class="col-md-6 mb-3">
                                <label for="tags">Tags</label>
                                <input type="text" name="tags[]" class="form-control" placeholder="Enter tags" value="{{ old('tags') ? implode(',', old('tags')) : implode(',', $project->tags) }}" data-role="tagsinput">
                            </div>

                            <!-- Description (WYSIWYG Editor) -->
                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $project->description) }}</textarea>
                            </div>

                            <!-- Utilities -->
                            <div class="col-md-6 mb-3">
                                <label for="utilities_id">Utilities</label>
                                <select name="utilities_id" class="form-control">
                                    <option value="">Select Utility</option>
                                    @foreach($utilities as $utility)
                                        <option value="{{ $utility->id }}" {{ old('utilities_id', $project->utilities_id) == $utility->id ? 'selected' : '' }}>
                                            {{ $utility->bedrooms }} Bedrooms, {{ $utility->bathrooms }} Bathrooms, {{ $utility->parking_spaces }} Parking Spaces
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Floor Area -->
                            <div class="col-md-6 mb-3">
                                <label for="floor_area">Floor Area (sq ft)</label>
                                <input type="number" name="floor_area" class="form-control" placeholder="Enter floor area" value="{{ old('floor_area', $project->floor_area) }}">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="available" {{ old('status', $project->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="sold_out" {{ old('status', $project->status) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                                </select>
                            </div>

                            <!-- Payment Option -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_option">Payment Option</label>
                                <select name="payment_option" class="form-control">
                                    <option value="">Select Payment Option</option>
                                    <option value="Cash" {{ old('payment_option', $project->payment_option) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Installment" {{ old('payment_option', $project->payment_option) == 'Installment' ? 'selected' : '' }}>Installment</option>
                                </select>
                            </div>


                            <!-- Featured -->
                            <div class="col-md-6 mb-3">
                                <label for="featured">Featured</label>
                                <!-- Hidden field to handle unchecked case -->
                                <input type="hidden" name="featured" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="featured" class="form-check-input" id="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Mark as Featured</label>
                                </div>
                            </div>

                            <!-- Main Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="main_image">Main Image</label>
                                <input type="file" name="main_image" class="form-control">
                            </div>

                            <!-- Additional Images Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="images">Additional Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>

                            <!-- Selling Points (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="selling_points">Selling Points</label>
                                <div id="selling_points_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addSellingPoint()">+ Add Selling Point</button>
                                    @foreach($project->selling_points as $index => $point)
                                        <div class="input-group mb-2" id="selling_point_{{ $index }}">
                                            <input type="text" name="selling_points[{{ $index }}][label]" class="form-control" placeholder="Label" value="{{ $point['label'] }}">
                                            <input type="text" name="selling_points[{{ $index }}][value]" class="form-control" placeholder="Value" value="{{ $point['value'] }}">
                                            <button type="button" class="btn btn-danger" onclick="removeSellingPoint({{ $index }})">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- More Information (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="more_information">More Information</label>
                                <div id="more_information_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addMoreInformation()">+ Add Information</button>
                                    @foreach($project->more_information as $index => $info)
                                        <div class="input-group mb-2" id="info_{{ $index }}">
                                            <input type="text" name="more_information[{{ $index }}][label]" class="form-control" placeholder="Label" value="{{ $info['label'] }}">
                                            <input type="text" name="more_information[{{ $index }}][value]" class="form-control" placeholder="Value" value="{{ $info['value'] }}">
                                            <button type="button" class="btn btn-danger" onclick="removeMoreInformation({{ $index }})">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Update Project</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- WYSIWYG, Tags Input, and Dynamic Field Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        let sellingPointCount = {{ count($project->selling_points) }};
        let moreInfoCount = {{ count($project->more_information) }};

        $('input[data-role="tagsinput"]').tagsinput();
        CKEDITOR.replace('description');

        function addSellingPoint() {
            let html = `<div class="input-group mb-2" id="selling_point_${sellingPointCount}">
                <input type="text" name="selling_points[${sellingPointCount}][label]" class="form-control" placeholder="Label">
                <input type="text" name="selling_points[${sellingPointCount}][value]" class="form-control" placeholder="Value">
                <button type="button" class="btn btn-danger" onclick="removeSellingPoint(${sellingPointCount})">Remove</button>
            </div>`;
            document.getElementById('selling_points_wrapper').insertAdjacentHTML('beforeend', html);
            sellingPointCount++;
        }

        function removeSellingPoint(id) {
            document.getElementById(`selling_point_${id}`).remove();
        }

        function addMoreInformation() {
            let html = `<div class="input-group mb-2" id="info_${moreInfoCount}">
                    <input type="text" name="more_information[${moreInfoCount}][label]" class="form-control" placeholder="Label">
                    <input type="text" name="more_information[${moreInfoCount}][value]" class="form-control" placeholder="Value">
                    <button type="button" class="btn btn-danger" onclick="removeMoreInformation(${moreInfoCount})">Remove</button>
                </div>`;
            document.getElementById('more_information_wrapper').insertAdjacentHTML('beforeend', html);
            moreInfoCount++;
        }

        function removeMoreInformation(id) {
            document.getElementById(`info_${id}`).remove();
        }
    </script>

@endsection
