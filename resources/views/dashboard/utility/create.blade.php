@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Add Utility</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Utility</li>
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
                    <form method="POST" action="{{ route('utilities.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Bedrooms and Bathrooms Section -->
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms">Bedrooms</label>
                                <input type="number" name="bedrooms" class="form-control" placeholder="Enter number of bedrooms" value="{{ old('bedrooms') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms">Bathrooms</label>
                                <input type="number" name="bathrooms" class="form-control" placeholder="Enter number of bathrooms" value="{{ old('bathrooms') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="parking_spaces">Parking Spaces</label>
                                <input type="number" name="parking_spaces" class="form-control" placeholder="Enter parking spaces" value="{{ old('parking_spaces') }}">
                            </div>

                            <!-- Features Section with Switches -->
                            <div class="col-md-12 mt-4">
                                <h5 class="fw-bold">Features</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="swimming_pool" value="1" class="form-check-input me-2" {{ old('swimming_pool') ? 'checked' : '' }}>
                                            Swimming Pool
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="gym" value="1" class="form-check-input me-2" {{ old('gym') ? 'checked' : '' }}>
                                            Gym
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="garden" value="1" class="form-check-input me-2" {{ old('garden') ? 'checked' : '' }}>
                                            Garden
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="air_conditioning" value="1" class="form-check-input me-2" {{ old('air_conditioning') ? 'checked' : '' }}>
                                            Air Conditioning
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="furnished" value="1" class="form-check-input me-2" {{ old('furnished') ? 'checked' : '' }}>
                                            Furnished
                                        </label>
                                    </div>
                                    <!-- Additional Features Section -->
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="garage_facility" value="1" class="form-check-input me-2" {{ old('garage_facility') ? 'checked' : '' }}>
                                            Garage Facility
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="fire_security" value="1" class="form-check-input me-2" {{ old('fire_security') ? 'checked' : '' }}>
                                            Fire Security
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="fire_place_facility" value="1" class="form-check-input me-2" {{ old('fire_place_facility') ? 'checked' : '' }}>
                                            Fire Place Facility
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="play_ground" value="1" class="form-check-input me-2" {{ old('play_ground') ? 'checked' : '' }}>
                                            Play Ground
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="marble_floor" value="1" class="form-check-input me-2" {{ old('marble_floor') ? 'checked' : '' }}>
                                            Marble Floor
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="store_room" value="1" class="form-check-input me-2" {{ old('store_room') ? 'checked' : '' }}>
                                            Store Room
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="high_class_door" value="1" class="form-check-input me-2" {{ old('high_class_door') ? 'checked' : '' }}>
                                            High-Class Door
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="floor_heating_system" value="1" class="form-check-input me-2" {{ old('floor_heating_system') ? 'checked' : '' }}>
                                            Floor Heating System
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Add Utility</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
