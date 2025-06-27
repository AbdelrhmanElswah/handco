@extends('dashboard.partials.app')

@section('title', $property['name'] ?? 'Property Details')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        {{-- Breadcrumb Header --}}
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-0">Property Details</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pixxi.properties.index') }}">Pixxi Properties</a></li>
                        <li class="breadcrumb-item active">{{ $property['name'] ?? 'Unnamed Property' }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- Property Card --}}
        <div class="card shadow-sm">
            <div class="card-body">

                {{-- Title --}}
                <h2 class="mb-4">{{ $property['name'] ?? 'Unnamed Property' }}</h2>

                {{-- Images --}}
                @if (!empty($property['photos']) && is_array($property['photos']))
                    <div id="propertyImages" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @foreach ($property['photos'] as $index => $photo)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="https://oss.pixxicrm.com{{ $photo }}" class="d-block w-100 rounded"
                                         style="max-height: 500px; object-fit: cover;" alt="Property Image">
                                </div>
                            @endforeach
                        </div>
                        @if(count($property['photos']) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#propertyImages" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#propertyImages" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @endif

                {{-- Details --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><strong>Price:</strong> AED {{ number_format($property['price'] ?? 0) }}</li>
                            <li><strong>Size:</strong> {{ $property['size'] ?? '-' }} SqFt</li>
                            <li><strong>Bedrooms:</strong> {{ $property['bedRoomNum'] ?? '-' }}</li>
                            <li><strong>Status:</strong> {{ $property['status'] ?? '-' }}</li>
                            <li><strong>Region:</strong> {{ $property['regionName'] ?? '-' }}</li>
                            <li><strong>Community:</strong> {{ $property['communityName'] ?? '-' }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li><strong>Agent:</strong> {{ $property['agentName'] ?? '-' }}</li>
                            <li><strong>Phone:</strong> {{ $property['agentPhone'] ?? '-' }}</li>
                            @if (!empty($property['agentAvatar']))
                                <li class="mt-2">
                                    <img src="https://oss.pixxicrm.com{{ $property['agentAvatar'] }}" class="rounded-circle border" width="80">
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Description --}}
                <hr>
                <h5 class="mb-2">Description:</h5>
                <div style="white-space: pre-line; background-color: #f9f9f9; padding: 15px; border-radius: 6px;">
                    {{ $property['description'] ?? 'No Description Available' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
