@extends('layouts.website', [
    'title' => 'Featured Projects - Browse Our Top Picks',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <div class="full-row py-5 pb-0">
        <div class="container">
            <!-- Breadcrumbs and Title -->
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Featured Projects</li>
                        </ol>
                    </nav>
                    <h1 class="text-secondary fw-bold" style="font-size: 2.5rem;">Featured Projects</h1>
                </div>
            </div>
        </div>
    </div>

    @include('website.partials._featured_filtering')

    <div class="full-row pt-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @if($featuredProjects->isEmpty())
                    <div class="col-12 d-flex justify-content-center">
                        <div class="alert alert-info text-center" role="alert" style="max-width: 600px; margin-top: 40px;">
                            No projects found. Please adjust your search criteria and try again.
                        </div>
                    </div>
                @else
                <!-- Properties Grid -->
                @foreach($featuredProjects as $project)
                    <div class="col mt-4">
                        <div class="property-grid-1 bg-white property-block border transition hover-shadow">
                            <div class="overflow-hidden position-relative thumbnail-img bg-secondary hover-img-zoom m-2" style="height: 200px;">
                                <!-- Featured Tag -->
                                <span class="cata position-absolute sale bg-primary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Featured</span>
                                <!-- Property Image -->
                                <a href="{{ route('projects.show', $project->id) }}">
                                    <img src="{{ asset('files/projects/main_images/' . ($project->mainImage->media ?? 'default.jpg')) }}" alt="Image Not Found!" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                <!-- Price Tag -->
                                <span class="price-on text-white font-medium font-500" style="position: absolute; bottom: 10px; right: 10px; background-color: #001f3f; color: #fff; padding: 5px 10px; border-radius: 5px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                    AED {{ number_format($project->price) }}
                                </span>
                            </div>
                            <div class="property_text p-3">
                                <span class="d-inline-block text-primary">{{ $project->category->name }}</span>
                                <h5 class="mt-2"><a class="font-400 text-secondary" href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a></h5>
                                <!-- Location -->
                                <span class="my-3 d-block">
                                         <a href="{{ $project->location_link }}" target="_blank" style="display: flex; align-items: center; color: inherit;">
                                         <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #b89d68;"></i>
                                         {{ $project->location_name }}
                                          </a>
                                </span>
                                <!-- Quick Facts -->
                                <ul class="d-flex font-fifteen" style="gap: 15px; list-style: none; padding: 0;">
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-bed" style="margin-right: 5px;"></i> {{ $project->utility->bedrooms }}
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-shower" style="margin-right: 5px;"></i> {{ $project->utility->bathrooms }}
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-vector-square" style="margin-right: 5px;"></i> {{ number_format($project->floor_area) }} Sqft
                                    </li>
                                </ul>
                            </div>
                            <!-- More Info Link -->
                            <div class="d-flex align-items-center post-meta mt-2 p-3 border-top">
                                <a href="{{ route('projects.show', $project->id) }}" class="me-auto"><span>View Details </span><i class="fa-solid fa-arrow-right"></i></a>
                                <div class="post-date ms-auto"><span>{{ $project->created_at->format('M d, Y') }}</span></div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
            <!-- Pagination with Numeric Links -->
            <div class="row">
                <div class="col mt-5">
                    @if ($featuredProjects->hasPages())
                        <div class="d-flex flex-column align-items-center">
                            <!-- Results Info -->
                            <div class="mb-3 text-muted">
                                <span>Showing {{ $featuredProjects->firstItem() }} to {{ $featuredProjects->lastItem() }} of {{ $featuredProjects->total() }} properties</span>
                            </div>
                            
                            <!-- Pagination Navigation -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-lg justify-content-center mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($featuredProjects->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-label="Previous">
                                                <i class="fa-solid fa-chevron-left"></i> Previous
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $featuredProjects->previousPageUrl() }}" rel="prev" aria-label="Previous">
                                                <i class="fa-solid fa-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Links --}}
                                    @php
                                        $currentPage = $featuredProjects->currentPage();
                                        $lastPage = $featuredProjects->lastPage();
                                        $start = max(1, $currentPage - 2);
                                        $end = min($lastPage, $currentPage + 2);
                                    @endphp

                                    {{-- First Page --}}
                                    @if ($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $featuredProjects->url(1) }}">1</a>
                                        </li>
                                        @if ($start > 2)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- Page Numbers --}}
                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $currentPage)
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $featuredProjects->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    {{-- Last Page --}}
                                    @if ($end < $lastPage)
                                        @if ($end < $lastPage - 1)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $featuredProjects->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($featuredProjects->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $featuredProjects->nextPageUrl() }}" rel="next" aria-label="Next">
                                                Next <i class="fa-solid fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-label="Next">
                                                Next <i class="fa-solid fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @else
                        <div class="text-center text-muted mt-3">
                            <p>Showing all {{ $featuredProjects->total() }} properties</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
