@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Property</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Property</li>
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
                            <!-- Category -->
                            <div class="col-md-12 mb-3">
                                <label for="category_id" style="font-size: 21px">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Title-->
                            <div class="col-md-12 mb-3">
                                <label for="title" style="font-size: 21px">Marketing Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter project title" value="{{ old('title', $project->title) }}">
                            </div>
                            <!-- Location Name and Google Maps Link -->
                            <div class="col-md-12 mb-3">
                                <label for="location_name" style="font-size: 21px">Location Name</label>
                                <input type="text" name="location_name" class="form-control" placeholder="Enter location name" value="{{ old('location_name', $project->location_name ?? '') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="location_link" style="font-size: 21px">Google Maps Link</label>
                                <input type="url" name="location_link" class="form-control" placeholder="Enter Google Maps link" value="{{ old('location_link', $project->location_link ?? '') }}">
                            </div>

                            <!-- Tags (Bootstrap Tags Input) -->
                            <div class="col-md-12 mb-3">
                                <label for="tags" style="font-size: 21px">Tags</label>
                                <input type="text" name="tags[]" class="form-control" placeholder="Enter tags" value="{{ old('tags') ? implode(',', old('tags')) : implode(',', $project->tags) }}" data-role="tagsinput">
                            </div>

                            <!-- Utilities -->
                            <div class="col-md-12 mb-3">
                                <h3>Utilities</h3>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms" style="font-size: 21px">Bedrooms</label>
                                <input type="text" name="bedrooms" class="form-control" placeholder="Number of Bedrooms" value="{{ old('bedrooms', $project->utility->bedrooms) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms" style="font-size: 21px">Bathrooms</label>
                                <input type="text" name="bathrooms" class="form-control" placeholder="Number of Bathrooms" value="{{ old('bathrooms', $project->utility->bathrooms) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="floor_area" style="font-size: 21px">Floor Area (sq ft)</label>
                                <input type="text" name="floor_area" class="form-control" placeholder="Enter floor area" value="{{ old('floor_area', $project->floor_area) }}">
                            </div>

               <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="swimming_pool" id="swimming_pool" {{ old('swimming_pool', $project->utility->swimming_pool) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="swimming_pool">
                                        Shared Pool
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="gym" id="gym" {{ old('gym', $project->utility->gym) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gym">
                                        Shard Gym
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="garden" id="garden" {{ old('garden', $project->utility->garden) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="garden">
                                        Garden
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="air_conditioning" id="air_conditioning" {{ old('air_conditioning', $project->utility->air_conditioning) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="air_conditioning">
                                        Central A/C
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="balcony" id="balcony" {{ old('balcony', $project->utility->balcony) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="balcony">
                                        Balcony
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="view_of_landmarks" id="view_of_landmarks" {{ old('view_of_landmarks', $project->utility->view_of_landmarks) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="view_of_landmarks">
                                        View of Landmarks
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="built_in_wardrobes" id="built_in_wardrobes" {{ old('built_in_wardrobes', $project->utility->built_in_wardrobes) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="built_in_wardrobes">
                                        Built-in Wardrobes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="furnished" id="furnished" {{ old('furnished', $project->utility->furnished) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="furnished">
                                        Furnished
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="garage_facility" id="garage_facility" {{ old('garage_facility', $project->utility->garage_facility) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="garage_facility">
                                        Garage Facility
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fire_security" id="fire_security" {{ old('fire_security', $project->utility->fire_security) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="fire_security">
                                        Fire Security
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fire_place_facility" id="fire_place_facility" {{ old('fire_place_facility', $project->utility->fire_place_facility) ? 'checked' : '' }}>
                                <label for="fire_place_facility">Children's Pool</label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="play_ground" id="play_ground" {{ old('play_ground', $project->utility->play_ground) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="play_ground">
                                        Children's Play Area
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="high_class_door" id="high_class_door" {{ old('high_class_door', $project->utility->high_class_door) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="high_class_door">
                                        High-Class Doors
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="marble_floor" id="marble_floor" {{ old('marble_floor', $project->utility->marble_floor) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="marble_floor">
                                        Marble Floors
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="store_room" id="store_room" {{ old('store_room', $project->utility->store_room) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="store_room">
                                        Store Room
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="floor_heating_system" id="floor_heating_system" {{ old('floor_heating_system', $project->utility->floor_heating_system) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="floor_heating_system">
                                        Floor Heating System
                                    </label>
                                </div>
                            </div>
                            <!-- NEW -->
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="concierge" id="concierge" {{ old('Concierge') ? 'checked' : '' }}>
                                <label for="concierge">Concierge</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="shared_spa" id="shared_spa" {{ old('shared_spa') ? 'checked' : '' }}>
                                <label for="shared_spa">Shared Spa</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="pets_allowed" id="pets_allowed" {{ old('pets_allowed') ? 'checked' : '' }}>
                                <label for="pets_allowed">Pets Allowed</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="lobby_in_building" id="lobby_in_building" {{ old('lobby_in_building') ? 'checked' : '' }}>
                                <label for="lobby_in_building">Lobby in Building</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="view_of_water" id="view_of_water" {{ old('view_of_water') ? 'checked' : '' }}>
                                <label for="view_of_water">View of Water</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="security" id="security" {{ old('security') ? 'checked' : '' }}>
                                <label for="security">security</label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="checkbox" name="covered_parking" id="covered_parking" {{ old('covered_parking') ? 'checked' : '' }}>
                                <label for="covered_parking">Covered Parking</label>
                            </div>

                            <!-- Featured -->
                            <div class="col-md-12 mb-3">
                                <!-- Hidden field to handle unchecked case -->
                                <input type="hidden" name="featured" value="0">
                                <div class="form-check">
                                    <input type="checkbox" name="featured" class="form-check-input" id="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Mark as Featured</label>
                                </div>
                            </div>


                            <!-- Payment Option -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_option" style="font-size: 21px">Property type</label>
                                <select name="payment_option" class="form-control">
                                    <option value="">Select Payment Option</option>
                                    <option value="off-plan" {{ old('payment_option', $project->payment_option) == 'off-plan' ? 'selected' : '' }}>Off-Plan</option>
                                    <option value="ready" {{ old('payment_option', $project->payment_option) == 'ready' ? 'selected' : '' }}>Ready</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" style="font-size: 21px">Status</label>
                                <select name="status" class="form-control">
                                    <option value="available" {{ old('status', $project->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="sold_out" {{ old('status', $project->status) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                                </select>
                            </div>

                            <!-- Main Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="main_image" style="font-size: 21px">Main Image</label>
                                <input type="file" name="main_image" class="form-control">
                            </div>

                            <!-- Additional Images Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="images" style="font-size: 21px">Additional Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="rent_or_service" style="font-size: 21px">Property Type</label>
                                <select name="rent_or_service" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="rent" {{ $project->rent_or_service == 'rent' ? 'selected' : '' }}>Rent</option>
                                    <option value="sale" {{ $project->rent_or_service == 'sale' ? 'selected' : '' }}>Sale</option>
                                </select>
                            </div>

                            <!-- Selling Points (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="selling_points" style="font-size: 21px">Selling Points</label>
                                <div id="selling_points_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addSellingPoint()">+ Add Selling Point</button>
                                  @if($project->selling_points)
                                    @foreach($project->selling_points as $index => $point)
                                        <div class="input-group mb-2" id="selling_point_{{ $index }}">
                                            <input type="text" name="selling_points[{{ $index }}][label]" class="form-control" placeholder="Label" value="{{ $point['label'] }}">
                                            <input type="text" name="selling_points[{{ $index }}][value]" class="form-control" placeholder="Value" value="{{ $point['value'] }}">
                                            <button type="button" class="btn btn-danger" onclick="removeSellingPoint({{ $index }})">Remove</button>
                                        </div>
                                    @endforeach
                                  @endif
                                </div>
                            </div>

                            <!-- More Information (Dynamic) -->
                            <div class="col-md-12 mb-3">
                                <label for="more_information" style="font-size: 21px">More Information</label>
                                <div id="more_information_wrapper">
                                    <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="addMoreInformation()">+ Add Information</button>
                                  @if($project->more_information)
                                    @foreach($project->more_information as $index => $info)
                                        <div class="input-group mb-2" id="info_{{ $index }}">
                                            <input type="text" name="more_information[{{ $index }}][label]" class="form-control" placeholder="Label" value="{{ $info['label'] }}">
                                            <input type="text" name="more_information[{{ $index }}][value]" class="form-control" placeholder="Value" value="{{ $info['value'] }}">
                                            <button type="button" class="btn btn-danger" onclick="removeMoreInformation({{ $index }})">Remove</button>
                                        </div>
                                    @endforeach
                                  @endif
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="price" style="font-size: 21px">Price</label>
                                <input type="number" name="price" class="form-control" placeholder="Enter price" value="{{ old('price', $project->price) }}" step="0.01">
                            </div>

                            <!-- Description (WYSIWYG Editor) -->
                            <div class="col-md-12 mb-3">
                                <label for="description" style="font-size: 21px">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $project->description) }}</textarea>
                            </div>


                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Update Property</button>
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
@php
$selling_counter = 0;
$more_counter = 0;
if($project->selling_points)
	$selling_counter = count($project?->selling_points);
if($project->more_information)
	$more_counter = count($project?->more_information);

@endphp
    <script>
        let sellingPointCount = {{ $selling_counter }};
        let moreInfoCount = {{ $more_counter }};

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
