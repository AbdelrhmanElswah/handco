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
                                    <div class="cata position-absolute"><span class="sale bg-secondary text-white">{{ $project->status === 'available' ? 'For Sale' : 'Sold Out' }}</span></div>
                                    <a href="property-single-v1.html">
                                        <img src="{{ asset('files/projects/main_images/' . $project->mainImage->media) }}" alt="Image Not Found!">


                                    </a>
                                    <a href="#" class="listing-ctg text-white"><i class="fa-solid fa-building"></i><span>{{ $project->category->name }}</span></a>
                                    <ul class="position-absolute quick-meta">
                                        <li class="md-mx-none"><a class="quick-view" href="#quick-view" title="Quick View"><i class="flaticon-zoom-increasing-symbol flat-mini"></i></a></li>
                                    </ul>
                                </div>
                                <div class="property_text p-4">
                                    <span class="listing-price">${{ number_format($project->price, 2) }}</span>
                                    <h5 class="listing-title"><a href="property-single-v1.html">{{ $project->title }}</a></h5>
                                    <span class="listing-location"><i class="fas fa-map-marker-alt"></i> {{ $project->location }}</span>
                                    <ul class="d-flex quantity font-fifteen">
                                        <li title="Beds"><span><i class="fa-solid fa-bed"></i></span>{{ $project->beds }}</li>
                                        <li title="Baths"><span><i class="fa-solid fa-shower"></i></span>{{ $project->baths }}</li>
                                        <li title="Area"><span><i class="fa-solid fa-vector-square"></i></span>{{ $project->floor_area }} Sqft</li>
                                        <li title="Gas"><span><i class="fa-solid fa-fire"></i></span>{{ $project->has_gas ? 'Yes' : 'No' }}</li>
                                    </ul>
                                </div>
                                <div class="d-flex align-items-center post-meta mt-2 py-3 px-4 border-top">
                                    <div class="agent">
                                        <a href="#" class="d-flex text-general align-items-center"><span>Book Now</span></a>
                                    </div>
                                    <div class="post-date ms-auto"><span>{{ $project->status === 'available' ? 'For Sale' : 'Sold Out' }}</span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
