<div class="full-row p-0 property-search-form on-slider">
    <div class="container">
        <div class="row">
            <div class="col">
                <form class="bg-white shadow-sm quick-search form-icon-right position-relative" action="{{ route('home') }}" method="GET">
                    <div class="row row-cols-lg-6 row-cols-md-3 row-cols-1 g-3">
                        <!-- Keyword Input -->
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

                        <!-- Location Input -->
                        <div class="col">
                            <div class="position-relative">
                                <input type="text" class="form-control" name="location" placeholder="Location" value="{{ request('location') }}">
                                <i class="flaticon-placeholder flat-mini icon-font y-center text-dark"></i>
                            </div>
                        </div>

                        <!-- Price Range Dropdown (Collapsible) -->
                        <div class="col">
                            <div class="position-relative">
                                <button type="button" class="form-control price-toggle toggle-btn" data-target="#data-range-price">
                                    Price <i class="fas fa-angle-down font-mini icon-font y-center text-dark"></i>
                                </button>

                                <!-- Price Range Dropdown -->
                                <div id="data-range-price" class="price_range price-range-toggle d-none p-3 bg-white border rounded shadow-sm mt-2">
                                    <div class="area-filter price-filter">
                                        <!-- Min and Max Price Inputs as Inline Form Elements with Request Values -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <input type="number" name="min_price"
                                                   class="form-control form-control-sm me-2"
                                                   placeholder="Min"
                                                   style="width: 48%;"
                                                   min="0"
                                                   value="{{ request('min_price') ?? '' }}"> <!-- Pre-fill with request data -->
                                            <input type="number" name="max_price"
                                                   class="form-control form-control-sm"
                                                   placeholder="Max"
                                                   style="width: 48%;"
                                                   max="1000000"
                                                   value="{{ request('max_price') ?? '' }}"> <!-- Pre-fill with request data -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Options Toggle -->


                        <!-- Search Button -->
                        <div class="col">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


