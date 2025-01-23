<div class="property-overview border summary rounded bg-white p-30 mb-30">
    <div class="row mb-4">
        <div class="col-auto">
            <div class="post-meta font-small text-uppercase list-color-primary">
                <a href="#" class="listing-ctg"><i class="fa-solid fa-building"></i><span>{{ $project->category->name ?? 'Category' }}</span></a>
            </div>
            <h4 class="listing-title"><a href="#">{{ $project->title }}</a></h4>
            <span class="listing-location">
                <a href="{{ $project->location_link }}" target="_blank" style="display: flex; align-items: center; color: inherit;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #b89d68;"></i>
                    {{ $project->location_name }}
                </a>
            </span>
        </div>
        <div class="col-auto ms-auto xs-m-0 text-end xs-text-start pb-4">
            <span class="listing-price">AED {{ number_format($project->price) }}</span>
            <span class="text-white font-mini px-2 rounded product-status ms-auto xs-m-0 py-1 bg-primary">
                <i class="fas fa-check"></i> {{ $project->status ?? 'Available' }}
            </span>
         
            @if($project->payment_option)
                <span class="text-white font-mini px-2 rounded ms-2 py-1 bg-success">
            <i class="fas fa-dollar-sign"></i> {{ $project->payment_option }}
        </span>
            @endif
        </div>
        <div class="col-12">
            <div class="product-offers mt-2">
                <ul class="product-offers-list">
                  @if($project->selling_points)
                    @foreach($project->selling_points as $point)
                        <li class="product-offer-item">
                            <strong>{{ $point['label'] }} </strong>{{ $point['value'] }}
                        </li>
                    @endforeach
                  @endif
                </ul>
            </div>

            <hr>
            <div class="mt-2">
                <ul class="d-flex flex-wrap list-unstyled mb-0">
                    <li class="me-4">
                        <span class="fw-bold">Rooms:</span> {{ $project->utility->bedrooms ?? 'N/A' }}
                    </li>
                    <li class="me-4">
                        <span class="fw-bold">Area:</span> {{ number_format($project->floor_area) }} Sqft
                    </li>
                    <li class="me-4">
                        <span class="fw-bold">Baths:</span> {{ $project->utility->bathrooms ?? 'N/A' }}
                    </li>
                    <li>
                        <span class="fw-bold">Car Garage:</span> {{ $project->utility->parking_spaces ? 'Yes (' . $project->utility->parking_spaces . ' Capacity)' : 'No' }}
                    </li>
                </ul>

            </div>
        </div>
    </div>

    <div class="row row-cols-1">
        <div class="col">
            <h5 class="mb-3">Description</h5>
            <p>{!!$project->description!!}</p>

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
