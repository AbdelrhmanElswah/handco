@extends('dashboard.partials.app')

@section('title', 'Pixxi Properties')

@section('styles')
    <style>
        .property-card {
            transition: transform 0.2s;
            border: 1px solid #e9ecef;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .property-images .carousel-control-prev,
        .property-images .carousel-control-next {
            width: 35px;
            height: 35px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            opacity: 0.8;
        }

        .property-images .carousel-control-prev:hover,
        .property-images .carousel-control-next:hover {
            opacity: 1;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .property-images .carousel-control-prev {
            left: 10px;
        }

        .property-images .carousel-control-next {
            right: 10px;
        }

        .badge {
            font-size: 0.75em;
            padding: 0.375em 0.75em;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.3;
            min-height: 2.6rem;
        }

        .page-header-breadcrumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            border-radius: 10px;
            color: white;
            margin-bottom: 2rem;
        }

        .page-header-breadcrumb .page-title {
            color: white;
            margin-bottom: 0.5rem;
        }

        .page-header-breadcrumb .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .page-header-breadcrumb .breadcrumb-item.active {
            color: white;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            color: #495057;
            font-weight: 500;
        }

        .pagination .page-item.active .page-link {
            background-color: #667eea;
            border-color: #667eea;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #495057;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <h1 class="page-title fw-semibold fs-18 mb-0">Pixxi Properties</h1>
                    <div>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pixxi Properties</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="ms-md-1 ms-0">
                    <!-- Filter Controls -->
                    <form method="GET" class="d-flex gap-2 align-items-center">
                        <select name="listingType" class="form-control" style="width: 150px;" onchange="this.form.submit()">
                            <option value="SELL" {{ $listingType == 'SELL' ? 'selected' : '' }}>For Sale</option>
                            <option value="RENT" {{ $listingType == 'RENT' ? 'selected' : '' }}>For Rent</option>
                        </select>
                        <select name="status" class="form-control" style="width: 150px;" onchange="this.form.submit()">
                            <option value="ACTIVE" {{ $status == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                            <option value="INACTIVE" {{ $status == 'INACTIVE' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <button type="button" class="btn btn-primary" onclick="location.reload()">
                            <i class="fe fe-refresh-cw"></i> Refresh
                        </button>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">
                                Properties List
                                @if (isset($properties['data']['totalSize']) && $properties['data']['totalSize'] > 0)
                                    <span class="badge bg-primary ms-2">{{ $properties['data']['totalSize'] }} Total</span>
                                @endif
                            </div>
                            @if ($properties['statusCode'] == 200)
                                <span class="text-success fw-semibold">
                                    <i class="fe fe-check-circle me-1"></i> Connected to Pixxi API
                                </span>
                            @else
                                <span class="text-danger fw-semibold">
                                    <i class="fe fe-x-circle me-1"></i> API Error
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if ($properties['statusCode'] == 200 && !empty($properties['data']['list']))
                                <div class="row">
                                    @foreach ($properties['data']['list'] as $property)
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                                            <div class="card custom-card property-card h-100">
                                                <div class="card-body p-0">
                                                    <!-- Property Images -->
                                                    <div class="property-images position-relative">
                                                        @if (!empty($property['photos']) && is_array($property['photos']))
                                                            <div id="carousel{{ $property['id'] }}" class="carousel slide"
                                                                data-bs-ride="carousel">
                                                                <div class="carousel-inner">
                                                                    @foreach (array_slice($property['photos'], 0, 5) as $index => $photo)
                                                                        <div
                                                                            class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                                            <img src="{{ $photo }}"
                                                                                class="d-block w-100" alt="Property Image"
                                                                                style="height: 200px; object-fit: cover;">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                @if (count($property['photos']) > 1)
                                                                    <button class="carousel-control-prev" type="button"
                                                                        data-bs-target="#carousel{{ $property['id'] }}"
                                                                        data-bs-slide="prev">
                                                                        <span class="carousel-control-prev-icon"
                                                                            aria-hidden="true"></span>
                                                                    </button>
                                                                    <button class="carousel-control-next" type="button"
                                                                        data-bs-target="#carousel{{ $property['id'] }}"
                                                                        data-bs-slide="next">
                                                                        <span class="carousel-control-next-icon"
                                                                            aria-hidden="true"></span>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-center bg-light"
                                                                style="height: 200px;">
                                                                <i class="fe fe-image text-muted"
                                                                    style="font-size: 48px;"></i>
                                                            </div>
                                                        @endif

                                                        <!-- Property Badges -->
                                                        <div class="position-absolute top-0 start-0 m-2">
                                                            <span
                                                                class="badge bg-primary">{{ $property['listingType'] }}</span>
                                                            <span class="badge bg-success">{{ $property['status'] }}</span>
                                                        </div>

                                                        <!-- Property Type & Bedrooms -->
                                                        <div class="position-absolute top-0 end-0 m-2">
                                                            @if (isset($property['propertyType'][0]))
                                                                <span
                                                                    class="badge bg-secondary">{{ $property['propertyType'][0] }}</span>
                                                            @endif
                                                            @if (isset($property['bedRooms']))
                                                                <span class="badge bg-info">{{ $property['bedRooms'] }}
                                                                    BR</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Property Details -->
                                                    <div class="p-3">
                                                        <h5 class="card-title text-truncate">
                                                            {{ $property['title'] ?? 'Property Title' }}</h5>

                                                        <!-- Price -->
                                                        <div class="mb-2">
                                                            <h4 class="text-primary mb-0">
                                                                AED {{ number_format($property['price'] ?? 0) }}
                                                            </h4>
                                                        </div>

                                                        <!-- Location -->
                                                        <div class="mb-2">
                                                            <small class="text-muted">
                                                                <i class="fe fe-map-pin"></i>
                                                                {{ $property['region'] ?? 'Location not specified' }},
                                                                {{ $property['cityName'] ?? 'Dubai' }}
                                                            </small>
                                                        </div>

                                                        <!-- Community -->
                                                        @if (isset($property['community']))
                                                            <div class="mb-2">
                                                                <small class="text-muted">
                                                                    <i class="fe fe-home"></i> {{ $property['community'] }}
                                                                </small>
                                                            </div>
                                                        @endif

                                                        <!-- Size -->
                                                        @if (isset($property['size']))
                                                            <div class="mb-2">
                                                                <small class="text-muted">
                                                                    <i class="fe fe-maximize"></i>
                                                                    {{ number_format($property['size']) }} SqFt
                                                                </small>
                                                            </div>
                                                        @endif

                                                        <!-- Agent Info -->
                                                        @if (isset($property['agent']))
                                                            <div class="d-flex align-items-center mt-3 pt-3 border-top">
                                                                <img src="{{ $property['agent']['avatar'] ?? asset('nophoto.jpeg') }}"
                                                                    alt="Agent" class="rounded-circle me-2"
                                                                    style="width: 30px; height: 30px;">
                                                                <div>
                                                                    <small
                                                                        class="fw-bold">{{ $property['agent']['name'] ?? 'Agent' }}</small><br>
                                                                    <small
                                                                        class="text-muted">{{ $property['agent']['phone'] ?? '' }}</small>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Action Buttons -->
                                                        <div class="mt-3 d-flex gap-2">
                                                            <a href="{{ route('pixxi.properties.show', $property['propertyId']) }}" 
   class="btn btn-sm btn-primary flex-fill">
    <i class="fe fe-eye"></i> View Details
</a>

                                                            @if (isset($property['permitQRCode']))
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    onclick="showQRCode('{{ $property['permitQRCode'] }}')">
                                                                    <i class="fe fe-credit-card"></i> Permit
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination Info & Controls -->
                                @if (isset($properties['data']['totalSize']) && $properties['data']['totalSize'] > 0)
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div>
                                            <small class="text-muted">
                                                Showing {{ count($properties['data']['list']) }} of
                                                {{ $properties['data']['totalSize'] }} properties
                                                (Page {{ $currentPage ?? 1 }})
                                            </small>
                                        </div>

                                        <!-- Pagination Controls -->
                                        @php
                                            $itemsPerPage = count($properties['data']['list']);
                                            $totalPages =
                                                $itemsPerPage > 0
                                                    ? ceil($properties['data']['totalSize'] / $itemsPerPage)
                                                    : 1;
                                            $currentPageNum = $currentPage ?? 1;
                                        @endphp

                                        @if ($totalPages > 1)
                                            <nav aria-label="Properties pagination">
                                                <ul class="pagination pagination-sm mb-0">
                                                    <!-- Previous Page -->
                                                    @if ($currentPageNum > 1)
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ request()->fullUrlWithQuery(['page' => $currentPageNum - 1]) }}">
                                                                <i class="fe fe-chevron-left"></i> Previous
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link">
                                                                <i class="fe fe-chevron-left"></i> Previous
                                                            </span>
                                                        </li>
                                                    @endif

                                                    <!-- Page Numbers -->
                                                    @php
                                                        $start = max(1, $currentPageNum - 2);
                                                        $end = min($totalPages, $currentPageNum + 2);
                                                    @endphp

                                                    @if ($start > 1)
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
                                                        </li>
                                                        @if ($start > 2)
                                                            <li class="page-item disabled">
                                                                <span class="page-link">...</span>
                                                            </li>
                                                        @endif
                                                    @endif

                                                    @for ($i = $start; $i <= $end; $i++)
                                                        <li class="page-item {{ $i == $currentPageNum ? 'active' : '' }}">
                                                            <a class="page-link"
                                                                href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    @if ($end < $totalPages)
                                                        @if ($end < $totalPages - 1)
                                                            <li class="page-item disabled">
                                                                <span class="page-link">...</span>
                                                            </li>
                                                        @endif
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ request()->fullUrlWithQuery(['page' => $totalPages]) }}">{{ $totalPages }}</a>
                                                        </li>
                                                    @endif

                                                    <!-- Next Page -->
                                                    @if ($currentPageNum < $totalPages)
                                                        <li class="page-item">
                                                            <a class="page-link"
                                                                href="{{ request()->fullUrlWithQuery(['page' => $currentPageNum + 1]) }}">
                                                                Next <i class="fe fe-chevron-right"></i>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link">
                                                                Next <i class="fe fe-chevron-right"></i>
                                                            </span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <i class="fe fe-home fa-3x text-muted mb-3"></i>
                                    <h4 class="mt-3">
                                        {{ $properties['statusCode'] == 200 ? 'No Properties Found' : 'Connection Error' }}
                                    </h4>
                                    <p class="text-muted">
                                        {{ $properties['message'] ?? 'No properties available with current filters.' }}</p>
                                    <button onclick="location.reload()" class="btn btn-primary">
                                        <i class="fe fe-refresh-cw"></i> Try Again
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Modal -->
            <div class="modal fade" id="qrModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Property Permit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center" id="qrContent">
                            <!-- QR Code will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function viewProperty(propertyId, propertyRefId) {
            // يمكنك إضافة المزيد من التفاصيل هنا لاحقاً
            alert('Property ID: ' + propertyId + '\nProperty Ref: ' + propertyRefId);
        }

        function showQRCode(qrUrl) {
            document.getElementById('qrContent').innerHTML = '<img src="' + qrUrl + '" class="img-fluid" alt="QR Code">';
            var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
            qrModal.show();
        }
    </script>
@endsection
