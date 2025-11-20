@extends('layouts.website', [
    'title' => 'About Us',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page Banner Start ==============-->
    @if($aboutPageBanner && $aboutPageBanner->is_active)
    <div class="page-banner-simple bg-light py-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    @if($aboutPageBanner->title)
                    <h3 class="banner-title">{{ $aboutPageBanner->title }}</h3>
                    @endif
                    @if($aboutPageBanner->subtitle)
                    <span class="banner-tagline font-medium">
                        {{ $aboutPageBanner->subtitle }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Page Banner End ==============-->

    <!--============== Banner Start ==============-->
    @if($aboutHeroBanner && $aboutHeroBanner->is_active)
    <div class="full-row paraxify position-relative" style="background-image: url({{ $aboutHeroBanner->backgroundImage ? $aboutHeroBanner->backgroundImage->media_link : asset('assets/images/bg-4.jpg') }}); background-repeat: no-repeat; background-position: center center; background-size: cover;">
        <!-- Gradient Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%); z-index: 1;"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="text-white">
                        @if($aboutHeroBanner->subtitle)
                        <span class="tagline text-primary"
                              style="text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 15px rgba(0, 0, 0, 0.6); font-weight: 600;">{{ $aboutHeroBanner->subtitle }}</span>
                        @endif
                        @if($aboutHeroBanner->title)
                        <h3 class="mb-4 text-white" style="text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.9), 0 0 20px rgba(0, 0, 0, 0.7); font-weight: 700;">
                            {{ $aboutHeroBanner->title }}
                        </h3>
                        @endif
                        @if($aboutHeroBanner->content)
                        <div style="text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.8), 0 0 12px rgba(0, 0, 0, 0.6);">
                            {!! $aboutHeroBanner->content !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Banner End ==============-->


    <!--============== Partners Start ==============-->
    @if($aboutPartners && $aboutPartners->is_active)
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="md-mb-30">
                        @if($aboutPartners->subtitle)
                        <span class="tagline-2 text-primary">{{ $aboutPartners->subtitle }}</span>
                        @endif
                        @if($aboutPartners->title)
                        <h2 class="text-secondary mb-0">{{ $aboutPartners->title }}</h2>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    @if($aboutPartners->list_items && count($aboutPartners->list_items) > 0)
                    <div class="row row-cols-md-4 row-cols-sm-2 row-cols-2 g-4 ">
                        @foreach($aboutPartners->list_items as $index => $partnerImage)
                        <div class="col">
                            <a href="#" class="hover-img-upshow overflow-hidden pe-5 d-block">
                                <img src="{{ $partnerImage }}" alt="partner logo" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Partners End ==============-->


    <!--============== Accordian Start ==============-->
    @if($missionVisionSection && $missionVisionSection->is_active)
    <div class="full-row bg-light pb-0">
        <div class="container-fluid">
            <div class="row row-cols-xl-2 row-cols-1">
                <div class="col px-0">
                    <img src="{{ $missionVisionSection->backgroundImage ? $missionVisionSection->backgroundImage->media_link : asset('assets/images/about-bg.jpg') }}" alt="image not found" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="col bg-white" style="margin-top: -100px;">
                    <div class="w-75 w-lg-100 sm-px-0" style="padding:50px 80px">
                        @if($missionVisionSection->title)
                        <h2 class="text-secondary mb-5">
                            {{ $missionVisionSection->title }}
                        </h2>
                        @endif
                        @if($missionVisionSection->accordion_items && count($missionVisionSection->accordion_items) > 0)
                        <div class="bb-accordion ac-single-show accordion-plus-left">
                            @foreach($missionVisionSection->accordion_items as $index => $item)
                            <div class="ac-card">
                                <a class="ac-toggle text-dark text-truncate {{ ($item['is_active'] ?? false) ? 'active' : '' }}" href="#">
                                    {{ $item['title'] ?? '' }}
                                </a>
                                <div class="ac-collapse {{ ($item['is_active'] ?? false) ? 'show' : '' }}" @if($item['is_active'] ?? false) style="display: block;" @endif>
                                    <div>
                                        {!! $item['content'] ?? '' !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Accordian End ==============-->
@endsection
