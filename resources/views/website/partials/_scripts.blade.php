<!-- Javascript Files -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/greensock.js') }}"></script>
<script src="{{ asset('assets/js/layerslider.transitions.js') }}"></script>
<script src="{{ asset('assets/js/layerslider.kreaturamedia.jquery.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.js') }}"></script>
<script src="{{ asset('assets/js/range/tmpl.js') }}"></script>
<script src="{{ asset('assets/js/range/jquery.dependClass.js') }}"></script>
<script src="{{ asset('assets/js/range/draggable.js') }}"></script>
<script src="{{ asset('assets/js/range/jquery.slider.js') }}"></script>
<script src="{{ asset('assets/js/wow.js') }}"></script>
<script src="{{ asset('assets/js/mixitup.min.js') }}"></script>
<script src="{{ asset('assets/js/paraxify.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>
    $(document).ready(function() {
        console.log('Slider Initialization - Starting...');
        console.log('Slider Element Found:', $('#slider').length > 0);
        console.log('Slider Slides Found:', $('#slider .ls-slide').length);
        console.log('Video Sliders Found:', $('.video-slider-container').length);
        console.log('Slider Images Found:', $('#slider img.ls-bg').length);
        
        // Handle video sliders separately (outside LayerSlider)
        $('.video-slider-container video').each(function(index) {
            var video = this;
            var $video = $(video);
            var sources = [];
            $video.find('source').each(function() {
                sources.push($(this).attr('src'));
            });
            console.log('Video ' + index + ' sources:', sources);
            
            // Force play video
            video.play().then(function() {
                console.log('Video ' + index + ' play() succeeded');
            }).catch(function(error) {
                console.error('Video ' + index + ' play() failed:', error);
            });
        });
        
        // Only initialize LayerSlider if there are image slides
        if ($('#slider .ls-slide').length > 0) {
            // Disable all slider animations permanently
            $('#slider .ls-l[data-ls]').each(function() {
                $(this).removeAttr('data-ls');
            });
            
            $('#slider').layerSlider({
                sliderVersion: '6.0.0',
                type: 'fullwidth',
                responsiveUnder: 0,
                maxRatio: 1,
                slideBGSize: 'auto',
                hideUnder: 0,
                hideOver: 100000,
                skin: 'outline',
                fitScreenWidth: true,
                fullSizeMode: 'fitheight',
                navButtons: false,
                navStartStop: false,
                height: 500,
                skinsPath: '{{ asset('assets/skins/') }}',
                onSliderLoad: function() {
                    console.log('LayerSlider Loaded Successfully');
                    console.log('Total Slides:', this.slides.length);
                },
                onSlideChangeStart: function(data) {
                    console.log('Slide Changed:', data);
                }
            });
        } else {
            console.log('No image slides found, skipping LayerSlider initialization');
        }
    });
</script>

<script>
    $('#single-property').layerSlider({
        sliderVersion: '6.5.0b2',
        type: 'popup',
        pauseOnHover: 'disabled',
        skin: 'photogallery',
        globalBGSize: 'cover',
        navStartStop: false,
        hoverBottomNav: true,
        showCircleTimer: false,
        thumbnailNavigation: 'always',
        tnContainerWidth: '100%',
        tnHeight: 70,
        popupShowOnTimeout: 1,
        popupShowOnce: false,
        popupCloseButtonStyle: 'background: rgba(0,0,0,.5); border-radius: 2px; border: 0; left: auto; right: 10px;',
        popupResetOnClose: 'disabled',
        popupDistanceLeft: 20,
        popupDistanceRight: 20,
        popupDistanceTop: 20,
        popupDistanceBottom: 20,
        popupDurationIn: 750,
        popupDelayIn: 500,
        popupTransitionIn: 'scalefromtop',
        popupTransitionOut: 'scaletobottom',
        skinsPath: '{{ url('/') }}/assets/skins/'
    });

</script>
