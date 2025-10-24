@extends('layouts.website', [
    'title' => 'Blogs And News',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="text-secondary">Real Estate Blog & News</h3>
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Blogs</li>
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
                <div class="col-xl-12 order-xl-1 sm-mb-30">
                    <div class="row row-cols-md-3 row-cols-1 g-4">
                        @foreach($blogs as $blog)
                            <div class="col">
                                <div class="thumb-blog-cover-img blog-card">
                                    <div class="post-image">
                                       <a href="{{ route('blogs.show', $blog->id) }}"><img src="{{ $blog->mainImage->media_link ?? asset('assets/images/default.png') }}" alt="Image not found!" class="blog-image"></a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta list-color-white mb-2">
                                            <span>{{ $blog->category->name ?? 'Uncategorized' }}</span>
                                        </div>
                                        <h5><a href="{{ route('blogs.show', $blog->id) }}" class="transation text-white hover-text-primary d-block mb-2">{{ $blog->title }}</a></h5>
                                        <div class="post-meta font-small list-color-light">
                                            <span>By Admin</span>
                                            <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination with Numeric Links -->
                    <div class="row">
                        <div class="col mt-5">
                            {{ $blogs->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Blog Area End ==============-->

    <!-- Inline CSS Styling -->
    <style>
        /* Blog Card Styling */
        .blog-card {
            position: relative;
            height: 300px; /* Set a fixed height for all blog cards */
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .blog-card:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }

        .blog-image {
            width: 100%;
            height: 100%; /* Make image occupy full height of the card */
            object-fit: cover; /* Ensures image fits proportionally */
        }

        .post-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Overlay background color */
            color: white;
            padding: 15px;
            box-sizing: border-box;
        }
    </style>
@endsection
