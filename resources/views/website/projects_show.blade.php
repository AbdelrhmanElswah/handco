@extends('layouts.website', [
    'title' => $project['title'],
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Page title Start ==============-->
    <div class="full-row py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-secondary fw-bold" style="font-size: 2.5rem;">{{ $project['title'] }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('projects') }}">Properties</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">{{ $project['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--============== Page title End ==============-->

    <!--============== Property Slider Start ==============-->
    <div class="full-row p-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="single-property" style="width:1200px; height:600px; margin:0 auto 30px;">

                       <!-- Main Image Slide -->
<div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
    <img src="{{ $project->mainImage->media_link ?? asset('images/default.jpg') }}"
         alt="Main Image"
         style="width: 100%; height: 100%; object-fit: cover;"
         class="ls-bg">
</div>

<!-- Additional Images Slides -->
@foreach($project->images as $image)
    <div class="ls-slide" data-ls="duration:7500; transition2d:5; kenburnszoom:in; kenburnsscale:1.2;">
        <img src="{{ $image->media_link }}"
             alt="Additional Image"
             style="width: 100%; height: 100%; object-fit: cover;"
             class="ls-bg">
    </div>
@endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--============== Property Slider End ==============-->

    <!--============== Property Details Start ==============-->
    <div class="full-row pt-30">
        <div class="container">
            <div class="row property-details-row" style="display: flex; align-items: stretch;">
                <div class="col-xl-4 order-xl-2 property-sidebar" style="display: flex; flex-direction: column;">
                    @include('website.partials.project._project_sidemenu')
                </div>

                <div class="col-xl-8 order-xl-1 property-content" style="display: flex; flex-direction: column;">
                    @include('website.partials.project._project_main_info')
                    @include('website.partials.project._project_more_info')
                    @include('website.partials.project._project_feature_info')
                </div>
            </div>
        </div>
    </div>
    <!--============== Property Details End ==============-->
    
    <style>
        @media (min-width: 1200px) {
            .property-details-row {
                align-items: stretch;
            }
            .property-sidebar,
            .property-content {
                display: flex;
                flex-direction: column;
            }
            .property-content > div:last-child {
                flex: 1;
            }
        }
    </style>
@endsection
