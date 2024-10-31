@extends('layouts.website', [
    'title' => 'Blogs And News',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])
@php
$blogs = [
    [
      "category" => "Apartments",
      "title" => "Blog post 1 title",
      "author" => "M. Hamed",
      "date" => "Oct 21, 2024",
      "image" => "6.png",
    ],
    [
      "category" => "Villas",
      "title" => "Blog post 2 title",
      "author" => "A. ElSawah",
      "date" => "Oct 22, 2024",
      "image" => "7.png",
    ],
    [
      "category" => "Towers",
      "title" => "Blog post 3 title",
      "author" => "A. ElImam",
      "date" => "Oct 23, 2024",
      "image" => "8.png",
    ],
    [
      "category" => "Villas",
      "title" => "Blog post 2 title",
      "author" => "A. ElSawah",
      "date" => "Oct 22, 2024",
      "image" => "7.png",
    ],
    [
      "category" => "Towers",
      "title" => "Blog post 3 title",
      "author" => "A. ElImam",
      "date" => "Oct 23, 2024",
      "image" => "8.png",
    ],
    [
      "category" => "Apartments",
      "title" => "Blog post 1 title",
      "author" => "M. Hamed",
      "date" => "Oct 21, 2024",
      "image" => "6.png",
    ],
];
@endphp

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3 class="text-secondary">Real EState Blog & News</h3>
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
                                <div class="thumb-blog-cover-img hover-img-zoom overflow-hidden transation">
                                    <div class="post-image">
                                        <img src="assets/images/property/{{ $blog['image'] }}" alt="Image not found!">
                                    </div>
                                    <div class="post-content p-35">
                                        <div class="post-meta list-color-white mb-2">
                                            <a href="#"><span>{{ $blog['category'] }}</span></a>
                                        </div>
                                        <h5><a href="#" class="transation text-white hover-text-primary d-block mb-2">
                                                {{ $blog['title'] }}
                                            </a></h5>
                                        <div class="post-meta font-small list-color-light">
                                            <a href="#"><span>By {{ $blog['author'] }}</span></a>
                                            <a href="#"><span>{{ $blog['date'] }}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col mt-5">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination pagination-dotted-active justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous Page</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next Page</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Blog Area End ==============-->
@endsection
