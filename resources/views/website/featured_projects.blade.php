@extends('layouts.website', [
    'title' => 'Featured Projects',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@php
    $projects = [
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Installment",
            "tag" => "Hot Sale",
            "image" => "property-grid-2.png",
            "price" => "420,000",
            "address" => "Dubai, 123 Al Fahidi Street",
            "address_link" => "https://maps.google.com",
            "category" => "Villa",
            "title" => "Luxury Villa With Pool",
            "date" => "Oct 21, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Full Payment",
            "tag" => "New Listing",
            "image" => "property-grid-1.png",
            "price" => "650,000",
            "address" => "Dubai, 456 Jumeirah Road",
            "address_link" => "https://maps.google.com",
            "category" => "Apartment",
            "title" => "Modern Beachfront Apartment",
            "date" => "Oct 22, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Installment",
            "tag" => "Featured",
            "image" => "property-grid-3.png",
            "price" => "750,000",
            "address" => "Dubai, 789 Business Bay",
            "address_link" => "https://maps.google.com",
            "category" => "Penthouse",
            "title" => "Penthouse with City View",
            "date" => "Oct 23, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Lease",
            "tag" => "Just Listed",
            "image" => "property-grid-4.png",
            "price" => "1,200,000",
            "address" => "Dubai, 101 Palm Jumeirah",
            "address_link" => "https://maps.google.com",
            "category" => "Mansion",
            "title" => "Exclusive Palm Mansion",
            "date" => "Oct 24, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Installment",
            "tag" => "Special Offer",
            "image" => "property-grid-6.png",
            "price" => "850,000",
            "address" => "Dubai, 202 Marina Walk",
            "address_link" => "https://maps.google.com",
            "category" => "Townhouse",
            "title" => "Marina Townhouse",
            "date" => "Oct 25, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Full Payment",
            "tag" => "Popular",
            "image" => "property-grid-8.png",
            "price" => "900,000",
            "address" => "Dubai, 303 Al Barsha",
            "address_link" => "https://maps.google.com",
            "category" => "Studio",
            "title" => "City Center Studio",
            "date" => "Oct 26, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Lease",
            "tag" => "Hot Deal",
            "image" => "property-grid-9.png",
            "price" => "500,000",
            "address" => "Dubai, 404 Downtown Dubai",
            "address_link" => "https://maps.google.com",
            "category" => "Duplex",
            "title" => "Spacious Downtown Duplex",
            "date" => "Oct 27, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Installment",
            "tag" => "Featured",
            "image" => "property-grid-3.png",
            "price" => "750,000",
            "address" => "Dubai, 789 Business Bay",
            "address_link" => "https://maps.google.com",
            "category" => "Penthouse",
            "title" => "Penthouse with City View",
            "date" => "Oct 23, 2024",
        ],
        [
            "slug" => "Dubai-123-Al-Fahidi-Street",
            "payment" => "Lease",
            "tag" => "Just Listed",
            "image" => "property-grid-4.png",
            "price" => "1,200,000",
            "address" => "Dubai, 101 Palm Jumeirah",
            "address_link" => "https://maps.google.com",
            "category" => "Mansion",
            "title" => "Exclusive Palm Mansion",
            "date" => "Oct 24, 2024",
        ],
    ];
@endphp

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5 pb-0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Projects</li>
                        </ol>
                    </nav>
                    <h3 class="text-secondary">Featured Projects</h3>
                </div>
            </div>
        </div>
    </div>
    <!--============== Page title End ==============-->

    <!--============== Property Grid View Start ==============-->
    <div class="full-row pt-0">
        <div class="container">
            <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1">
                @foreach($projects as $project)
                    <div class="col mt-20">
                    <!-- Property Grid -->
                    <div class="property-grid-1 bg-white property-block border transation-this hover-shadow">
                        <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom m-2">
                            <div class="cata position-absolute">
                                <span class="sale bg-secondary text-white">{{ $project['payment'] }}</span>
                                <span class="featured bg-primary text-white">{{ $project['tag'] }}</span>
                            </div>
                            <a href="{{ route('projects.show', $project['slug']) }}">
                                <img src="assets/images/property_grid/{{ $project['image'] }}" alt="Image Not Found!">
                            </a>
                            <span class="price-on text-white font-medium font-500">${{ $project['price'] }}</span>
                            <ul class="position-absolute quick-meta">
                                <li class="md-mx-none"><a class="quick-view" href="#quick-view" title="Quick View"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                            </ul>
                        </div>
                        <div class="property_text p-3">
                            <span class="d-inline-block text-primary">{{ $project['category'] }}</span>
                            <h5 class="mt-2"><a class="font-400 text-secondary" href="#">{{ $project['title'] }}</a></h5>
                            <span class="my-3 d-block">
                                <a href="{{ $project['address_link'] }}" target="_blank">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    {{ $project['address'] }}
                                </a>
                            </span>
                            <div class="quantity">
                                <ul class="d-flex quantity font-fifteen">
                                    <li title="Beds"><span><i class="fa-solid fa-bed"></i></span>7</li>
                                    <li title="Baths"><span><i class="fa-solid fa-shower"></i></span>5</li>
                                    <li title="Area"><span><i class="fa-solid fa-vector-square"></i></span>1200 Sqft</li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex align-items-center post-meta mt-2 p-3 border-top">
                            <div class="d-block">
                                <a href="#"><span style="margin-right: 4px">View Details</span> <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                            <div class="post-date ms-auto"><span>{{ $project['date'] }}</span></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col mt-5">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-dotted-active justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link">Previous Page</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next Page</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--============== Property Grid View End ==============-->
@endsection
