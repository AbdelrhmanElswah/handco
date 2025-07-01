@extends('layouts.website', [
    'title' => 'About Us',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page Banner Start ==============-->
    <div class="page-banner-simple bg-light py-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="banner-title">Who We Are</h3>
                    <span class="banner-tagline font-medium">
                        Discover H C O Real Estate: Our Mission and Vision
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--============== Page Banner End ==============-->

    <!--============== Banner Start ==============-->
    <div class="full-row paraxify" style="background-image: url(assets/images/bg-4.jpg); background-repeat: no-repeat; background-position: center center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="text-white">
                        <span class="tagline text-primary"
                              style="text-shadow: 2px 2px rgba(0, 0, 0, 0.4)">Empowering Your Real Estate Journey</span>
                        <h3 class="mb-4 text-white">
                            Welcome to H C O Real Estate, where we believe in empowering individuals and families through exceptional real estate services.
                        </h3>
                        <p>
                            At H C O Real Estate, we are more than just a real estate agency—we are a team driven by a mission to
                            empower individuals and families to achieve their dreams of finding the perfect home. With a focus on
                            integrity, transparency, and a client-first approach, we are dedicated to making the process of buying,
                            selling, and leasing as smooth and fulfilling as possible. Our clients are at the core of everything we do,
                            and we strive to turn real estate transactions into meaningful experiences that enhance lives.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Banner End ==============-->


    <!--============== Agents Start ==============-->
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="md-mb-30">
                        <span class="tagline-2 text-primary">Our Partners</span>
                        <h2 class="text-secondary mb-0">Trusted Allies</h2>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row row-cols-md-4 row-cols-sm-2 row-cols-2 g-4 ">
                        <div class="col">
                            <a href="#" class="hover-img-upshow overflow-hidden pe-5 d-block">
                                <img src="assets/images/partner/oh_logo_01-min.png" alt="creative template">
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="hover-img-upshow overflow-hidden pe-5 d-block">
                                <img src="assets/images/partner/oh_logo_02-min.png" alt="creative template">
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="hover-img-upshow overflow-hidden pe-5 d-block">
                                <img src="assets/images/partner/oh_logo_03-min.png" alt="creative template">
                            </a>
                        </div>
                        <div class="col">
                            <a href="#" class="hover-img-upshow overflow-hidden pe-5 d-block">
                                <img src="assets/images/partner/oh_logo_04-min.png" alt="creative template">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Agents End ==============-->


    <!--============== Accordian Start ==============-->
    <div class="full-row bg-light pb-0">
        <div class="container-fluid">
            <div class="row row-cols-xl-2 row-cols-1">
                <div class="col px-0"><img src="assets/images/about-bg.jpg" alt="image not found"></div>
                <div class="col bg-white" style="margin-top: -100px;">
                    <div class="w-75 w-lg-100 sm-px-0" style="padding:50px 80px">
                        <h2 class="text-secondary mb-5">
                            Our Mission & Vision: Guiding Every Step of Your Journey
                        </h2>
                        <div class="bb-accordion ac-single-show accordion-plus-left">
                            <div class="ac-card">
                                <a class="ac-toggle text-dark text-truncate active" href="#">Our Mission</a>
                                <div class="ac-collapse show" style="display: block;">
                                    <p>
                                        At H C O Real Estate, our mission is to empower individuals and families by providing exceptional
                                        real estate services with integrity, transparency, and a client-first approach.
                                        We strive to simplify the buying, selling, and leasing process, ensuring our clients
                                        find not just properties, but homes that inspire and enrich their lives.
                                    </p>
                                </div>
                            </div>
                            <div class="ac-card">
                                <a class="ac-toggle text-dark text-truncate" href="#">Our Vision</a>
                                <div class="ac-collapse">
                                    <p>
                                        Our vision is to be a trusted leader in the real estate industry, recognized for our
                                        commitment to excellence and innovation. We aim to create lasting relationships with our
                                        clients and communities, transforming the real estate experience through personalized service
                                        and cutting-edge technology. Ultimately, we envision a future where everyone can find their
                                        perfect space to thrive.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Accordian End ==============-->
@endsection
