<div class="property-overview border summary rounded bg-white p-30 mb-30">
    <div class="row mb-4">
        <div class="col-auto">
            <div class="post-meta font-small text-uppercase list-color-primary">
                <a href="#" class="listing-ctg"><i class="fa-solid fa-building"></i><span>{{ $project->category->name ?? 'Category' }}</span></a>
            </div>
            <h4 class="listing-title"><a href="#">{{ $project->title }}</a></h4>
            <span class="listing-location">
                <i class="fas fa-map-marker-alt text-primary"></i>
                {{ $project->location ?? 'Location not provided' }}
            </span>
        </div>
        <div class="col-auto ms-auto xs-m-0 text-end xs-text-start pb-4">
            <span class="listing-price">${{ number_format($project->price, 2) }}</span>
            <span class="text-white font-mini px-2 rounded product-status ms-auto xs-m-0 py-1 bg-primary">
                <i class="fas fa-check"></i> {{ $project->status ?? 'Available' }}
            </span>
        </div>
        <div class="col-12">
            <div class="product-offers mt-2">
                <ul class="product-offers-list">
                    @foreach($project->selling_points as $point)
                        <li class="product-offer-item">
                            <strong>{{ $point['label'] }} </strong>{{ $point['value'] }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <hr>
            <div class="mt-2">
                <ul class="list-three-fold-width d-table">
                    <li><span class="font-500">Rooms:</span> {{ $project->utility->bedrooms ?? 'N/A' }}</li>
                    <li><span class="font-500">Beds:</span> {{ $project->utility->beds ?? 'N/A' }}</li>
                    <li><span class="font-500">Area:</span> {{ number_format($project->floor_area) }} Sqft</li>
                    <li><span class="font-500">Baths:</span> {{ $project->utility->bathrooms ?? 'N/A' }}</li>
                    <li><span class="font-500">Car Garage:</span> {{ $project->utility->parking_spaces ? 'Yes (' . $project->utility->parking_spaces . ' Capacity)' : 'No' }}</li>
                    <li><span class="font-500">Swimming Pool:</span> {{ $project->utility->swimming_pool ? 'Yes' : 'No' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3">Description</h5>
            <p>{{ strip_tags($project->description) }}</p>

            <div class="short-description d-flex mt-3">
                <span class="me-4 font-500">Highlights:</span>
                <div class="short-description">
                    <ul class="list-style-tick">
                        @foreach($project->tags as $tag)
                            <li>{{ $tag }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
