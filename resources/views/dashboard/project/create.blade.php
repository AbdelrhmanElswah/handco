@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add Project</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
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
                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Title and Price -->
                            <div class="col-md-6 mb-3">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter project title" value="{{ old('title') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter price" value="{{ old('price') }}" step="0.01">
                            </div>

                            <!-- Category and Location -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" placeholder="Enter location" value="{{ old('location') }}">
                            </div>

                            <!-- Tags (Bootstrap Tags Input) -->
                            <div class="col-md-6 mb-3">
                                <label for="tags">Tags</label>
                                <input type="text" name="tags[]" class="form-control" placeholder="Enter tags" value="{{ old('tags') }}" data-role="tagsinput">
                            </div>

                            <!-- Description (WYSIWYG Editor) -->
                            <div class="col-md-12 mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <!-- Utilities -->
                            <div class="col-md-6 mb-3">
                                <label for="utilities_id">Utilities</label>
                                <select name="utilities_id" class="form-control">
                                    <option value="">Select Utility</option>
                                    @foreach($utilities as $utility)
                                        <option value="{{ $utility->id }}" {{ old('utilities_id') == $utility->id ? 'selected' : '' }}>
                                            {{ $utility->bedrooms }} Bedrooms, {{ $utility->bathrooms }} Bathrooms, {{ $utility->parking_spaces }} Parking Spaces
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Floor Area -->
                            <div class="col-md-6 mb-3">
                                <label for="floor_area">Floor Area (sq ft)</label>
                                <input type="number" name="floor_area" class="form-control" placeholder="Enter floor area" value="{{ old('floor_area') }}">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                                </select>
                            </div>

                            <!-- Main Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="main_image">Main Image</label>
                                <input type="file" name="main_image" class="form-control" required>
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
                                    <div class="input-group mb-2" id="selling_point_0">
                                        <input type="text" name="selling_points[0][label]" class="form-control" placeholder="Label">
                                        <input type="text" name="selling_points[0][value]" class="form-control" placeholder="Value">
                                        <button type="button" class="btn btn-danger" onclick="removeSellingPoint(0)">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <!-- More Information (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="more_information">More Information</label>
                                <div id="more_information_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addMoreInformation()">+ Add Information</button>
                                    <div class="input-group mb-2" id="info_0">
                                        <input type="text" name="more_information[0][label]" class="form-control" placeholder="Label">
                                        <input type="text" name="more_information[0][value]" class="form-control" placeholder="Value">
                                        <button type="button" class="btn btn-danger" onclick="removeMoreInformation(0)">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Add Project</button>
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

        $('input[data-role="tagsinput"]').tagsinput();

        // Selling Points Dynamic Fields
        let sellingPointCount = 1;
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

        // More Information Dynamic Fields
        let moreInfoCount = 1;
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
