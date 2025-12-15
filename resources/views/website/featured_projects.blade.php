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
                            <li class="breadcrumb-item active text-primary" aria-current="page">Off Plan Projects</li>
                        </ol>
                    </nav>
                    @if($headerSection)
                        <h1 class="text-secondary fw-bold" style="font-size: 2.5rem;">{{ $headerSection->title ?? ($featuredProjects->total() . ' Off-Plan Projects in Dubai') }}</h1>
                        @if($headerSection->subtitle)
                            <p class="text-muted mt-3">{{ $headerSection->subtitle }}</p>
                        @endif
                    @else
                        <h1 class="text-secondary fw-bold" style="font-size: 2.5rem;">{{ $featuredProjects->total() }} Off-Plan Projects in Dubai</h1>
                        <p class="text-muted mt-3">Explore upcoming developments and secure your investment early.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('website.partials._off_plan_filtering')

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
                        <div class="bg-white property-block border transition hover-shadow" style="border-radius: 8px; overflow: hidden; {{ $project->is_featured ? 'border: 2px solid #ff6b35;' : '' }}">
                            <!-- Property Image -->
                            <div class="overflow-hidden position-relative" style="height: 300px;">
                                <a href="{{ route('off-plan-project.show', $project->id) }}">
                                    <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}" alt="{{ $project->project_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                @if($project->starting_price)
                                <span class="price-on text-white font-medium font-500" style="position: absolute; bottom: 10px; right: 10px; background-color: #001f3f; color: #fff; padding: 5px 10px; border-radius: 5px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                    AED {{ number_format($project->starting_price) }}
                                </span>
                                @endif
                            </div>
                            
                            <!-- Property Details -->
                            <div class="p-4">
                                <!-- Title -->
                                <h4 class="mb-3" style="font-size: 1.5rem; font-weight: 600; color: #333;">
                                    <a href="{{ route('off-plan-project.show', $project->id) }}" style="color: #333; text-decoration: none;">{{ $project->project_name }}</a>
                                </h4>
                                
                                <!-- Price -->
                                @if($project->starting_price)
                                <p class="mb-3" style="font-size: 1.2rem; font-weight: 600; color: #001f3f;">
                                    Prices from: AED {{ number_format($project->starting_price) }}
                                </p>
                                @endif
                                
                                <!-- Location -->
                                @if($project->location)
                                <p class="mb-2" style="color: #666; font-size: 0.95rem;">
                                    <strong>Location:</strong> {{ $project->location }}
                                </p>
                                @endif
                                
                                <!-- Developer -->
                                @if($project->developer)
                                <p class="mb-2" style="color: #666; font-size: 0.95rem;">
                                    <strong>Developer:</strong> {{ $project->developer }}
                                </p>
                                @endif
                                
                                <!-- Development Type -->
                                @if($project->development_type)
                                <p class="mb-3" style="color: #666; font-size: 0.95rem;">
                                    <strong>Development Type:</strong> {{ $project->development_type }}
                                </p>
                                @endif
                                
                                <!-- Description -->
                                @if($project->description || $project->overview)
                                <p class="mb-4" style="color: #666; font-size: 0.9rem; line-height: 1.6;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($project->description ?? $project->overview ?? ''), 120) }}
                                </p>
                                @endif
                                
                                <!-- View Property Details Button -->
                                <a href="{{ route('off-plan-project.show', $project->id) }}" class="btn w-100" style="background-color: #001f3f; color: white; padding: 12px; border-radius: 5px; text-decoration: none; display: block; text-align: center; font-weight: 500; transition: all 0.3s;">
                                    View Property Details
                                </a>
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
