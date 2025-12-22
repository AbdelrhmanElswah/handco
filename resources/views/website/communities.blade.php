@extends('layouts.website', [
    'title' => 'Dubai Communities',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-secondary fw-bold text-start" style="font-size: 2.5rem;">Dubai Communities</h1>
                    @if(request()->has('subtitle') && request('subtitle'))
                        <p class="text-muted mt-2 text-start">{{ request('subtitle') }}</p>
                    @else
                        <p class="text-muted mt-2 text-start">Discover Dubai's most iconic neighbourhoods and lifestyle destinations.</p>
                    @endif
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 bg-transparent p-0 justify-content-start">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Communities</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--============== Page title End ==============-->

    <!--============== Filter Section Start ==============-->
    <div class="full-row p-0 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form class="quick-search form-icon-right position-relative" action="{{ route('communities') }}" method="GET">
                        <div class="row row-cols-lg-6 row-cols-md-4 row-cols-1 g-3 justify-content-start">
                            <div class="col">
                                <input type="text" class="form-control" name="keyword" placeholder="Enter Project" value="{{ request('keyword') }}">
                            </div>

                            <!-- Community Name Dropdown -->
                            <div class="col">
                                <select class="form-control" name="community_name">
                                    <option value="">Community Name</option>
                                    @foreach($allCommunities as $commName)
                                        <option value="{{ $commName }}" {{ request('community_name') == $commName ? 'selected' : '' }}>{{ $commName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Developer Dropdown -->
                            <div class="col">
                                <select class="form-control" name="developer">
                                    <option value="">Developer</option>
                                    @foreach($developers as $developer)
                                        <option value="{{ $developer }}" {{ request('developer') == $developer ? 'selected' : '' }}>{{ $developer }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Property Type Dropdown -->
                            <div class="col">
                                <select class="form-control" name="property_type">
                                    <option value="">Property Type</option>
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Dropdown -->
                            <div class="col">
                                <select class="form-control" name="status">
                                    <option value="">Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <button class="btn btn-primary w-100">Find Now</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <!--============== Filter Section End ==============-->

    <!--============== Communities Grid Start ==============-->
    <div class="full-row pt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 order-xl-1 sm-mb-30">
                    <div class="row row-cols-md-3 row-cols-1 g-4 justify-content-start">
                        @foreach($communities as $community)
                            <div class="col">
                                <a href="{{ route('communities.show', $community->id) }}" class="text-decoration-none d-block">
                                    <div class="thumb-blog-cover-img blog-card">
                                        <div class="post-image">
                                           <img src="{{ $community->mainImage->media_link ?? asset('assets/images/default.png') }}" alt="Image not found!" class="blog-image">
                                        </div>
                                        <div class="post-content">
                                            <h5 class="transation text-white hover-text-primary d-block mb-2">{{ $community->title }}</h5>
                                            <div class="post-meta font-small list-color-light">
                                                <span>{{ $community->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination with Numeric Links -->
                    <div class="row">
                        <div class="col mt-5 d-flex justify-content-start">
                            {{ $communities->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Communities Grid End ==============-->

    <!-- Inline CSS Styling -->
    <style>
        /* Ensure proper left alignment for all content */
        .full-row .container {
            text-align: left;
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .full-row .row {
            justify-content: flex-start !important;
            margin-left: 0;
            margin-right: 0;
        }
        
        /* Page title section alignment */
        .full-row .col {
            text-align: left !important;
            padding-left: 0;
        }
        
        /* Filter form alignment */
        .quick-search {
            text-align: left;
        }
        
        .quick-search .row {
            justify-content: flex-start !important;
            margin-left: 0;
            margin-right: 0;
        }
        
        .quick-search .col {
            padding-left: 0;
            padding-right: 12px;
        }
        
        /* Community cards container */
        .row-cols-md-3 {
            justify-content: flex-start !important;
            margin-left: 0;
            margin-right: 0;
        }
        
        .row-cols-md-3 > .col {
            padding-left: 0;
            padding-right: 16px;
        }
        
        /* Community Card Styling */
        .blog-card {
            position: relative;
            height: 300px;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
            display: block;
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }

        .blog-card:hover {
            transform: scale(1.05);
        }

        .blog-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
            display: block;
            object-position: left center;
        }

        .blog-card:hover .blog-image {
            transform: scale(1.1);
        }

        .post-image {
            width: 100%;
            height: 100%;
            position: relative;
            display: block;
        }

        .post-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            padding: 15px;
            box-sizing: border-box;
            pointer-events: none;
            text-align: left;
        }

        .post-content h5 {
            pointer-events: none;
            text-align: left;
            margin-left: 0;
        }
        
        .post-content .post-meta {
            text-align: left;
            margin-left: 0;
        }
        
        /* Pagination alignment */
        .pagination {
            justify-content: flex-start !important;
        }
        
        /* Remove any center alignment */
        .text-center {
            text-align: left !important;
        }
        
        /* Ensure breadcrumb is left aligned */
        .breadcrumb {
            justify-content: flex-start !important;
        }
    </style>
@endsection
