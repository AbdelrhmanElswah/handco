@extends('layouts.website', [
    'title' => $blog['title'],
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
        <!--============== Page title Start ==============-->
        <div class="full-row py-5">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h3 class="text-secondary">{{ $blog['title'] }}</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 bg-transparent p-0">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a></li>
                                <li class="breadcrumb-item active text-primary" aria-current="page">{{ $blog['title'] }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--============== Page title End ==============-->

        <!--============== Blog Area Start ==============-->
        <div class="full-row pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 order-xl-2">
                        <div class="blog-sidebar widget-box-model">
                            <!--============== Recent Property Widget Start ==============-->
                            <div class="widget widget_recent_property">
                                <h5 class="text-secondary mb-4">Recent Projects</h5>
                                <ul>
                                    @foreach($recentProjects as $recentProject)
                                        <li>
                                            <img src="{{ asset('files/projects/main_images/' . ($recentProject->mainImage->media ?? 'default.jpg')) }}" alt="{{ $recentProject->title }}">
                                            <div class="thumb-body">
                                                <h6 class="listing-title">
                                                    <a href="{{ route('projects.show', $recentProject->id) }}">{{ $recentProject->title }}</a>
                                                </h6>
                                                <span class="listing-price">${{ number_format($recentProject->price, 2) }}</span>
                                                <ul class="d-flex quantity font-fifteen">
                                                    <li title="Area">
                                                        <span><i class="fa-solid fa-vector-square"></i></span>
                                                        {{ number_format($recentProject->floor_area) }} Sqft
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 order-xl-1 sm-mb-30">
                        <div class="summary mb-30">
                            <div class="post-image">
                                <!-- Display the blog's main image or a default if not available -->
                                <img src="{{ $blog->mainImage->media_link ?? asset('assets/images/default.png') }}" alt="Image not found!" style="width: 540px; height: auto;" class="img-fluid">
                            </div>
                        </div>
                        <div class="single-post summary mb-30">
                            <div class="single-post-title">
                                <!-- Display the blog's category name or a default value -->
                                <span class="d-inline-block text-primary">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                                <!-- Display the blog's title dynamically -->
                                <h3 class="mb-2 text-secondary">{{ $blog->title }}</h3>
                                <div class="post-meta list-color-general mb-4">
                                    <!-- Display the author's name and the date dynamically -->
                                    <a href="#"><i class="flaticon-user-silhouette flat-mini"></i> <span>By Admin</span></a>
                                    <a href="#"><i class="flaticon-calendar flat-mini"></i> <span>{{ $blog->created_at->format('M d, Y') }}</span></a>
                                </div>
                            </div>
                            <div class="post-content pt-4 mb-5">
                                <!-- Display the full blog content -->
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--============== Blog Area End ==============-->
@endsection

