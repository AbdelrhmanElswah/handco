@extends('layouts.website', [
    'title' => $project->project_name . ' - Off Plan Project',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('off_plan_listing') }}">Off Plan Projects</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">{{ $project->project_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--============== Page title End ==============-->

    <!--============== Hero Image/Banner Start ==============-->
    @if($project->mainImage)
    <div class="full-row p-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 position-relative">
                    <img src="{{ $project->mainImage->media_link }}" alt="{{ $project->project_name }}" style="width: 100%; height: 500px; object-fit: cover;">
                    <!-- Overlay Content -->
                    <div class="position-absolute" style="top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10; color: white; text-align: center; width: 100%;">
                        <h1 class="text-white mb-3" style="font-size: 3rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                            {{ $project->project_name }}
                        </h1>
                        @if($project->starting_price)
                        <p class="text-white mb-4" style="font-size: 1.5rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                            Prices from: AED {{ number_format($project->starting_price) }}
                        </p>
                        @endif
                        <a href="#register-interest" class="btn btn-lg" style="background-color: #001f3f; color: white; padding: 15px 40px; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 5px; text-decoration: none; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);">
                            Register Your Interest
                        </a>
                    </div>
                    <!-- Dark Overlay for better text readability -->
                    <div class="position-absolute" style="top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.2)); z-index: 1;"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Hero Image/Banner End ==============-->

    <!--============== Navigation Tabs Start ==============-->
    <div class="full-row py-3 bg-white border-bottom sticky-top" style="top: 0; z-index: 100; background-color: white !important;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs border-0 justify-content-center" id="section-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#details-section" onclick="scrollToSection('details-section'); return false;" style="color: #001f3f;">Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gallery-section" onclick="scrollToSection('gallery-section'); return false;" style="color: #001f3f;">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#payment-plan-section" onclick="scrollToSection('payment-plan-section'); return false;" style="color: #001f3f;">Payment Plan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--============== Navigation Tabs End ==============-->

    <!--============== Content Sections Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <!-- Details Section -->
            <div id="details-section" class="section-content">
                    <div class="row">
                        <div class="col-12">
                            <!-- Project Overview -->
                            <div class="mb-5">
                                <h2 class="text-secondary fw-bold mb-4">{{ $project->project_name }}</h2>
                                @if($project->overview)
                                    <div class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                                        {{ strip_tags($project->overview) }}
                                    </div>
                                @endif
                                @if($project->description)
                                    <div class="text-muted mb-5" style="line-height: 1.8;">
                                        {{ strip_tags($project->description) }}
                                    </div>
                                @endif

                                <!-- Project Information -->
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($project->location)
                                            <div class="mb-3">
                                                <strong>Location:</strong> 
                                                @if($project->location_link)
                                                    {{ $project->location }}
                                                @endif
                                            </div>
                                            @endif

                                            @if($project->developer)
                                            <div class="mb-3">
                                                <strong>Developer:</strong> {{ $project->developer }}
                                            </div>
                                            @endif

                                            @if($project->development_type)
                                            <div class="mb-3">
                                                <strong>Development Type:</strong> {{ $project->development_type }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($project->completion_date)
                                            <div class="mb-3">
                                                <strong>Completion Date:</strong> {{ $project->completion_date }}
                                            </div>
                                            @endif

                                            @if($project->starting_price)
                                            <div class="mb-3">
                                                <strong>Prices from:</strong> AED {{ number_format($project->starting_price) }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Key Features & Amenities -->
                            @if($project->key_features && count($project->key_features) > 0)
                            <div class="mb-5">
                                <h3 class="text-secondary fw-bold mb-4">Key Features & Amenities</h3>
                                <div class="row">
                                    @foreach($project->key_features as $feature)
                                        <div class="col-md-4 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-check-circle text-primary me-2"></i>
                                                <span>{{ $feature }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Nearby Attractions -->
                            @if($project->nearby_attractions && count($project->nearby_attractions) > 0)
                            <div class="mb-5">
                                <h3 class="text-secondary fw-bold mb-4">Nearby Attractions</h3>
                                <ul class="list-unstyled">
                                    @foreach($project->nearby_attractions as $attraction)
                                        <li class="mb-2">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            <strong>{{ $attraction['time'] ?? '' }}</strong> - {{ $attraction['name'] ?? '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Gallery Section -->
                <div id="gallery-section" class="section-content mt-5 pt-5">
                    <h3 class="text-secondary fw-bold mb-4">Gallery</h3>
                    @if($project->galleryImages->count() > 0)
                        <div id="galleryCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner">
                                @foreach($project->galleryImages as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $image->media_link }}" alt="Gallery Image {{ $index + 1 }}" class="d-block w-100" style="height: 600px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if($project->galleryImages->count() > 1)
                                <button class="carousel-control-prev" type="button" data-target="#galleryCarousel" data-slide="prev" id="galleryPrevBtn">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-target="#galleryCarousel" data-slide="next" id="galleryNextBtn">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </button>
                                <!-- Carousel Indicators -->
                                <ol class="carousel-indicators">
                                    @foreach($project->galleryImages as $index => $image)
                                        <li data-target="#galleryCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                        
                        <!-- Thumbnail Gallery -->
                        @if($project->galleryImages->count() > 1)
                        <div class="mt-4">
                            <div class="row g-2" id="galleryThumbnails">
                                @foreach($project->galleryImages as $index => $image)
                                    <div class="col-3 col-md-2 col-lg-2">
                                        <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" data-slide-to="{{ $index }}" style="cursor: pointer; border: 3px solid transparent; border-radius: 8px; overflow: hidden; transition: all 0.3s ease;">
                                            <img src="{{ $image->media_link }}" alt="Thumbnail {{ $index + 1 }}" class="img-fluid w-100" style="height: 100px; object-fit: cover; border-radius: 5px;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @else
                        <p class="text-muted">No gallery images available.</p>
                    @endif
                </div>

                <!-- Payment Plan Section -->
                <div id="payment-plan-section" class="section-content mt-5 pt-5">
                    <h3 class="text-secondary fw-bold mb-4">Payment Plan</h3>
                    @if($project->payment_plan && count($project->payment_plan) > 0)
                        <div class="row">
                            @foreach($project->payment_plan as $plan)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $plan['title'] ?? 'Installment' }}</h5>
                                            @if(isset($plan['percentage']))
                                                <h2 class="text-primary fw-bold">{{ $plan['percentage'] }}</h2>
                                            @endif
                                            @if(isset($plan['description']))
                                                <p class="text-muted mb-0">{{ $plan['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Payment plan information not available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--============== Content Sections End ==============-->


    <!--============== Register Your Interest Section Start ==============-->
    <div id="register-interest" class="full-row py-5" style="background-color: #001f3f;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <h3 class="text-white fw-bold mb-4 text-center" style="font-size: 2.5rem;">Register your interest</h3>
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('booking.store') }}" method="POST" class="bg-transparent">
                        @csrf
                        <input type="hidden" name="off_plan_project_id" value="{{ $project->id }}">
                        <div class="mb-3">
                            <label class="text-white mb-2" style="font-weight: 500;">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Your Name *" value="{{ old('name') }}" required style="background-color: white; border: none; padding: 12px; border-radius: 4px;">
                        </div>
                        <div class="mb-3">
                            <label class="text-white mb-2" style="font-weight: 500;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Your Email Address*" value="{{ old('email') }}" required style="background-color: white; border: none; padding: 12px; border-radius: 4px;">
                        </div>
                        <div class="mb-3">
                            <label class="text-white mb-2" style="font-weight: 500;">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone_number" placeholder="Your Phone Number *" value="{{ old('phone_number') }}" required style="background-color: white; border: none; padding: 12px; border-radius: 4px;">
                        </div>
                        <div class="mb-4">
                            <label class="text-white mb-2" style="font-weight: 500;">Message</label>
                            <textarea class="form-control" name="message" rows="5" placeholder="Leave your message" style="background-color: white; border: none; padding: 12px; border-radius: 4px; resize: vertical;">{{ old('message') }}</textarea>
                        </div>
                        <div class="text-center mb-3">
                            <button class="btn btn-lg w-100" type="submit" style="background-color: #001f3f; color: white; padding: 15px; border: none; border-radius: 5px; font-weight: 600; font-size: 1.1rem;">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--============== Register Your Interest Section End ==============-->

    <!--============== Latest Off Plan Development Start ==============-->
    @if($latestProject)
    <div class="full-row py-5 bg-light">
        <div class="container">
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h2 class="text-secondary fw-bold mb-0" style="font-size: 2.5rem;">Latest Off Plan Development</h2>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('featured_projects') }}" class="btn" style="background-color: #001f3f; color: white; border: none; border-radius: 5px; padding: 10px 20px; font-weight: 500;">More Developments</a>
                </div>
            </div>
            
            <div class="row mb-5 bg-white border rounded shadow-sm" style="overflow: hidden;">
                <!-- Image Section (Left) -->
                <div class="col-lg-6 p-0">
                    <div class="position-relative" style="height: 100%; min-height: 400px;">
                        <a href="{{ route('off-plan-project.show', $latestProject->id) }}">
                            <img src="{{ $latestProject->mainImage->media_link ?? asset('images/default.jpg') }}" alt="{{ $latestProject->project_name }}" class="w-100 h-100" style="object-fit: cover;">
                        </a>
                    </div>
                </div>
                
                <!-- Details Section (Right) -->
                <div class="col-lg-6 p-4 d-flex flex-column justify-content-center">
                    <h3 class="text-secondary fw-bold mb-3" style="font-size: 2.5rem;">
                        <a href="{{ route('off-plan-project.show', $latestProject->id) }}" style="color: #001f3f; text-decoration: none;">{{ $latestProject->project_name }}</a>
                    </h3>
                    
                    @if($latestProject->starting_price)
                    <p class="mb-4" style="font-size: 1.5rem; font-weight: 600; color: #001f3f;">
                        Prices from: AED {{ number_format($latestProject->starting_price) }}
                    </p>
                    @endif
                    
                    @if($latestProject->location)
                    <p class="mb-2" style="color: #666; font-size: 1rem;">
                        <strong>Location:</strong> {{ $latestProject->location }}
                    </p>
                    @endif
                    
                    @if($latestProject->developer)
                    <p class="mb-2" style="color: #666; font-size: 1rem;">
                        <strong>Developer:</strong> {{ $latestProject->developer }}
                    </p>
                    @endif
                    
                    @if($latestProject->development_type)
                    <p class="mb-3" style="color: #666; font-size: 1rem;">
                        <strong>Development Type:</strong> {{ $latestProject->development_type }}
                    </p>
                    @endif
                    
                    @if($latestProject->description || $latestProject->overview)
                    <p class="mb-4" style="color: #666; font-size: 0.95rem; line-height: 1.6;">
                        {{ Str::limit(strip_tags($latestProject->description ?? $latestProject->overview ?? ''), 200) }}
                    </p>
                    @endif
                    
                    <a href="{{ route('off-plan-project.show', $latestProject->id) }}" class="btn align-self-start" style="background-color: white; color: #333; border: 1px solid #333; border-radius: 5px; padding: 12px 30px; font-weight: 500; text-decoration: none; transition: all 0.3s;">
                        View Property Details
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Latest Off Plan Development End ==============-->

    <!--============== Ready to Find Your Perfect Home Start ==============-->
    <div class="full-row py-0" style="background-color: #001f3f;">
        <div class="container-fluid p-0">
            <div class="row g-0 align-items-center">
                <!-- Left Section with Text and Buttons -->
                <div class="col-lg-6" style="background-color: #001f3f; padding: 80px 60px; position: relative; overflow: hidden;">
                    <!-- Geometric Pattern Background -->
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);"></div>
                    
                    <div style="position: relative; z-index: 1;">
                        <h2 class="text-white fw-bold mb-4" style="font-size: 2.5rem; line-height: 1.3;">
                            Ready to find your perfect home in Dubai for the best price?
                        </h2>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ url('featured-projects') }}" class="btn btn-lg" style="background-color: #aa8453; color: white; padding: 15px 40px; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 5px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">
                                Search
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-lg" style="background-color: #aa8453; color: white; padding: 15px 40px; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 5px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Right Section with Image -->
                <div class="col-lg-6 p-0">
                    @if($project->mainImage)
                        <img src="{{ $project->mainImage->media_link }}" alt="{{ $project->project_name }}" class="img-fluid w-100" style="height: 100%; min-height: 500px; object-fit: cover;">
                    @elseif($project->galleryImages->count() > 0)
                        <img src="{{ $project->galleryImages->first()->media_link }}" alt="{{ $project->project_name }}" class="img-fluid w-100" style="height: 100%; min-height: 500px; object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/images/property/property-1.jpg') }}" alt="Luxury Home" class="img-fluid w-100" style="height: 100%; min-height: 500px; object-fit: cover;">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--============== Ready to Find Your Perfect Home End ==============-->

    <style>
        .section-content {
            scroll-margin-top: 100px; /* Space for sticky nav */
        }
        .nav-link {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .nav-link.active {
            color: #001f3f !important;
            border-bottom: 2px solid #001f3f !important;
        }
        html {
            scroll-behavior: smooth;
        }
        /* Gallery Carousel Styles */
        #galleryCarousel {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        #galleryCarousel .carousel-item img {
            border-radius: 8px;
        }
        #galleryCarousel .carousel-control-prev,
        #galleryCarousel .carousel-control-next {
            width: 50px;
            height: 50px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        #galleryCarousel .carousel-control-prev:hover,
        #galleryCarousel .carousel-control-next:hover {
            opacity: 1;
        }
        #galleryCarousel .carousel-control-prev {
            left: 20px;
        }
        #galleryCarousel .carousel-control-next {
            right: 20px;
        }
        #galleryCarousel .carousel-indicators {
            bottom: 20px;
        }
        #galleryCarousel .carousel-indicators li {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.8);
        }
        #galleryCarousel .carousel-indicators li.active {
            background-color: #ff6b35;
            border-color: #ff6b35;
        }
        /* Thumbnail Gallery Styles */
        .thumbnail-item {
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        .thumbnail-item:hover {
            opacity: 1;
            transform: scale(1.05);
        }
        .thumbnail-item.active {
            opacity: 1;
            border-color: #001f3f !important;
            transform: scale(1.05);
        }
    </style>

    <script>
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                const offset = 100; // Offset for sticky nav
                const elementPosition = section.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Update active nav link
                document.querySelectorAll('#section-nav .nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                event.target.classList.add('active');
            }
        }

        // Update active nav on scroll
        window.addEventListener('scroll', function() {
            const sections = ['details-section', 'gallery-section', 'payment-plan-section'];
            const navLinks = document.querySelectorAll('#section-nav .nav-link');
            const scrollPosition = window.pageYOffset + 150;

            sections.forEach((sectionId, index) => {
                const section = document.getElementById(sectionId);
                if (section) {
                    const sectionTop = section.offsetTop;
                    const sectionBottom = sectionTop + section.offsetHeight;

                    if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                        navLinks.forEach(link => link.classList.remove('active'));
                        navLinks[index].classList.add('active');
                    }
                }
            });
        });

        // Gallery Carousel and Thumbnails Control
        $(document).ready(function() {
            var $carousel = $('#galleryCarousel');
            var $thumbnails = $('.thumbnail-item');
            
            // Initialize carousel
            if ($carousel.length) {
                $carousel.carousel({
                    interval: false,
                    wrap: true
                });
            }
            
            // Previous button click handler
            $('#galleryPrevBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if ($carousel.length) {
                    $carousel.carousel('prev');
                }
                return false;
            });
            
            // Next button click handler
            $('#galleryNextBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if ($carousel.length) {
                    $carousel.carousel('next');
                }
                return false;
            });
            
            // Click on thumbnail to navigate to that slide
            $thumbnails.on('click', function() {
                var slideTo = $(this).data('slide-to');
                if ($carousel.length && slideTo !== undefined) {
                    $carousel.carousel(parseInt(slideTo));
                }
            });
            
            // Click on indicators
            $('.carousel-indicators li').on('click', function(e) {
                e.preventDefault();
                var slideTo = $(this).data('slide-to');
                if ($carousel.length && slideTo !== undefined) {
                    $carousel.carousel(parseInt(slideTo));
                }
                return false;
            });
            
            // Update active thumbnail when carousel slides
            $carousel.on('slid.bs.carousel', function() {
                var activeIndex = $('.carousel-item.active').index();
                $thumbnails.removeClass('active');
                $('.carousel-indicators li').removeClass('active');
                if (activeIndex >= 0) {
                    $thumbnails.eq(activeIndex).addClass('active');
                    $('.carousel-indicators li').eq(activeIndex).addClass('active');
                }
            });
        });
    </script>
@endsection

