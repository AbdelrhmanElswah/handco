@extends('layouts.website', [
    'title' => 'Privacy & Policy',
    'headerType' => '_header_pages',
    'bg' => 'bg-light'
])

@section('content')
    <!--============== Privacy & Policy Section Start ==============-->
    @if($privacySection && $privacySection->is_active)
    <div class="full-row bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="privacy-content">
                        @if($privacySection->title)
                        <h1 class="text-secondary mb-4 fw-bold" style="font-size: 2.5rem;">
                            {{ $privacySection->title }}
                        </h1>
                        @endif
                        @if($privacySection->subtitle)
                        <p class="text-primary mb-4 font-medium" style="font-size: 1.2rem;">
                            {{ $privacySection->subtitle }}
                        </p>
                        @endif
                        @if($privacySection->content)
                        <div class="content-text">
                            {!! $privacySection->content !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!--============== Privacy & Policy Section End ==============-->
@endsection
