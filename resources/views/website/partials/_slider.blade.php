<div class="full-row p-0 overflow-hidden">
    <div id="slider" class="overflow-hidden position-relative" style="width:1200px; height:780px; margin:0 auto; margin-bottom: 0px;">
        <!-- Gradient Overlay for Better Text Readability -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.6) 100%); z-index: 10; pointer-events: none;"></div>

        @if($sliders->isNotEmpty())
            <!-- Dynamic Slides -->
            @foreach($sliders as $slider)
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{{ asset('files/sliders/main_images/' . $slider->mainImage->media) }}" class="ls-bg" alt="Slider Image"/>

                    <!-- Subtitle -->
                    <p style="font-size:20px; font-weight:400; top:320px; left:50%; text-align:center; font-family: 'Sen', sans-serif; text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.95), 0 0 15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 0, 0, 0.6); z-index: 20; position: relative;"
                       class="ls-l ls-hide-phone text-white"
                       data-ls="offsetyin:100%; durationin:1500; delayin:500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                        {{ $slider->subtitle }}
                    </p>

                    <!-- Title -->
                    <p style="font-size:48px; font-weight:700; top:370px; left:50%; text-align:center; font-family: 'Sen', sans-serif; text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.95), 0 0 15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 0, 0, 0.6); z-index: 20; position: relative;"
                       class="ls-l ls-hide-phone text-white"
                       data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                        {{ $slider->title }}
                    </p>

                    <!-- Description -->
                    <p style="top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal; text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.95), 0 0 15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 0, 0, 0.6); z-index: 20; position: relative;"
                       class="ls-l ls-hide-phone"
                       data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                        {{ html_entity_decode(strip_tags($slider->description)) }}
                    </p>

                    <!-- Button -->
                    <a class="ls-l ls-hide-phone" href="{{ $slider->button_link }}" target="_self" style="z-index: 20; position: relative;"
                       data-ls="offsetyin:40; delayin:2000; clipin:0 0 100% 0; durationout:400; hover:true; hoverdurationin:300; hoveropacity:1; hoverbgcolor:#222; hovercolor:#aa8453;">
                        <p style="font-weight:500; text-align:center; cursor:pointer; padding-right:35px; padding-left:35px; font-weight:500; font-size:16px; font-family: 'Sen', sans-serif; line-height:40px; top:550px; left:50%; color:#fff; border-radius:30px; padding-top:10px; padding-bottom:10px; background:#aa8453; white-space:nowrap; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                            {{ $slider->button_text }}
                        </p>
                    </a>
                </div>
            @endforeach
        @else
            <!-- Default Static Slides -->
            <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                <img width="1920" height="960" src="{{ asset('assets/images/slider/2.png') }}" class="ls-bg" alt=""/>
                <p style="font-size:20px; font-weight:400; top:320px; left:50%; font-family: 'Sen', sans-serif; text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.95), 0 0 15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 0, 0, 0.6); z-index: 20; position: relative;"
                   class="ls-l ls-hide-phone text-white"
                   data-ls="offsetyin:100%; durationin:1500; delayin:500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                    Find Your Perfect Property in Dubai
                </p>
                <p style="font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif; text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.95), 0 0 15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 0, 0, 0.6); z-index: 20; position: relative;"
                   class="ls-l ls-hide-phone text-white"
                   data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                    Discover Dubai's Finest Properties
                </p>
                <p style="top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal; text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.95), 0 0 15px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 0, 0, 0.6); z-index: 20; position: relative;"
                   class="ls-l ls-hide-phone"
                   data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                    H&Co Properties offers a curated selection of over a million listings. Begin your journey to owning a property in Dubai today.
                </p>
                <a class="ls-l ls-hide-phone" href="{{ route('projects') }}" target="_self" style="z-index: 20; position: relative;"
                   data-ls="offsetyin:40; delayin:2000; clipin:0 0 100% 0; durationout:400; hover:true; hoverdurationin:300; hoveropacity:1; hoverbgcolor:#222; hovercolor:#aa8453;">
                    <p style="font-weight:500; text-align:center; cursor:pointer; padding-right:35px; padding-left:35px; font-weight:500; font-size:16px; font-family: 'Sen', sans-serif; line-height:40px; top:550px; left:50%; color:#fff; border-radius:30px; padding-top:10px; padding-bottom:10px; background:#aa8453; white-space:nowrap; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);">
                        Preview Listing
                    </p>
                </a>
            </div>
            <!-- Add additional static slides if needed -->
        @endif

    </div>
</div>
