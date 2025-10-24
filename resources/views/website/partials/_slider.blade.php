<div class="full-row p-0 overflow-hidden">
    <div id="slider" class="overflow-hidden" style="width:1200px; height:780px; margin:0 auto; margin-bottom: 0px;">

        @if($sliders->isNotEmpty())
            <!-- Dynamic Slides -->
            @foreach($sliders as $slider)
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{{ asset('files/sliders/main_images/' . $slider->mainImage->media) }}" class="ls-bg" alt="Slider Image"/>

                    <!-- Subtitle -->
                    <p style="font-size:20px; font-weight:400; top:320px; left:50%; text-align:center; font-family: 'Sen', sans-serif;"
                       class="ls-l ls-hide-phone text-white"
                       data-ls="offsetyin:100%; durationin:1500; delayin:500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                        {{ $slider->subtitle }}
                    </p>

                    <!-- Title -->
                    <p style="font-size:48px; font-weight:700; top:370px; left:50%; text-align:center; font-family: 'Sen', sans-serif;"
                       class="ls-l ls-hide-phone text-white"
                       data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                        {{ $slider->title }}
                    </p>

                    <!-- Description -->
                    <p style="top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;"
                       class="ls-l ls-hide-phone"
                       data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                        {{ html_entity_decode(strip_tags($slider->description)) }}
                    </p>

                    <!-- Button -->
                    <a class="ls-l ls-hide-phone" href="{{ $slider->button_link }}" target="_self"
                       data-ls="offsetyin:40; delayin:2000; clipin:0 0 100% 0; durationout:400; hover:true; hoverdurationin:300; hoveropacity:1; hoverbgcolor:#222; hovercolor:#aa8453;">
                        <p style="font-weight:500; text-align:center; cursor:pointer; padding-right:35px; padding-left:35px; font-weight:500; font-size:16px; font-family: 'Sen', sans-serif; line-height:40px; top:550px; left:50%; color:#fff; border-radius:30px; padding-top:10px; padding-bottom:10px; background:#aa8453; white-space:normal;">
                            {{ $slider->button_text }}
                        </p>
                    </a>
                </div>
            @endforeach
        @else
            <!-- Default Static Slides -->
            <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                <img width="1920" height="960" src="{{ asset('assets/images/slider/2.png') }}" class="ls-bg" alt=""/>
                <p style="font-size:20px; font-weight:400; top:320px; left:50%; font-family: 'Sen', sans-serif;"
                   class="ls-l ls-hide-phone text-white"
                   data-ls="offsetyin:100%; durationin:1500; delayin:500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                    Find Your Perfect Property in Dubai
                </p>
                <p style="font-size:48px; font-weight:700; top:370px; left:50%; font-family: 'Sen', sans-serif;"
                   class="ls-l ls-hide-phone text-white"
                   data-ls="offsetyin:100%; durationin:1500; delayin:1000; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                    Discover Dubai’s Finest Properties
                </p>
                <p style="top:450px; left:50%; text-align:center; font-weight:400; font-style:normal; text-decoration:none; width:650px; font-size:18px; color:#ffffff; line-height:30px; white-space:normal;"
                   class="ls-l ls-hide-phone"
                   data-ls="offsetyin:100%; durationin:1500; delayin:1500; clipin:0 0 100% 0; durationout:400; parallaxlevel:0;">
                    H&Co Properties offers a curated selection of over a million listings. Begin your journey to owning a property in Dubai today.
                </p>
                <a class="ls-l ls-hide-phone" href="{{ route('projects') }}" target="_self "
                   data-ls="offsetyin:40; delayin:2000; clipin:0 0 100% 0; durationout:400; hover:true; hoverdurationin:300; hoveropacity:1; hoverbgcolor:#222; hovercolor:#aa8453;">
                    <p style="font-weight:500; text-align:center; cursor:pointer; padding-right:35px; padding-left:35px; font-weight:500; font-size:16px; font-family: 'Sen', sans-serif; line-height:40px; top:550px; left:50%; color:#fff; border-radius:30px; padding-top:10px; padding-bottom:10px; background:#aa8453; white-space:normal;">
                        Preview Listing
                    </p>
                </a>
            </div>
            <!-- Add additional static slides if needed -->
        @endif

    </div>
</div>
