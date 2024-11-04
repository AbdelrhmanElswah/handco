<div class="full-row bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col mb-5">
                <h2 class="down-line text-white w-50 mx-auto text-center w-sm-100">Most Popular Projects</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="3block-carusel nav-disable owl-carousel">
                    @foreach($projects as $project)
                        <div class="item">
                            <div class="property-grid-1 property-block bg-white transation-this">
                                <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom">
                                    <div class="cata position-absolute">
                                        <span class="sale bg-secondary text-white">{{ $project->status === 'available' ? 'For Sale' : 'Sold Out' }}</span>
                                    </div>
                                    <a href="#">
                                        <img src="{{ asset('files/projects/main_images/' . $project->mainImage->media) }}" alt="Image Not Found!">
                                    </a>
                                    <a href="#" class="listing-ctg text-white">
                                        <i class="fa-solid fa-building"></i><span>{{ $project->category->name }}</span>
                                    </a>
                                    <ul class="position-absolute quick-meta">
                                        <li><a href="#" title="Add Compare"><i class="flaticon-transfer flat-mini"></i></a></li>
                                        <li><a href="#" title="Add Favourite"><i class="flaticon-like-1 flat-mini"></i></a></li>
                                        <li class="md-mx-none"><a class="quick-view" href="#quick-view" title="Quick View"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                                    </ul>
                                </div>
                                <div class="property_text p-4">
                                    <span class="listing-price">${{ number_format($project->price, 2) }}<small> ({{ $project->payment_type }})</small></span>
                                    <h5 class="listing-title">
                                        <a href="#">{{ $project->title }}</a>
                                    </h5>

                                    <!-- Google Maps Link for Location -->
                                    <span class="listing-location">
                                        @if($project->location)
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($project->location) }}" target="_blank" class="text-white" style="display: flex; align-items: center; color: inherit;">
                                                <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #b89d68;"></i>
                                                {{ $project->location }}
                                            </a>
                                        @else
                                            <span class="text-muted">Location not available</span>
                                        @endif
                                    </span>

                                    <ul class="d-flex quantity font-fifteen" style="flex-wrap: wrap; gap: 10px;">
                                        <!-- Beds -->
                                        @if($project->utility && $project->utility->bedrooms)
                                            <li title="Beds" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-bed" style="font-size: 14px;"></i>
                                                <span>{{ $project->utility->bedrooms }}</span>
                                            </li>
                                        @endif

                                        <!-- Baths -->
                                        @if($project->utility && $project->utility->bathrooms)
                                            <li title="Baths" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-shower" style="font-size: 14px;"></i>
                                                <span>{{ $project->utility->bathrooms }}</span>
                                            </li>
                                        @endif

                                        <!-- Area -->
                                        @if($project->floor_area)
                                            <li title="Area" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-vector-square" style="font-size: 14px;"></i>
                                                <span>{{ $project->floor_area }} Sqft</span>
                                            </li>
                                        @endif

                                        <!-- Parking Spaces -->
                                        @if($project->utility && $project->utility->parking_spaces)
                                            <li title="Parking Spaces" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-car" style="font-size: 14px;"></i>
                                                <span>{{ $project->utility->parking_spaces }}</span>
                                            </li>
                                        @endif

                                        <!-- Swimming Pool -->
                                        @if($project->utility && $project->utility->swimming_pool)
                                            <li title="Swimming Pool" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-water" style="font-size: 14px;"></i>
                                            </li>
                                        @endif

                                        <!-- Gym -->
                                        @if($project->utility && $project->utility->gym)
                                            <li title="Gym" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-dumbbell" style="font-size: 14px;"></i>
                                            </li>
                                        @endif

                                        <!-- Garden -->
                                        @if($project->utility && $project->utility->garden)
                                            <li title="Garden" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-tree" style="font-size: 14px;"></i>
                                            </li>
                                        @endif

                                        <!-- Air Conditioning -->
                                        @if($project->utility && $project->utility->air_conditioning)
                                            <li title="Air Conditioning" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-snowflake" style="font-size: 14px;"></i>
                                            </li>
                                        @endif

                                        <!-- Furnished -->
                                        @if($project->utility && $project->utility->furnished)
                                            <li title="Furnished" style="display: flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-couch" style="font-size: 14px;"></i>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="d-flex align-items-center post-meta mt-2 py-3 px-4 border-top">
                                    <div class="agent">
                                        <a href="#" class="d-flex text-general align-items-center"><span>Book Now</span></a>
                                    </div>
                                    <div class="post-date ms-auto">
                                        <span>{{ $project->status === 'available' ? 'For Sale' : 'Sold Out' }}</span>
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
