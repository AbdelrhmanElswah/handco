<div class="full-row p-0 overflow-hidden">
    <div id="slider" class="overflow-hidden position-relative" style="width:1200px; height:600px; margin:0 auto; margin-bottom: 0px;">
        <!-- Gradient Overlay for Better Text Readability -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.6) 100%); z-index: 10; pointer-events: none;"></div>

        @if($sliders->isNotEmpty())
            <!-- Dynamic Slides -->
            @foreach($sliders as $slider)
                <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                    <img width="1920" height="960" src="{{ $slider->mainImage->media_link }}" class="ls-bg" alt="Slider Image"/>
                </div>
            @endforeach
        @else
            <!-- Default Static Slides -->
            <div class="ls-slide" data-ls="bgsize:cover; bgposition:50% 50%; duration:12000; transition2d:104; kenburnsscale:1.00;">
                <img width="1920" height="960" src="{{ asset('assets/images/slider/2.png') }}" class="ls-bg" alt=""/>
            </div>
            <!-- Add additional static slides if needed -->
        @endif

    </div>
</div>
