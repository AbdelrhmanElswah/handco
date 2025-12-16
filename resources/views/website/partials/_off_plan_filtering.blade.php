<div class="full-row p-0 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form class="quick-search form-icon-right position-relative" action="{{ Request::is('featured-projects*') ? route('featured_projects') : route('off_plan_listing') }}" method="GET">
                    <div class="row g-3">
                        <!-- Location or Developer or Keyword -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="position-relative">
                                <input type="text" class="form-control" name="keyword" placeholder="Location or Developer or Keyword" value="{{ request('keyword') }}" style="padding-left: 40px; border: 1px solid #ddd; border-radius: 4px;">
                                <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            </div>
                        </div>

                        <!-- Property Type Dropdown -->
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="position-relative">
                                <select class="form-control" name="category" style="appearance: none; padding-right: 40px; border: 1px solid #ddd; border-radius: 4px; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23ff6b35\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center;">
                                    <option value="">Property Type</option>
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $id => $categoryName)
                                            <option value="{{ $categoryName }}" {{ request('category') == $categoryName ? 'selected' : '' }}>{{ $categoryName }}</option>
                                        @endforeach
                                    @else
                                        <option value="Apartment" {{ request('category') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                        <option value="Villa" {{ request('category') == 'Villa' ? 'selected' : '' }}>Villa</option>
                                        <option value="Townhouse" {{ request('category') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                                        <option value="Penthouse" {{ request('category') == 'Penthouse' ? 'selected' : '' }}>Penthouse</option>
                                        <option value="Duplex" {{ request('category') == 'Duplex' ? 'selected' : '' }}>Duplex</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Beds Dropdown -->
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="position-relative">
                                <select class="form-control" name="bedrooms" style="appearance: none; padding-right: 40px; border: 1px solid #ddd; border-radius: 4px; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23ff6b35\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center;">
                                    <option value="">Beds</option>
                                    @if(isset($bedrooms) && $bedrooms->count() > 0)
                                        @foreach($bedrooms as $bedroom)
                                            <option value="{{ $bedroom }}" {{ request('bedrooms') == (string) $bedroom ? 'selected' : '' }}>{{ $bedroom }}</option>
                                        @endforeach
                                    @else
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="6+">6+</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Price Dropdown -->
                        <div class="col-lg-2 col-md-3 col-12">
                            <div class="position-relative">
                                <select class="form-control" name="price_range" style="appearance: none; padding-right: 40px; border: 1px solid #ddd; border-radius: 4px; background-image: url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 12 12\'><path fill=\'%23ff6b35\' d=\'M6 9L1 4h10z\'/></svg>'); background-repeat: no-repeat; background-position: right 12px center;">
                                    <option value="">Price</option>
                                    <option value="0-500000" {{ request('price_range') == '0-500000' ? 'selected' : '' }}>Up to 500,000 AED</option>
                                    <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500,000 - 1,000,000 AED</option>
                                    <option value="1000000-2000000" {{ request('price_range') == '1000000-2000000' ? 'selected' : '' }}>1,000,000 - 2,000,000 AED</option>
                                    <option value="2000000-3000000" {{ request('price_range') == '2000000-3000000' ? 'selected' : '' }}>2,000,000 - 3,000,000 AED</option>
                                    <option value="3000000-5000000" {{ request('price_range') == '3000000-5000000' ? 'selected' : '' }}>3,000,000 - 5,000,000 AED</option>
                                    <option value="5000000-10000000" {{ request('price_range') == '5000000-10000000' ? 'selected' : '' }}>5,000,000 - 10,000,000 AED</option>
                                    <option value="10000000-999999999" {{ request('price_range') == '10000000-999999999' ? 'selected' : '' }}>10,000,000+ AED</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-lg-2 col-md-3 col-12">
                            <button type="submit" class="btn w-100 form-control" style="background-color: #001f3f; color: white; border: none; padding: 0.375rem 0.75rem; border-radius: 4px; font-weight: 500; height: calc(1.9em + 0.75rem + 2px); display: flex; align-items: center; justify-content: center;">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>
</div>

