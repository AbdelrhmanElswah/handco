@extends('layouts.website', [
    'title' => 'Living in ' . $community->title,
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Breadcrumb Start ==============-->
    <div class="full-row py-3 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('communities') }}">Area Guide</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $community->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--============== Breadcrumb End ==============-->

    <!--============== Hero Section Start ==============-->
    <div class="full-row bg-secondary py-5" style="background: linear-gradient(135deg, #001f3f 0%, #003366 100%); min-height: 500px; position: relative; overflow: hidden;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="text-white fw-bold mb-4" style="font-size: 3rem; line-height: 1.2;">Living in {{ $community->title }}</h1>
                    @if($community->subtitle)
                        <p class="text-white mb-4" style="font-size: 1.2rem; line-height: 1.8; opacity: 0.9;">{{ $community->subtitle }}</p>
                    @else
                        <p class="text-white mb-4" style="font-size: 1.2rem; line-height: 1.8; opacity: 0.9;">Discover the perfect lifestyle in {{ $community->title }}, one of Dubai's most iconic neighbourhoods.</p>
                    @endif
                    <div class="d-flex gap-3 mb-4">
                        <a href="#featured-properties" class="btn btn-lg px-4 py-3" style="background-color: #0E3D7D; color: white; font-weight: 600; border: none; border-radius: 8px; text-decoration: none; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);">Find a Property</a>
                        <a href="{{ route('contact') }}" class="btn btn-lg px-4 py-3" style="background-color: #0E3D7D; color: white; font-weight: 600; border: none; border-radius: 8px; text-decoration: none; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);">Contact Us</a>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <i class="fas fa-phone me-2"></i>
                        <span>Need to speak with one of our advisors? Call <a href="tel:+971527785359" class="text-white" style="text-decoration: underline;">+971 52 778 5359</a></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrapper" style="position: relative; height: 400px; border-radius: 15px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                        <img src="{{ $community->mainImage->media_link ?? asset('assets/images/default.png') }}" 
                             alt="{{ $community->title }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Hero Section End ==============-->

    <!--============== Community Content Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="community-content" style="font-size: 1.1rem; line-height: 1.8; color: #333;">
                        {!! $community->content !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-box-model bg-white p-4 rounded shadow-sm">
                        <h5 class="mb-4" style="color: #001f3f; font-weight: bold;">Need to sell a property in {{ $community->title }}?</h5>
                        <p class="mb-4" style="color: #666; font-size: 1rem; line-height: 1.6;">Speak to one of our advisor's today.</p>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('contact') }}" class="btn w-100 community-primary-btn" style="background-color: #0E3D7D; color: #FFFFFF; border: none; border-radius: 8px; font-weight: 600;">Contact Us</a>
                            <a href="{{ route('sell') }}" class="btn w-100" style="background-color: #0E3D7D; color: #FFFFFF; border: none; border-radius: 8px; font-weight: 600;">Meet our team</a>
                        </div>
                        <hr class="my-4">
                        <div class="contact-info">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-phone me-3" style="color: #001f3f;"></i>
                                <a href="tel:+971527785359" style="color: #001f3f; text-decoration: none;">+971 52 778 5359</a>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-envelope me-3" style="color: #001f3f;"></i>
                                <a href="mailto:info@handcoproperties.com" style="color: #001f3f; text-decoration: none;">Email</a>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fab fa-whatsapp me-3" style="color: #25D366;"></i>
                                <a href="https://wa.me/971527785359" style="color: #001f3f; text-decoration: none;">WhatsApp</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Community Content End ==============-->

    <!--============== Location Map Section Start ==============-->
    @if($community->location_link)
    <div class="full-row py-0">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12">
                    <div class="location-map-wrapper" style="width: 100%; height: 500px; position: relative; overflow: hidden;">
                        <iframe 
                            src="{{ $community->location_link }}" 
                            width="100%" 
                            height="500" 
                            style="border:0; display: block;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Location Map Section End ==============-->
    
    <!--============== Featured Properties Block Start ==============-->
    <div id="featured-properties" class="full-row bg-light py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="fw-bold text-center mb-3" style="font-size: 2.5rem; color: #001f3f;">Featured Properties in {{ $community->title }}</h1>
                </div>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="row mb-4">
                <div class="col">
                    <ul class="nav nav-tabs justify-content-center border-0" role="tablist" style="border-bottom: 2px solid #e0e0e0;">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $listingType === 'for_sale' ? 'active' : '' }}" 
                               href="{{ route('communities.show', ['id' => $community->id, 'type' => 'for_sale']) }}"
                               style="border: none; 
                                      border-bottom: 3px solid {{ $listingType === 'for_sale' ? '#001f3f' : 'transparent' }}; 
                                      color: {{ $listingType === 'for_sale' ? '#001f3f' : '#999' }}; 
                                      font-weight: {{ $listingType === 'for_sale' ? '600' : '400' }};
                                      padding: 15px 30px;
                                      background: transparent;">
                                For Sale
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $listingType === 'for_rent' ? 'active' : '' }}" 
                               href="{{ route('communities.show', ['id' => $community->id, 'type' => 'for_rent']) }}"
                               style="border: none; 
                                      border-bottom: 3px solid {{ $listingType === 'for_rent' ? '#001f3f' : 'transparent' }}; 
                                      color: {{ $listingType === 'for_rent' ? '#001f3f' : '#999' }}; 
                                      font-weight: {{ $listingType === 'for_rent' ? '600' : '400' }};
                                      padding: 15px 30px;
                                      background: transparent;">
                                For Rent
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $listingType === 'off_plan' ? 'active' : '' }}" 
                               href="{{ route('communities.show', ['id' => $community->id, 'type' => 'off_plan']) }}"
                               style="border: none; 
                                      border-bottom: 3px solid {{ $listingType === 'off_plan' ? '#001f3f' : 'transparent' }}; 
                                      color: {{ $listingType === 'off_plan' ? '#001f3f' : '#999' }}; 
                                      font-weight: {{ $listingType === 'off_plan' ? '600' : '400' }};
                                      padding: 15px 30px;
                                      background: transparent;">
                                Off Plan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Properties Grid -->
            @if($featuredProperties->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @foreach($featuredProperties as $project)
                        <div class="col">
                            <div class="property-grid-1 property-block bg-white transation-this shadow-sm" style="display: flex; flex-direction: column; height: 100%; width: 100%; border-radius: 8px; overflow: hidden; transition: transform 0.3s ease;">
                                <!-- Property Image -->
                                <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom" style="height: 250px;">
                                    <a href="{{ route('projects.show', $project->id) }}">
                                        <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}" 
                                             alt="Image Not Found!" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                    <!-- Price Badge -->
                                    <span class="price-on text-white font-medium font-500" 
                                          style="position: absolute; bottom: 10px; right: 10px; background-color: #001f3f; color: #fff; padding: 8px 15px; border-radius: 5px; font-weight: 600; font-size: 1.1rem;">
                                        AED {{ number_format($project->price) }}
                                    </span>
                                </div>
                                <div class="property_text p-4" style="flex: 1; display: flex; flex-direction: column;">
                                    <h5 class="listing-title mb-2" style="font-size: 1.1rem; font-weight: 600; color: #001f3f;">
                                        <a href="{{ route('projects.show', $project->id) }}" style="color: #001f3f; text-decoration: none;">{{ $project->title }}</a>
                                    </h5>

                                    <!-- Location -->
                                    <span class="listing-location mb-3" style="color: #666; font-size: 0.9rem; line-height: 1.6;">
                                        <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #001f3f;"></i>
                                        {{ $project->location_name }}
                                    </span>

                                    <ul class="d-flex quantity font-fifteen mb-0" style="flex-wrap: wrap; gap: 15px; list-style: none; padding: 0;">
                                        @if($project->utility && $project->utility->bedrooms)
                                            <li title="Beds" style="display: flex; align-items: center; gap: 5px; color: #666; font-size: 0.95rem;">
                                                <i class="fa-solid fa-bed" style="font-size: 16px; color: #001f3f;"></i>
                                                <span>{{ $project->utility->bedrooms }}</span>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->bathrooms)
                                            <li title="Baths" style="display: flex; align-items: center; gap: 5px; color: #666; font-size: 0.95rem;">
                                                <i class="fa-solid fa-bath" style="font-size: 16px; color: #001f3f;"></i>
                                                <span>{{ $project->utility->bathrooms }}</span>
                                            </li>
                                        @endif
                                        @if($project->floor_area)
                                            <li title="Area" style="display: flex; align-items: center; gap: 5px; color: #666; font-size: 0.95rem;">
                                                <i class="fa-solid fa-vector-square" style="font-size: 16px; color: #001f3f;"></i>
                                                <span>{{ number_format($project->floor_area) }} Sqft</span>
                                            </li>
                                        @endif
                                    </ul>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="tel:+971527785359" class="btn btn-sm flex-fill" style="background-color: #0E3D7D; color: #FFFFFF; border: none; border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-phone me-1"></i> Call
                                        </a>
                                        <a href="mailto:info@handcoproperties.com" class="btn btn-sm flex-fill" style="background-color: #0E3D7D; color: #FFFFFF; border: none; border-radius: 8px; font-weight: 600;">
                                            <i class="fas fa-envelope me-1"></i> Email
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <p style="color: #666; font-size: 1.1rem;">No properties found for this listing type in {{ $community->title }}.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!--============== Featured Properties Block End ==============-->

    <!--============== Other Areas/Communities Start ==============-->
    @if($otherCommunities->count() > 0)
    <div class="full-row py-5 bg-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h2 class="fw-bold text-center" style="font-size: 2.5rem; color: #001f3f;">Other Areas</h2>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($otherCommunities as $otherCommunity)
                    <div class="col">
                        <a href="{{ route('communities.show', $otherCommunity->id) }}" class="text-decoration-none d-block">
                            <div class="community-card position-relative" style="height: 250px; border-radius: 10px; overflow: hidden; transition: transform 0.3s ease; cursor: pointer;">
                                <img src="{{ $otherCommunity->mainImage->media_link ?? asset('assets/images/default.png') }}" 
                                     alt="{{ $otherCommunity->title }}" 
                                     style="width: 100%; height: 100%; object-fit: cover; cursor: pointer; pointer-events: none;">
                                <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); pointer-events: none;">
                                    <h5 class="text-white mb-0 fw-bold">{{ $otherCommunity->title }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!--============== Other Areas/Communities End ==============-->

    <style>
        /* Global Styles to match off_plan_project_show */
        body {
            font-family: 'Barlow', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #001f3f;
            font-weight: bold;
        }
        .community-content {
            color: #333;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .community-content p {
            margin-bottom: 1rem;
            color: #666;
        }
        .community-card {
            cursor: pointer;
        }
        .community-card:hover {
            transform: scale(1.05);
        }
        .community-card img {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .community-card:hover img {
            transform: scale(1.1);
        }
        .property-grid-1:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        .nav-link {
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #001f3f !important;
        }
        .community-primary-btn {
            background-color: #0E3D7D !important;
            color: #FFFFFF !important;
            border: none !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .community-primary-btn:hover {
            background-color: #0a2f5f !important;
            color: #FFFFFF !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 61, 125, 0.4);
        }
        .btn[style*="#0E3D7D"]:hover {
            background-color: #0a2f5f !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 61, 125, 0.4);
        }
    </style>
@endsection
