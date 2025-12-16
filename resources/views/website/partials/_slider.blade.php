<div class="full-row p-0 overflow-hidden">
    <div id="slider" class="overflow-hidden position-relative" style="width:100%; max-width:100%; height:600px; margin:0 auto; margin-bottom: 0px;">
        <!-- Gradient Overlay for Better Text Readability -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.6) 100%); z-index: 10; pointer-events: none;"></div>

        @php
            \Log::info('Slider View - Sliders Check:', [
                'sliders_count' => $sliders->count(),
                'sliders_not_empty' => $sliders->isNotEmpty(),
            ]);
        @endphp
        @if($sliders->isNotEmpty())
            @php
                // Get the first active slider (video or image)
                $activeSlider = $sliders->first();
                $hasVideo = $activeSlider->media_type == 'video' && $activeSlider->mainVideo && $activeSlider->mainVideo->media_link;
                $hasImage = $activeSlider->mainImage && $activeSlider->mainImage->media_link;
                
                // Log active slider data
                \Log::info('Slider Content Overlay - Active Slider Data:', [
                    'slider_id' => $activeSlider->id,
                    'title' => $activeSlider->title,
                    'subtitle' => $activeSlider->subtitle,
                    'description' => $activeSlider->description,
                    'button_text' => $activeSlider->button_text,
                    'button_link' => $activeSlider->button_link,
                    'has_title' => !empty($activeSlider->title),
                    'has_subtitle' => !empty($activeSlider->subtitle),
                    'has_description' => !empty($activeSlider->description),
                    'has_button' => !empty($activeSlider->button_text) && !empty($activeSlider->button_link),
                    'should_display_overlay' => !empty($activeSlider->title) || !empty($activeSlider->subtitle) || !empty($activeSlider->description) || (!empty($activeSlider->button_text) && !empty($activeSlider->button_link)),
                ]);
                
                // Separate videos and images for LayerSlider
                $videoSliders = $sliders->filter(function($slider) {
                    return $slider->media_type == 'video' && $slider->mainVideo && $slider->mainVideo->media_link;
                });
                $imageSliders = $sliders->filter(function($slider) {
                    return ($slider->media_type != 'video' || !$slider->mainVideo) && $slider->mainImage && $slider->mainImage->media_link;
                });
            @endphp
            
            @if($videoSliders->isNotEmpty())
                <!-- Video Slider (Display directly without LayerSlider) -->
                @foreach($videoSliders as $slider)
                    <div class="video-slider-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; overflow: hidden;">
                        <video 
                            id="slider-video-{{ $slider->id }}"
                            class="slider-video-fullwidth"
                            autoplay 
                            muted 
                            loop 
                            playsinline
                            preload="auto"
                            style="width: 100%; height: 100%; object-fit: cover; background-color: #000; min-width: 100%; min-height: 100%;">
                            <source src="{{ $slider->mainVideo->media_link }}" type="video/mp4">
                            <source src="{{ $slider->mainVideo->media_link }}" type="video/webm">
                            <source src="{{ $slider->mainVideo->media_link }}" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endforeach
            @endif
            
            @if($imageSliders->isNotEmpty())
                <!-- Image Slider (Use LayerSlider) -->
                @foreach($imageSliders as $slider)
                    <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                        <img width="1920" height="960" src="{{ $slider->mainImage->media_link }}" class="ls-bg" alt="Slider Image"/>
                    </div>
                @endforeach
            @endif
            
            @if($videoSliders->isEmpty() && $imageSliders->isEmpty())
                <!-- Default Static Slides -->
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{{ asset('assets/images/slider/2.png') }}" class="ls-bg" alt=""/>
                </div>
            @endif
            
            <!-- Slider Content Overlay (Title, Subtitle, Description, Button) -->
            @php
                $hasContent = $activeSlider && ($activeSlider->title || $activeSlider->subtitle || $activeSlider->description || ($activeSlider->button_text && $activeSlider->button_link));
                \Log::info('Slider Content Overlay - Check:', [
                    'activeSlider_exists' => $activeSlider ? true : false,
                    'has_title' => $activeSlider ? !empty($activeSlider->title) : false,
                    'has_subtitle' => $activeSlider ? !empty($activeSlider->subtitle) : false,
                    'has_description' => $activeSlider ? !empty($activeSlider->description) : false,
                    'has_button' => $activeSlider ? (!empty($activeSlider->button_text) && !empty($activeSlider->button_link)) : false,
                    'will_display_overlay' => $hasContent,
                ]);
            @endphp
            @if($hasContent)
                @php
                    \Log::info('Slider Content Overlay - Rendering Overlay', [
                        'slider_id' => $activeSlider->id,
                    ]);
                @endphp
                <div class="slider-content-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 100 !important; display: flex !important; align-items: center !important; justify-content: center !important; pointer-events: none !important;">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-9">
                                <div class="slider-text-content" style="text-align: center; color: white; padding: 40px 20px; margin-bottom: 250px;">
                                    @if($activeSlider->subtitle)
                                        @php \Log::info('Slider Content - Rendering Subtitle', ['subtitle' => $activeSlider->subtitle]); @endphp
                                        <p class="slider-subtitle mb-3" style="font-size: 1.2rem; font-weight: 500; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8); color: #aa8453;">
                                            {{ $activeSlider->subtitle }}
                                        </p>
                                    @endif
                                    @if($activeSlider->title)
                                        @php \Log::info('Slider Content - Rendering Title', ['title' => $activeSlider->title]); @endphp
                                        <h1 class="slider-title mb-4" style="font-size: 3rem; font-weight: 700; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.9); line-height: 1.2;">
                                            {{ $activeSlider->title }}
                                        </h1>
                                    @endif
                                    @if($activeSlider->description)
                                        @php \Log::info('Slider Content - Rendering Description', ['description' => substr($activeSlider->description, 0, 50) . '...']); @endphp
                                        <p class="slider-description mb-4" style="font-size: 1.1rem; line-height: 1.6; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8); max-width: 800px; margin-left: auto; margin-right: auto;">
                                            {{ $activeSlider->description }}
                                        </p>
                                    @endif
                                    @if($activeSlider->button_text && $activeSlider->button_link)
                                        @php \Log::info('Slider Content - Rendering Button', ['button_text' => $activeSlider->button_text, 'button_link' => $activeSlider->button_link]); @endphp
                                        <a href="{{ $activeSlider->button_link }}" class="btn slider-button" style="background-color: #aa8453; color: white; padding: 15px 40px; font-size: 1.1rem; font-weight: 600; border: none; border-radius: 5px; text-decoration: none; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5); pointer-events: auto; display: inline-block;">
                                            {{ $activeSlider->button_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @php
                    \Log::warning('Slider Content Overlay - NOT Rendering', [
                        'activeSlider_exists' => $activeSlider ? true : false,
                        'reason' => 'No content to display',
                    ]);
                @endphp
            @endif
        @else
            <!-- Default Static Slides -->
            <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                <img width="1920" height="960" src="{{ asset('assets/images/slider/2.png') }}" class="ls-bg" alt=""/>
            </div>
            <!-- Add additional static slides if needed -->
        @endif

    </div>
</div>
