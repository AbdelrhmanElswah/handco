<!-- Loop for "Most Popular Projects" -->
@foreach($popularProjects as $project)
    <!-- Modal for each project in Popular Projects -->
    <div class="overlay-dark modal fade quick-view-modal" id="quick-view-{{ $project->id }}" tabindex="-1" aria-labelledby="quick-view-label-{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="close view-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body property-block summary p-3">
                    <div class="row row-cols-xl-2 row-cols-1">
                        <div class="col">
                            <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom m-2">
                                <div class="cata position-absolute">
                                    <span class="sale bg-secondary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $project->status === 'available' ? 'For Sale' : 'Sold Out' }}</span>
                                    @if($project->featured)
                                        <span class="featured bg-primary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Featured</span>
                                    @endif
                                </div>
                                <a href="#">
                                    <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}" alt="{{ $project->title ?? $project->project_name ?? 'Project' }}">
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="property_text transation py-3 pe-3">
                                <span class="d-inline-block text-primary">{{ $project->category->name ?? $project->development_type ?? 'N/A' }}</span>
                                <h5 class="modal-title mb-1">{{ $project->title ?? $project->project_name }}</h5>
                                <span class="mt-1 mb-3 d-block font-fifteen">
                                         <a href="{{ $project->location_link ?? '#' }}" target="_blank" style="display: flex; align-items: center; color: inherit;">
                                         <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #b89d68;"></i>
                                         {{ $project->location_name ?? $project->location ?? 'N/A' }}
                                          </a>
                                </span>
                                <div class="d-flex">
                                    @php
                                        $priceValue = $project->price ?? $project->starting_price ?? 0;
                                        $displayPrice = is_numeric($priceValue) ? 'AED ' . number_format($priceValue, 2) : ($priceValue ?: 'N/A');
                                    @endphp
                                    <span class="text-secondary font-large">{{ $displayPrice }}</span>
                                    <span class="text-white font-mini px-2 rounded product-status ms-5 my-1 bg-primary">
                                        <i class="fas fa-check"></i> {{ $project->status === 'available' ? 'Available' : 'Sold Out' }}
                                    </span>

                                </div>
                                <div class="product-offers mt-3">
                                    <ul class="product-offers-list">
                                      @if($project->selling_points && is_array($project->selling_points))
                                        @foreach($project->selling_points as $point)
                                            <li class="product-offer-item">
                                                <strong>{{ $point['label'] ?? '' }}: </strong> {{ $point['value'] ?? '' }}
                                            </li>
                                        @endforeach
                                      @endif
                                    </ul>
                                </div>
                                <hr>
                                <div class="quantity">
                                    <ul class="d-flex list-unstyled gap-4">
                                        @if($project->utility && $project->utility->bedrooms)
                                            <li><span>Rooms:</span> {{ $project->utility->bedrooms }}</li>
                                        @endif
                                        @if($project->utility && $project->utility->bathrooms)
                                            <li><span>Bathrooms:</span> {{ $project->utility->bathrooms }}</li>
                                        @endif
                                        @if($project->utility && $project->utility->garage)
                                            <li><span>Garage:</span> {{ $project->utility->garage }}</li>
                                        @endif
                                        <li><span>Area:</span> {{ $project->floor_area }} Sqft</li>
                                    </ul>
                                </div>
                                <h5 class="text-secondary my-3">Description</h5>
                                <p>{{ strip_tags($project->description ?? $project->overview ?? 'No description available.') }}</p>
                                <div class="short-description d-flex">
                                    <span class="me-4"><b>Highlights:</b></span>
                                    <div class="short-description">
                                        <ul class="list-style-tick">
                                            @if($project->tags && is_array($project->tags))
                                                @foreach($project->tags as $tag)
                                                    <li>{{ $tag }}</li>
                                                @endforeach
                                            @elseif($project->key_features && is_array($project->key_features))
                                                @foreach($project->key_features as $feature)
                                                    <li>{{ $feature }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="more-info">
                                    <h5 class="text-secondary my-3">More Information</h5>
                                    <ul class="list-style-tick">
                                      @if($project->more_information && is_array($project->more_information))
                                        @foreach($project->more_information as $info)
                                            <li>{{ $info['label'] ?? '' }}: {{ $info['value'] ?? '' }}</li>
                                        @endforeach
                                      @endif
                                    </ul>
                                </div>
                                <div class="d-flex align-items-center post-meta mt-2 py-3 border-top">
                                    <div class="post-date ms-auto"><span>{{ $project->created_at->diffForHumans() }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Loop for "Recent Projects" -->
@foreach($recentProjects as $project)
    <!-- Modal for each project in Popular Projects -->
    <div class="overlay-dark modal fade quick-view-modal" id="quick-view-{{ $project->id }}" tabindex="-1" aria-labelledby="quick-view-label-{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="close view-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body property-block summary p-3">
                    <div class="row row-cols-xl-2 row-cols-1">
                        <div class="col">
                            <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom m-2">
                                <div class="cata position-absolute">
                                    <span class="sale bg-secondary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">{{ $project->status === 'available' ? 'For Sale' : 'Sold Out' }}</span>
                                    @if($project->featured)
                                        <span class="featured bg-primary text-white" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">Featured</span>
                                    @endif
                                </div>
                                <a href="#">
                                    <img class="w-100" src="{{ ($project->mainImage && $project->mainImage->media_link) ? $project->mainImage->media_link : (($project->mainImage && $project->mainImage->media) ? asset('files/projects/main_images/' . $project->mainImage->media) : asset('images/default.jpg')) }}" alt="{{ $project->title ?? $project->project_name ?? 'Project' }}">
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="property_text transation py-3 pe-3">
                                <span class="d-inline-block text-primary">{{ $project->category->name ?? $project->development_type ?? 'N/A' }}</span>
                                <h5 class="modal-title mb-1">{{ $project->title ?? $project->project_name }}</h5>
                                <span class="mt-1 mb-3 d-block font-fifteen">
                                         <a href="{{ $project->location_link ?? '#' }}" target="_blank" style="display: flex; align-items: center; color: inherit;">
                                         <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #b89d68;"></i>
                                         {{ $project->location_name ?? $project->location ?? 'N/A' }}
                                          </a>                                </span>
                                <div class="d-flex">
                                    <span class="text-secondary font-large">AED {{ number_format($project->price ?? $project->starting_price ?? 0, 2) }}</span>
                                    <span class="text-white font-mini px-2 rounded product-status ms-5 my-1 bg-primary">
                                        <i class="fas fa-check"></i> {{ $project->status === 'available' ? 'Available' : 'Sold Out' }}
                                    </span>
                                </div>
                                <div class="product-offers mt-3">
                                    <ul class="product-offers-list">
                                      @if($project->selling_points && is_array($project->selling_points))
                                        @foreach($project->selling_points as $point)
                                            <li class="product-offer-item">
                                                <strong>{{ $point['label'] ?? '' }}: </strong> {{ $point['value'] ?? '' }}
                                            </li>
                                        @endforeach
                                      @endif
                                    </ul>
                                </div>
                                <hr>
                                <div class="quantity">
                                    <ul class="d-flex list-unstyled gap-4">
                                        @if($project->utility && $project->utility->bedrooms)
                                            <li><span>Rooms:</span> {{ $project->utility->bedrooms }}</li>
                                        @endif
                                        @if($project->utility && $project->utility->bathrooms)
                                            <li><span>Bathrooms:</span> {{ $project->utility->bathrooms }}</li>
                                        @endif
                                        @if($project->utility && $project->utility->garage)
                                            <li><span>Garage:</span> {{ $project->utility->garage }}</li>
                                        @endif
                                        <li><span>Area:</span> {{ $project->floor_area }} Sqft</li>
                                    </ul>

                                </div>
                                <h5 class="text-secondary my-3">Description</h5>
                                <p>{{ strip_tags($project->description ?? $project->overview ?? 'No description available.') }}</p>
                                <div class="short-description d-flex">
                                    <span class="me-4"><b>Highlights:</b></span>
                                    <div class="short-description">
                                        <ul class="list-style-tick">
                                            @if($project->tags && is_array($project->tags))
                                                @foreach($project->tags as $tag)
                                                    <li>{{ $tag }}</li>
                                                @endforeach
                                            @elseif($project->key_features && is_array($project->key_features))
                                                @foreach($project->key_features as $feature)
                                                    <li>{{ $feature }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="more-info">
                                    <h5 class="text-secondary my-3">More Information</h5>
                                    <ul class="list-style-tick">
                                      @if($project->more_information && is_array($project->more_information))
                                        @foreach($project->more_information as $info)
                                            <li>{{ $info['label'] ?? '' }}: {{ $info['value'] ?? '' }}</li>
                                        @endforeach
                                      @endif
                                    </ul>
                                </div>
                                <div class="d-flex align-items-center post-meta mt-2 py-3 border-top">
                                    <div class="post-date ms-auto"><span>{{ $project->created_at->diffForHumans() }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
