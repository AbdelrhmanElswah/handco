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
        height: 840,
        skinsPath: '{{ asset('assets/skins/') }}'
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
