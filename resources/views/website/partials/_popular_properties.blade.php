<div class="full-row bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col mb-5">
                <div class="align-items-center d-flex justify-content-between">
                    <div>
                        <h1 class="down-line text-white fw-bold" style="font-size: 2.5rem; margin: 0;">Recent Properties</h1>
                    </div>
                    <a href="{{ route('projects') }}" class="view-all-btn" style="text-decoration: none; font-weight: 600; font-size: 1.1rem; padding: 10px 20px; border: 2px solid white; border-radius: 5px; transition: all 0.3s; white-space: nowrap; color: white; background-color: transparent;">
                        View All
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="3block-carusel nav-disable owl-carousel" style="display: flex; align-items: stretch;">
                    @foreach($recentProjects as $project)
                        <div class="item" style="display: flex; align-items: stretch;">
                            <div class="property-grid-1 property-block bg-white transation-this" style="display: flex; flex-direction: column; height: 100%; width: 100%; border-radius: 8px; overflow: hidden;">
                                <!-- Property Image (match Off Plan card height) -->
                                <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom" style="height: 300px;">
                                    <div class="cata position-absolute">
                                        <span class="sale bg-secondary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $project->status === 'available' ? 'Available' : 'Sold Out' }}</span>
                                        <span class="sale bg-secondary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $project->rent_or_service === 'sell' ? 'For Sale' : 'For Rent' }}</span>
                                        <span class="sale bg-secondary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $project->category->name }}</span>
                                        @if($project->payment_option)
                                            <span class="payment bg-primary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $project->payment_option }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('projects.show', $project->id) }}">
                                        <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}" alt="Image Not Found!" style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="property_text p-4" style="flex: 1; display: flex; flex-direction: column;">
                                    <span class="listing-price" style="color: #001f3f;">AED {{ number_format($project->price) }}</span>
                                    <h5 class="listing-title">
                                        <a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                                    </h5>

                                    <!-- Google Maps Link for Location -->
                                    <span class="listing-location">
                                         <a href="{{ $project->location_link }}" target="_blank" style="display: flex; align-items: center; color: inherit;">
                                         <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #b89d68;"></i>
                                         {{ $project->location_name }}
                                          </a>
                                      </span>

                                    <ul class="d-flex quantity font-fifteen" style="flex-wrap: wrap; gap: 10px;">
                                        <!-- Property Features (e.g., Beds, Baths, Area, etc.) -->
                                        @if($project->utility && $project->utility->bedrooms)
                                            <li title="Beds" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-bed" style="font-size: 14px;"></i>
                                                <span>{{ $project->utility->bedrooms }}</span>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->bathrooms)
                                            <li title="Baths" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-shower" style="font-size: 14px;"></i>
                                                <span>{{ $project->utility->bathrooms }}</span>
                                            </li>
                                        @endif
                                        @if($project->floor_area)
                                            <li title="Area" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-vector-square" style="font-size: 14px;"></i>
                                                <span>{{ $project->floor_area }} Sqft</span>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->parking_spaces)
                                            <li title="Parking Spaces" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-car" style="font-size: 14px;"></i>
                                                <span>{{ $project->utility->parking_spaces }}</span>
                                            </li>
                                        @endif
                                        <!-- Additional Features (e.g., Pool, Gym, Garden, etc.) -->
                                        @if($project->utility && $project->utility->swimming_pool)
                                            <li title="Swimming Pool" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-water" style="font-size: 14px;"></i>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->gym)
                                            <li title="Gym" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-dumbbell" style="font-size: 14px;"></i>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->garden)
                                            <li title="Garden" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-tree" style="font-size: 14px;"></i>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->air_conditioning)
                                            <li title="Air Conditioning" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-snowflake" style="font-size: 14px;"></i>
                                            </li>
                                        @endif
                                        @if($project->utility && $project->utility->furnished)
                                            <li title="Furnished" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-couch" style="font-size: 14px;"></i>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="d-flex align-items-center post-meta mt-auto py-3 px-4 border-top">
                                    <div class="agent">
                                        <a href="{{ route('projects.show', $project->id) }}" class="d-flex text-general align-items-center"><span>Book Now</span></a>
                                    </div>
                                    <div class="post-date ms-auto">
                                        <span>{{ $project->rent_or_service === 'sell' ? 'For Sale' : 'For Rent' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure Recent Properties cards are aligned and fixed height */
    .3block-carusel.owl-carousel {
        display: flex !important;
    }
    
    .3block-carusel .owl-stage {
        display: flex !important;
        align-items: stretch !important;
    }
    
    .3block-carusel .owl-stage-outer {
        overflow: visible !important;
    }
    
    .3block-carusel .owl-item {
        display: flex !important;
        align-items: stretch !important;
        height: auto !important;
    }
    
    .3block-carusel .item {
        display: flex !important;
        align-items: stretch !important;
        height: 100% !important;
        width: 100% !important;
    }
    
    .3block-carusel .property-grid-1 {
        display: flex !important;
        flex-direction: column !important;
        height: 650px !important;
        width: 100% !important;
        overflow: hidden !important;
    }
    
    .3block-carusel .property_text {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        min-height: 0 !important;
        overflow: hidden !important;
    }
    
    .3block-carusel .listing-title {
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        line-height: 1.4 !important;
        max-height: 3em !important;
    }
    
    .3block-carusel .quantity {
        max-height: 60px !important;
        overflow: hidden !important;
    }
    
    .3block-carusel .post-meta {
        margin-top: auto !important;
    }
    
    /* Pagination colors */
    .pagination .page-item.active .page-link {
        background-color: #001f3f !important;
        border-color: #001f3f !important;
        color: #fff !important;
    }
    
    .pagination .page-link:hover {
        color: #001f3f !important;
    }
    
    /* View All Button Styling */
    .view-all-btn {
        color: white !important;
        background-color: transparent !important;
        border: 2px solid white !important;
    }
    
    .view-all-btn:hover {
        background-color: white !important;
        color: #001f3f !important;
        border-color: white !important;
    }
    
    .view-all-btn:visited {
        color: white !important;
    }
    
    .view-all-btn:visited:hover {
        color: #001f3f !important;
    }
</style>

<script>
    // Force fixed height for all cards - content won't control height
    (function() {
        function setFixedCardHeights() {
            const cards = document.querySelectorAll('.3block-carusel .property-grid-1');
            cards.forEach(card => {
                card.style.height = '650px';
                card.style.maxHeight = '650px';
                card.style.minHeight = '650px';
            });
        }
        
        // Run immediately and after various events
        setFixedCardHeights();
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setFixedCardHeights);
        }
        
        window.addEventListener('load', setFixedCardHeights);
        
        // After Owl Carousel initializes
        if (typeof jQuery !== 'undefined') {
            jQuery(document).ready(function() {
                const $carousel = jQuery('.3block-carusel');
                if ($carousel.length) {
                    $carousel.on('initialized.owl.carousel', setFixedCardHeights);
                    $carousel.on('resized.owl.carousel', setFixedCardHeights);
                    $carousel.on('changed.owl.carousel', setFixedCardHeights);
                    
                    setTimeout(setFixedCardHeights, 200);
                }
            });
        }
    })();
</script>
