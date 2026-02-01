@extends('layouts.website', [
    'title' => 'Home Page',
    'headerType' => '_header',
    'bg' => 'bg-white',
])

@section('content')
    <!--============== Slider Area Start ==============-->
    @include('website.partials._slider')
    <!--============== Slider Area End ==============-->

    <!--============== Property Search Form Start ==============-->
    @include('website.partials._property_search')
    <!--============== Property Search Form End ==============-->

    <!--============== Filtered Properties Results Start ==============-->
    <div id="propertyResultsContainer">
    @if((isset($currentListingType) && ($currentListingType == 'buy' || $currentListingType == 'rent' || $currentListingType == 'off-plan')) || request('listingType'))
    <div class="full-row py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="text-secondary fw-bold" style="font-size: 2.5rem;">
                        @if($currentListingType == 'buy')
                            Properties for Sale
                        @elseif($currentListingType == 'rent')
                            Properties for Rent
                        @elseif($currentListingType == 'off-plan')
                            Off Plan Properties
                        @endif
                    </h2>
                    <p class="text-muted">Found {{ $filteredProjects->total() }} properties</p>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4" style="display: flex; flex-wrap: wrap;">
                @if($filteredProjects->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            No properties found. Please adjust your search criteria and try again.
                        </div>
                    </div>
                @else
                    @foreach($filteredProjects as $project)
                        <div class="col">
                            <div class="property-grid-1 bg-white property-block border transition hover-shadow" style="display: flex; flex-direction: column; height: 100%; border-radius: 8px; overflow: hidden;">
                                <!-- Property Image (fixed height like Recent Properties) -->
                                <div class="overflow-hidden position-relative thumbnail-img bg-secondary hover-img-zoom" style="height: 300px;">
                                    @if($project->featured)
                                        <span class="cata position-absolute sale bg-primary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Hot Sale</span>
                                    @endif
                                    <a href="{{ route('projects.show', $project->id) }}">
                                        <img src="{{ $project->mainImage->media_link ?? asset('nophoto.jpeg') }}" alt="{{ $project->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                    <span class="price-on text-white font-medium font-500" style="position: absolute; bottom: 10px; right: 10px; background-color: #001f3f; color: #fff; padding: 5px 10px; border-radius: 5px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                                        AED {{ number_format($project->price) }}
                                    </span>
                                </div>
                                <div class="property_text p-4" style="flex: 1; display: flex; flex-direction: column;">
                                    <h5 class="mb-2">
                                        <a href="{{ route('projects.show', $project->id) }}" class="text-secondary hover-text-primary">
                                            {{ $project->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-2">
                                        <i class="flaticon-placeholder me-1"></i>{{ $project->location_name }}
                                    </p>
                                    @if($project->utility)
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            @if($project->utility->bedrooms)
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-bed me-1"></i>{{ $project->utility->bedrooms }} Beds
                                                </span>
                                            @endif
                                            @if($project->utility->bathrooms)
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-bath me-1"></i>{{ $project->utility->bathrooms }} Baths
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Pagination with Numeric Links -->
            @if($filteredProjects->hasPages())
                <div class="row mt-5">
                    <div class="col">
                        <div class="d-flex flex-column align-items-center">
                            <!-- Results Info -->
                            <div class="mb-3 text-muted">
                                <span>Showing {{ $filteredProjects->firstItem() }} to {{ $filteredProjects->lastItem() }} of {{ $filteredProjects->total() }} properties</span>
                            </div>
                            
                            <!-- Pagination Navigation -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-lg justify-content-center mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($filteredProjects->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" aria-label="Previous">
                                                <i class="fa-solid fa-chevron-left"></i> Previous
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $filteredProjects->previousPageUrl() }}" rel="prev" aria-label="Previous">
                                                <i class="fa-solid fa-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Links --}}
                                    @php
                                        $currentPage = $filteredProjects->currentPage();
                                        $lastPage = $filteredProjects->lastPage();
                                        $start = max(1, $currentPage - 2);
                                        $end = min($lastPage, $currentPage + 2);
                                    @endphp

                                    {{-- First Page --}}
                                    @if ($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $filteredProjects->url(1) }}">1</a>
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
                                                <a class="page-link" href="{{ $filteredProjects->url($page) }}">{{ $page }}</a>
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
                                            <a class="page-link" href="{{ $filteredProjects->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    {{-- Next Page Link --}}
                                    @if ($filteredProjects->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $filteredProjects->nextPageUrl() }}" rel="next" aria-label="Next">
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
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
    </div>
    <!--============== Filtered Properties Results End ==============-->

    @if(!request('listingType') || (request('listingType') != 'buy' && request('listingType') != 'rent' && request('listingType') != 'off-plan'))
    <!-- =============== About ================-->
    @if($mainServicesSection && $mainServicesSection->is_active)
    <div class="full-row" style="padding: 70px 0 30px 0">
        <div class="container">
            <div class="row align-items-start">
                @if($mainServicesSection->title)
                <div class="col-lg-4">
                    <h1 class="mb-0 text-secondary fw-bold" style="line-height: 50px; font-size: 2.5rem;">{!! nl2br(e($mainServicesSection->title)) !!}</h1>
                    @if($mainServicesSection->subtitle)
                    <h6 class="mb-0 text-secondary" style="line-height: 50px; font-weight: 400;">{!! nl2br(e($mainServicesSection->subtitle)) !!}</h6>
                    @endif
                </div>
                @endif
                @if($mainServicesSection->content)
                <div class="col-lg-4">
                    <div style="padding-top: 0;">
                        <p class="mb-0" style="text-align: left;">
                            {!! $mainServicesSection->content !!}
                        </p>
                    </div>
                </div>
                @endif
                @if($mainServicesSection->list_items && count($mainServicesSection->list_items) > 0)
                <div class="col-lg-3 offset-lg-1">
                    <ul class="list-style-tick d-flex flex-column mb-0" style="padding-left: 0; margin-top: 0;">
                        @foreach($mainServicesSection->list_items as $item)
                            <li style="text-align: left;">{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    <!-- =============== About ================-->

    <div class="full-row p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- =============== Counting ================-->
    @if($countingSection && $countingSection->is_active && $countingSection->stats_items && count($countingSection->stats_items) > 0)
    <div class="full-row">
        <div class="container">
            <div class="row row-cols-lg-3 row-cols-1">
                @foreach($countingSection->stats_items as $stat)
                <div class="col">
                    <div class="d-flex flex-row align-items-center text-uppercase">
                        <h1 class="text-primary mb-0 pe-4">{{ $stat['value'] ?? '' }}</h1>
                        <p class="mb-0">{!! nl2br(e($stat['description'] ?? '')) !!}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- =============== Counting ================-->
    @endif

    <!--============== Off Plan Projects Start ==============-->
    @if((isset($currentListingType) && ($currentListingType == 'buy' || $currentListingType == 'off-plan')) || (request('listingType') && request('listingType') != 'rent'))
    @include('website.partials._recent_properties', ['popularProjects' => $popularProjects])
    @endif
    <!--============== Off Plan Projects End ==============-->

    @if(!request('listingType') || (request('listingType') != 'buy' && request('listingType') != 'rent' && request('listingType') != 'off-plan'))
    <!--============== Recent Property Start ==============-->
    @include('website.partials._recent_properties', ['popularProjects' => $popularProjects])
    <!--============== Recent Property End ==============-->

    <!--============== Testimonial Section Start ==============-->
    @if($testimonialsSection && $testimonialsSection->is_active && $testimonialsSection->testimonials && count($testimonialsSection->testimonials) > 0)
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    @if($testimonialsSection->subtitle)
                    <span class="text-primary tagline pb-2 d-table m-auto">{{ $testimonialsSection->subtitle }}</span>
                    @endif
                    @if($testimonialsSection->title)
                    <h1 class="down-line w-50 mx-auto mb-4 text-center w-sm-100 fw-bold" style="font-size: 2.5rem;">{{ $testimonialsSection->title }}</h1>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="testimonial-simple text-center px-5">
                        <div class="text-carusel owl-carousel">
                            @foreach($testimonialsSection->testimonials as $testimonial)
                            <div class="item">
                                <i class="flaticon-right-quote flat-large text-primary d-table mx-auto"></i>
                                <blockquote class="text-secondary fs-5 fst-italic">" {{ $testimonial['quote'] ?? '' }} "</blockquote>
                                @if($testimonial['author'] ?? '')
                                <h4 class="mt-4 font-400">{{ $testimonial['author'] }}</h4>
                                @endif
                                @if($testimonial['position'] ?? '')
                                <span class="text-primary font-fifteen">{{ $testimonial['position'] }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Testimonial Section End ==============-->

    <!--============== Popular Properties Start ==============-->
    @include('website.partials._popular_properties', ['recentProjects' => $recentProjects])
    <!--============== Popular Properties End ==============-->

    <!--============== Blog Section Start ==============-->
    @include('website.partials._blogs')
    <!--============== Blog Section End ==============-->

    <!--============== FAQ Section Start ==============-->
    @if(!request('listingType') && !request('category') && !request('keyword'))
        @include('website.partials._faq')
    @endif
    <!--============== FAQ Section End ==============-->
    @endif
@endsection



<!-- Script to toggle Price and Advanced Options dropdowns -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // State management for price dropdown
        let isPriceOpen = false;
        const priceButton = document.getElementById('price-toggle-btn');
        const priceDropdown = document.getElementById('data-range-price');
        
        // Handle Price dropdown specifically with reliable state management
        if (priceButton && priceDropdown) {
            priceButton.addEventListener("click", function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                // Close all other dropdowns first
                document.querySelectorAll(".price-range-toggle").forEach(function(dropdown) {
                    if (dropdown !== priceDropdown) {
                        dropdown.classList.add('d-none');
                        dropdown.style.display = 'none';
                    }
                });
                
                // Toggle price dropdown with state management
                if (!isPriceOpen) {
                    // Open dropdown
                    priceDropdown.classList.remove('d-none');
                    priceDropdown.style.display = 'block';
                    isPriceOpen = true;
                } else {
                    // Close dropdown
                    priceDropdown.classList.add('d-none');
                    priceDropdown.style.display = 'none';
                    isPriceOpen = false;
                }
            });
        }
        
        // Handle all other toggle buttons
        document.querySelectorAll(".toggle-btn").forEach(function(button) {
            if (button.id !== 'price-toggle-btn') {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const targetSelector = button.getAttribute("data-target");
                    if (targetSelector) {
                        const target = document.querySelector(targetSelector);
                        if (target) {
                            // Close price dropdown if opening another
                            if (priceDropdown && isPriceOpen) {
                                priceDropdown.classList.add('d-none');
                                priceDropdown.style.display = 'none';
                                isPriceOpen = false;
                            }
                            
                            // Close all other dropdowns first
                            document.querySelectorAll(".price-range-toggle").forEach(function(dropdown) {
                                if (dropdown !== target) {
                                    dropdown.classList.add('d-none');
                                    dropdown.style.display = 'none';
                                }
                            });
                            
                            // Toggle visibility
                            if (target.classList.contains('d-none') || target.style.display === 'none') {
                                target.classList.remove('d-none');
                                target.style.display = 'block';
                            } else {
                                target.classList.add('d-none');
                                target.style.display = 'none';
                            }
                        }
                    }
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Handle price dropdown
            if (priceButton && priceDropdown && isPriceOpen) {
                if (!priceButton.contains(e.target) && !priceDropdown.contains(e.target)) {
                    priceDropdown.classList.add('d-none');
                    priceDropdown.style.display = 'none';
                    isPriceOpen = false;
                }
            }
            
            // Handle other dropdowns
            document.querySelectorAll(".toggle-btn").forEach(function(button) {
                if (button.id !== 'price-toggle-btn') {
                    const targetSelector = button.getAttribute("data-target");
                    if (targetSelector) {
                        const target = document.querySelector(targetSelector);
                        if (target && !target.classList.contains('d-none')) {
                            if (!button.contains(e.target) && !target.contains(e.target)) {
                                target.classList.add('d-none');
                                target.style.display = 'none';
                            }
                        }
                    }
                }
            });
        });
    });


    function updatePriceInputs(value) {
        const [min, max] = value.split(';');
        document.getElementById('min_price').value = min;
        document.getElementById('max_price').value = max;
    }
</script>
