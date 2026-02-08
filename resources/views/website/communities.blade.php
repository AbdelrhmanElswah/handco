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
                <div class="col-12">
                    <h1 class="text-secondary fw-bold" style="font-size: 2.5rem;">Dubai Communities</h1>
                    @if(request()->has('subtitle') && request('subtitle'))
                        <p class="text-muted mt-2">{{ request('subtitle') }}</p>
                    @else
                        <p class="text-muted mt-2">Discover Dubai's most iconic neighbourhoods and lifestyle destinations.</p>
                    @endif
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
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
                <div class="col-12">
                    <form class="quick-search form-icon-right position-relative" action="{{ route('communities') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-lg-2 col-md-4 col-12">
                                <input type="text" class="form-control" name="keyword" placeholder="Enter Project" value="{{ request('keyword') }}">
                            </div>

                            <!-- Community Name Dropdown -->
                            <div class="col-lg-2 col-md-4 col-12">
                                <select class="form-control" name="community_name">
                                    <option value="">Community Name</option>
                                    @foreach($allCommunities as $commName)
                                        <option value="{{ $commName }}" {{ request('community_name') == $commName ? 'selected' : '' }}>{{ $commName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Developer Dropdown -->
                            <div class="col-lg-2 col-md-4 col-12">
                                <select class="form-control" name="developer">
                                    <option value="">Developer</option>
                                    @foreach($developers as $developer)
                                        <option value="{{ $developer }}" {{ request('developer') == $developer ? 'selected' : '' }}>{{ $developer }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Property Type Dropdown -->
                            <div class="col-lg-2 col-md-4 col-12">
                                <select class="form-control" name="property_type">
                                    <option value="">Property Type</option>
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type }}" {{ request('property_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Dropdown -->
                            <div class="col-lg-2 col-md-4 col-12">
                                <select class="form-control" name="status">
                                    <option value="">Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-4 col-12">
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
                <div class="col-12">
                    <div class="row g-4">
                        @foreach($communities as $community)
                            <div class="col-md-4 col-12">
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
                        <div class="col-12 mt-5">
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
        /* Ensure proper left alignment for all content - Override any global styles */
        .full-row .container {
            text-align: left !important;
            padding-left: 0 !important;
            padding-right: 15px !important;
        }
        
        /* Page title section alignment - Move more to left */
        .full-row .col-12 {
            text-align: left !important;
            padding-left: 0 !important;
            padding-right: 15px !important;
        }
        
        /* Ensure all headings and text are left aligned */
        .full-row h1,
        .full-row h2,
        .full-row h3,
        .full-row h4,
        .full-row h5,
        .full-row h6,
        .full-row p {
            text-align: left !important;
            margin-left: 0 !important;
            padding-left: 0 !important;
        }
        
        /* Filter form alignment - Move to left */
        .quick-search {
            text-align: left !important;
            padding-left: 0 !important;
        }
        
        .quick-search .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            justify-content: flex-start !important;
            padding-left: 0 !important;
        }
        
        .quick-search .form-control,
        .quick-search .btn {
            text-align: left !important;
        }
        
        /* Community cards container - ensure left alignment */
        .full-row .row.g-4 {
            margin-left: 0 !important;
            margin-right: 0 !important;
            justify-content: flex-start !important;
            padding-left: 0 !important;
        }
        
        .full-row .row.g-4 > .col-md-4 {
            padding-left: 0 !important;
            padding-right: 15px !important;
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
            margin: 0 auto;
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
            text-align: left !important;
        }

        .post-content h5 {
            pointer-events: none;
            text-align: left !important;
            margin: 0 0 8px 0;
        }
        
        .post-content .post-meta {
            text-align: left !important;
            margin: 0;
        }
        
        /* Pagination alignment */
        .pagination {
            justify-content: flex-start !important;
            text-align: left !important;
        }
        
        /* Ensure breadcrumb is left aligned */
        .breadcrumb {
            justify-content: flex-start !important;
            text-align: left !important;
        }
        
        .breadcrumb-item {
            text-align: left !important;
        }
        
        /* Consistent spacing for all sections - Move everything to left */
        .full-row .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
        }
        
        /* Override any center alignment from global styles */
        .full-row .text-center {
            text-align: left !important;
        }
        
        /* Ensure container content starts from left */
        .full-row .container .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
        }
        
        /* Breadcrumb - Move to left */
        .breadcrumb {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }
        
        /* Pagination - Move to left */
        .pagination {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }
    </style>
@endsection
