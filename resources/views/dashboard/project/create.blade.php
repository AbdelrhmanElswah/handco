@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add Property</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Property</li>
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

                            <!-- Category -->
                            <div class="col-md-12 mb-3">
                                <label for="category_id" style="font-size: 21px">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Title and Price -->
                            <div class="col-md-6 mb-3">
                                <label for="title" style="font-size: 21px">Marketing Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter project title" value="{{ old('title') }}">
                            </div>



                            <!-- Location Name and Google Maps Link -->
                            <div class="col-md-6 mb-3">
                                <label for="location_name" style="font-size: 21px">Location Name</label>
                                <input type="text" name="location_name" class="form-control" placeholder="Enter location name" value="{{ old('location_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location_link" style="font-size: 21px">Google Maps Link</label>
                                <input type="url" name="location_link" class="form-control" placeholder="Enter Google Maps link" value="{{ old('location_link') }}">
                            </div>

                            <!-- Tags (Bootstrap Tags Input) -->
                            <div class="col-md-6 mb-3">
                                <label for="tags" style="font-size: 21px">Tags</label>
                                <input type="text" name="tags[]" class="form-control" placeholder="Enter tags"
                                       value="{{ old('tags') ? implode(',', old('tags')) : '' }}" data-role="tagsinput">
                            </div>
                            <!-- Utilities -->
                            <div class="col-md-12 mb-3">
                                <h3>Utilities</h3>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms" style="font-size: 21px">Bedrooms</label>
                                <input type="text" name="bedrooms" id="bedrooms" class="form-control" placeholder="Number of Bedrooms" value="{{ old('bedrooms') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms" style="font-size: 21px">Bathrooms</label>
                                <input type="text" name="bathrooms" id="bathrooms" class="form-control" placeholder="Number of Bathrooms" value="{{ old('bathrooms') }}">
                            </div>
                            <!-- Floor Area -->
                            <div class="col-md-4 mb-3">
                                <label for="floor_area" style="font-size: 21px">Floor Area (sq ft)</label>
                                <input type="text" name="floor_area" class="form-control" placeholder="Enter floor area" value="{{ old('floor_area') }}">
                            </div>


                            <!-- Boolean Utilities -->
                            <div class="col-md-3">
                                <input type="checkbox" name="swimming_pool" id="swimming_pool" {{ old('swimming_pool') ? 'checked' : '' }}>
                                <label for="swimming_pool">Swimming Pool</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="gym" id="gym" {{ old('gym') ? 'checked' : '' }}>
                                <label for="gym">Gym</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="garden" id="garden" {{ old('garden') ? 'checked' : '' }}>
                                <label for="garden">Garden</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="air_conditioning" id="air_conditioning" {{ old('air_conditioning') ? 'checked' : '' }}>
                                <label for="air_conditioning">Air Conditioning</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="furnished" id="furnished" {{ old('furnished') ? 'checked' : '' }}>
                                <label for="furnished">Furnished</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="garage_facility" id="garage_facility" {{ old('garage_facility') ? 'checked' : '' }}>
                                <label for="garage_facility">Garage Facility</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="fire_security" id="fire_security" {{ old('fire_security') ? 'checked' : '' }}>
                                <label for="fire_security">Fire Security</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="fire_place_facility" id="fire_place_facility" {{ old('fire_place_facility') ? 'checked' : '' }}>
                                <label for="fire_place_facility">Fire Place Facility</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="play_ground" id="play_ground" {{ old('play_ground') ? 'checked' : '' }}>
                                <label for="play_ground">Play Ground</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="marble_floor" id="marble_floor" {{ old('marble_floor') ? 'checked' : '' }}>
                                <label for="marble_floor">Marble Floor</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="store_room" id="store_room" {{ old('store_room') ? 'checked' : '' }}>
                                <label for="store_room">Store Room</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="high_class_door" id="high_class_door" {{ old('high_class_door') ? 'checked' : '' }}>
                                <label for="high_class_door">High-Class Door</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="floor_heating_system" id="floor_heating_system" {{ old('floor_heating_system') ? 'checked' : '' }}>
                                <label for="floor_heating_system">Floor Heating System</label>
                            </div>
                            <div class="col-md-12 mb-3">
                                <!-- Hidden field to handle unchecked case -->
                                <input type="hidden" name="featured" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="featured" class="form-check-input" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured" >Mark as Featured</label>
                                </div>
                            </div>

                            <!-- Payment Option -->
                            <div class="col-md-12 mb-3">
                                <label for="payment_option" style="font-size: 21px">Property type</label>
                                <select name="payment_option" class="form-control">
                                    <option value="">Select Payment Option</option>
                                    <option value="off-plan" {{ old('payment_option') == 'off-plan' ? 'selected' : '' }}>Off-Plan</option>
                                    <option value="ready" {{ old('payment_option') == 'ready' ? 'selected' : '' }}>Ready</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" style="font-size: 21px">Status</label>
                                <select name="status" class="form-control">
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                                </select>
                            </div>

                            <!-- Main Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="main_image" style="font-size: 21px">Main Image</label>
                                <input type="file" name="main_image" class="form-control" required>
                            </div>

                            <!-- Additional Images Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="images" style="font-size: 21px">Additional Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>

                            <!-- Selling Points (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="selling_points" style="font-size: 21px">Selling Points</label>
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
                                <label for="more_information" style="font-size: 21px">More Information</label>
                                <div id="more_information_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addMoreInformation()">+ Add Information</button>
                                    <div class="input-group mb-2" id="info_0">
                                        <input type="text" name="more_information[0][label]" class="form-control" placeholder="Label">
                                        <input type="text" name="more_information[0][value]" class="form-control" placeholder="Value">
                                        <button type="button" class="btn btn-danger" onclick="removeMoreInformation(0)">Remove</button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <label for="price" style="font-size: 21px">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter price" value="{{ old('price') }}" step="0.01">
                            </div>

                            <!-- Description (WYSIWYG Editor) -->
                            <div class="col-md-12 mb-3">
                                <label for="description" style="font-size: 21px">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Add Property</button>
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
        // Declare counters for dynamic fields at the top
        let sellingPointCount = 1;
        let moreInfoCount = 1;

        $('input[data-role="tagsinput"]').tagsinput();
        CKEDITOR.replace('description');

        // Dynamic fields for Selling Points and More Information
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
