<div class="full-row p-0 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form class="quick-search form-icon-right position-relative" action="{{ route('projects') }}" method="GET">
                    <div class="row row-cols-lg-6 row-cols-md-4 row-cols-1 g-3">
                        <div class="col">
                            <input type="text" class="form-control" name="keyword" placeholder="Enter Keyword..." value="{{ request('keyword') }}">
                        </div>

                        <!-- Property Types Dropdown -->
                        <div class="col">
                            <select class="form-control" name="category">
                                <option value="">Property Types</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Options Dropdown -->
                        <div class="col">
                            <select class="form-control" name="payment_option">
                                <option value="">Payment Options</option>
                                @foreach($paymentOptions as $option)
                                    <option value="{{ $option }}" {{ request('payment_option') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location Dropdown -->
                        <div class="col">
                            <input type="text" class="form-control" name="location" placeholder="Location" value="{{ request('location') }}">
                        </div>

                        <!-- Price Range (Min and Max) -->
                        <div class="col">
                            <input type="number" class="form-control" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}">
                        </div>

                        <!-- Bedrooms Dropdown -->
                        <div class="col">
                            <select class="form-control" name="bedrooms">
                                <option value="" {{ is_null(request('bedrooms')) ? 'selected' : '' }}>Bedrooms</option>
                                @foreach($bedrooms as $bedroom)
                                    <option value="{{ $bedroom }}" {{ request('bedrooms') == (string) $bedroom ? 'selected' : '' }}> {{ $bedroom }} </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bathrooms Dropdown -->
                        <div class="col">
                            <select class="form-control" name="bathrooms">
                                <option value="">Bathrooms</option>
                                @foreach($bathrooms as $bathroom)
                                    <option value="{{ $bathroom }}" {{ request('bathrooms') == $bathroom ? 'selected' : '' }}>{{ $bathroom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Garage Option (Fixed) -->
                        <div class="col">
                            <select class="form-control" name="garage">
                                <option value="">Garage</option>
                                <option value="Yes" {{ request('garage') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ request('garage') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <!-- Additional Options -->
                        <div class="col">
                            <div class="position-relative">
                                <button class="form-control text-start toggle-btn" data-target="#aditional-check">Advanced <i class="fas fa-ellipsis-v font-mini icon-font y-center text-dark"></i></button>
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>

                    <!-- Advanced Filters -->
                    <div id="aditional-check" class="aditional-features p-5">
                        <h5 class="mb-3">Additional Options</h5>
<ul class="row row-cols-md-4 row-cols-1 custom-check-box mb-4">
    @foreach($additionalOptions as $option)
        @php
            // Format the option to remove underscores and capitalize words
            $formattedOption = ucwords(str_replace('_', ' ', $option));
        @endphp
        <li class="col">
            <input type="checkbox" class="custom-control-input hide" id="customCheck{{ $loop->index }}" name="additional_options[]" value="{{ $option }}" {{ in_array($option, request('additional_options', [])) ? 'checked' : '' }}>
            <label class="custom-control-label" for="customCheck{{ $loop->index }}">{{ $formattedOption }}</label>
        </li>
    @endforeach
</ul>

                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
</div>
