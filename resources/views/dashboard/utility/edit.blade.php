@extends('dashboard.partials.app')
@section('content')

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Edit Utility</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Utility</li>
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
                    <form method="POST" action="{{ route('utilities.update', $utility->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Bedrooms and Bathrooms Section -->
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms">Bedrooms</label>
                                <input type="number" name="bedrooms" class="form-control" placeholder="Enter number of bedrooms" value="{{ old('bedrooms', $utility->bedrooms) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms">Bathrooms</label>
                                <input type="number" name="bathrooms" class="form-control" placeholder="Enter number of bathrooms" value="{{ old('bathrooms', $utility->bathrooms) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="parking_spaces">Parking Spaces</label>
                                <input type="number" name="parking_spaces" class="form-control" placeholder="Enter parking spaces" value="{{ old('parking_spaces', $utility->parking_spaces) }}">
                            </div>

                            <!-- Features Section with Toggle Switches -->
                            <div class="col-md-12 mt-4">
                                <h5 class="fw-bold">Features</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="swimming_pool" value="1" class="form-check-input me-2" {{ old('swimming_pool', $utility->swimming_pool) ? 'checked' : '' }}>
                                            Swimming Pool
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="gym" value="1" class="form-check-input me-2" {{ old('gym', $utility->gym) ? 'checked' : '' }}>
                                            Gym
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="garden" value="1" class="form-check-input me-2" {{ old('garden', $utility->garden) ? 'checked' : '' }}>
                                            Garden
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="air_conditioning" value="1" class="form-check-input me-2" {{ old('air_conditioning', $utility->air_conditioning) ? 'checked' : '' }}>
                                            Air Conditioning
                                        </label>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="checkbox" name="furnished" value="1" class="form-check-input me-2" {{ old('furnished', $utility->furnished) ? 'checked' : '' }}>
                                            Furnished
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Update Utility</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
