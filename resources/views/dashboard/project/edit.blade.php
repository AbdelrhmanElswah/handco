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
                            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
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

                            <!-- Category and Location -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location">Location</label>
                                <input type="text" name="location" class="form-control" placeholder="Enter location" value="{{ old('location', $project->location) }}">
                            </div>

                            <!-- Tags (Bootstrap Tags Input) -->
                            <div class="col-md-6 mb-3">
                                <label for="tags">Tags</label>
                                <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter tags" value="{{ old('tags', implode(',', $project->tags ?? [])) }}" data-role="tagsinput">
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

                            <!-- Selling Points (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="selling_points">Selling Points</label>
                                <div id="selling_points_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addSellingPoint()">+ Add Selling Point</button>
                                    @foreach(old('selling_points', $project->selling_points ?? []) as $index => $sellingPoint)
                                        <div class="input-group mb-2" id="selling_point_{{ $index }}">
                                            <input type="text" name="selling_points[]" class="form-control" placeholder="Enter selling point" value="{{ $sellingPoint }}">
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
                                    @foreach(old('more_information', $project->more_information ?? []) as $index => $info)
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
        // Initialize Tags Input
        $(document).ready(function() {
            $('#tags').tagsinput({
                maxTags: 10,
                trimValue: true
            });
        });

        // Selling Points Dynamic Fields
        let sellingPointCount = {{ count(old('selling_points', $project->selling_points ?? [])) }};
        function addSellingPoint() {
            let html = `<div class="input-group mb-2" id="selling_point_${sellingPointCount}">
                        <input type="text" name="selling_points[]" class="form-control" placeholder="Enter selling point">
                        <button type="button" class="btn btn-danger" onclick="removeSellingPoint(${sellingPointCount})">Remove</button>
                    </div>`;
            document.getElementById('selling_points_wrapper').insertAdjacentHTML('beforeend', html);
            sellingPointCount++;
        }
        function removeSellingPoint(id) {
            document.getElementById(`selling_point_${id}`).remove();
        }

        // More Information Dynamic Fields
        let moreInfoCount = {{ count(old('more_information', $project->more_information ?? [])) }};
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
