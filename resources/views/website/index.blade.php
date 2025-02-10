@extends('layouts.website', [
    'title' => 'Home Page',
    'headerType' => '_header',
    'bg' => 'bg-white'
])

@section('content')

    <!--============== Slider Area Start ==============-->
    @include('website.partials._slider')
    <!--============== Slider Area End ==============-->

    <!--============== Property Search Form Start ==============-->
    @include('website.partials._property_search')
    <!--============== Property Search Form End ==============-->

    <!-- =============== About ================-->
    <div class="full-row" style="padding: 70px 0 30px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h1 class="text-dark mb-0" style="line-height: 50px">Our <br> Main Services</h1>
                </div>
                <div class="col-lg-4">
                    <div class="py-2 pt-3">
                        <p>
                            H&Co Properties provides expert real estate services in Dubai, helping you buy, sell, or
                            invest with ease.
                            From luxury homes to commercial spaces, we guide you every step of the way.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 d-flex justify-content-md-end">
                    <ul class="list-style-tick d-flex flex-column my-2">
                        <li>Properties Sales and Listing</li>
                        <li>Real Estate Investment and Consulting</li>
                        <li>Property Management</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- =============== About ================-->

    <div class="full-row p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- =============== Counting ================-->
    <div class="full-row">
        <div class="container">
            <div class="row row-cols-lg-3 row-cols-1">
                <div class="col">
                    <div class="d-flex flex-row text-uppercase">
                        <h1 class="text-primary mb-0 pe-4">$15.4M</h1>
                        <p>Owned from <br>Properties Transactions</p>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-row text-uppercase">
                        <h1 class="text-primary mb-0 pe-4">25K+</h1>
                        <p>Owned from <br>Properties Transactions</p>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-row text-uppercase">
                        <h1 class="text-primary mb-0 pe-4">500</h1>
                        <p>Owned from <br>Properties Transactions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =============== Counting ================-->

    <!--============== Recent Property Start ==============-->
    @include('website.partials._recent_properties', ['popularProjects' => $popularProjects])
    <!--============== Recent Property End ==============-->

    <!--============== Property Category Start ==============-->
    <div class="full-row bg-secondary">
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <h2 class="down-line w-50 mx-auto mb-4 text-center text-white w-sm-100">What Are You Looking
                        for?</h2>
                    <span class="d-table w-50 w-sm-100 sub-title text-white fw-normal mx-auto text-center">Select what you are looking for.</span>
                </div>
            </div>
            <div class="row row-cols-lg-5 row-cols-sm-4 row-cols-1 g-3 justify-content-center">
                
            <!-- Property Categories (Example for 1 category) -->
            @php
            $icons = [
                'Apartment' => 'fa fa-building',
                'Villa' => 'fa fa-house-user',
                'Townhouse' => 'fa fa-house-damage',
                'Penthouse' => 'fa fa-building',
                'Compound' => 'fa fa-city',
                'Duplex' => 'fa fa-home',
                'Full Floor' => 'fa fa-building',
                'Half Floor' => 'fa fa-building',
                'Whole Building' => 'fa fa-building',
                'Bulk Rent Unit' => 'fa fa-boxes',
                'Bungalow' => 'fa fa-home',
                'Hotel & Hotel Apartment' => 'fa fa-hotel',
                'Office Space' => 'fa fa-briefcase',
            ];
            @endphp
                    
            @foreach($allCategories as $category)
                <div class="col">
                    <a href="{{ route('projects', ['category' => $category->id]) }}"
                    class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            @if(array_key_exists($category->name, $icons))
                                <i class="{{ $icons[$category->name] }} flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                            @else
                                <i class="flaticon-home flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                            @endif
                        </div>
                        
                        <h6 class="d-block text-secondary">{{ $category->name }}</h6>
                    </a>
                </div>
            @endforeach

<!--
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i class="flaticon-sketch-1 flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Solid Land</h6>
                        <p>Hight listed solid use-able land in most popular area for development</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i
                                class="flaticon-online-booking flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Office Floor</h6>
                        <p>Preview most popular are office building listed category</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i class="flaticon-shop flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Commercial</h6>
                        <p>Listing Commercial property for business and factory development</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i class="flaticon-real-estate flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Hostel Room</h6>
                        <p>if you are single looking for sinlge living, preview the hostel listing</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i
                                class="flaticon-online-booking flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Appartment</h6>
                        <p>for family living appartment, find your best appartment in our directort list</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i class="flaticon-sketch flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Condo</h6>
                        <p>In our directory we have listed luxury condo for rent and sale</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i class="flaticon-spa flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Villa House</h6>
                        <p>Please who like villa house click here this category listed</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#"
                       class="text-center d-flex flex-column align-items-center hover-text-white p-4 bg-white transation text-general hover-bg-primary h-100">
                        <div class="box-70px position-relative">
                            <i class="flaticon-bed flat-medium d-inline-block text-primary position-absolute xy-center"></i>
                        </div>
                        <h6 class="d-block text-secondary">Hotel Room</h6>
                        <p>The traveller people can findbest hotel here for living night</p>
                    </a>
                </div>
            -->

                <!-- Add other categories here similarly -->
            </div>
        </div>
    </div>
    <!--============== Property Category End ==============-->

    <!--============== Testimonial Section Start ==============-->
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col mb-5">
                    <span class="text-primary tagline pb-2 d-table m-auto">Testimonial</span>
                    <h2 class="down-line w-50 mx-auto mb-4 text-center w-sm-100">What Client Says About Us</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="testimonial-simple text-center px-5">
                        <div class="text-carusel owl-carousel">
                            <div class="item">
                                <i class="flaticon-right-quote flat-large text-primary d-table mx-auto"></i>
                                <blockquote class="text-secondary fs-5 fst-italic">“ Posuere mus curabitur parturient
                                    scelerisque ...”
                                </blockquote>
                                <h4 class="mt-4 font-400">Mark Wiggins</h4>
                                <span class="text-primary font-fifteen">CEO ( Grodins Group )</span>
                            </div>
                            <!-- Add other testimonials here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Testimonial Section End ==============-->

    <!--============== Popular Properties Start ==============-->
    @include('website.partials._popular_properties', ['recentProjects' => $recentProjects])
    <!--============== Popular Properties End ==============-->

    <!--============== Blog Section Start ==============-->
    @include('website.partials._blogs')
    <!--============== Blog Section End ==============-->

@endsection



<!-- Script to toggle Price and Advanced Options dropdowns -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-btn").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                const target = document.querySelector(button.getAttribute("data-target"));
                if (target) {
                    target.classList.toggle("d-none"); // Toggles the visibility
                }
            });
        });
    });


    function updatePriceInputs(value) {
        const [min, max] = value.split(';');
        document.getElementById('min_price').value = min;
        document.getElementById('max_price').value = max;
    }
</script>

