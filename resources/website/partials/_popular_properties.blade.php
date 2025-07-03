<div class="full-row bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col mb-5">
                <h2 class="down-line text-white w-50 mx-auto text-center w-sm-100">Recent Properties</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="3block-carusel nav-disable owl-carousel">
                    @foreach($recentProjects as $project)
                        <div class="item">
                            <div class="property-grid-1 property-block bg-white transation-this">
                                <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom">
                                    <div class="cata position-absolute">
                                        <span class="sale bg-secondary text-white">{{ $project->status === 'available' ? 'Available' : 'Sold Out' }}</span>
                                        <span class="sale bg-secondary text-white">{{ $project->rent_or_service === 'sell' ? 'For Sale' : 'For Rent' }}</span>
                                        @if($project->payment_option)
                                            <span class="payment bg-primary text-white">{{ $project->payment_option }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('projects.show', $project->id) }}">
                                <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}" alt="Image Not Found!">

                                    </a>
                                    <a href="#" class="listing-ctg text-white">
                                        <i class="fa-solid fa-building"></i><span>{{ $project->category->name }}</span>
                                    </a>
                                    <ul class="position-absolute quick-meta">
                                        <li class="md-mx-none"><a class="quick-view" href="#quick-view-{{ $project->id }}" title="Quick View"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                                    </ul>
                                </div>
                                <div class="property_text p-4">
                                    <span class="listing-price">AED {{ number_format($project->price) }}</span>
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
                                <div class="d-flex align-items-center post-meta mt-2 py-3 px-4 border-top">
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
