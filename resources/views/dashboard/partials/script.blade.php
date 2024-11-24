
<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>

<!-- Popper JS -->
<script src="{{asset('dashboard/assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>

<!-- Bootstrap JS -->
<script src="{{asset('dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Defaultmenu JS -->
<script src="{{asset('dashboard/assets/js/defaultmenu.min.js')}}"></script>

<!-- Node Waves JS-->
<script src="{{asset('dashboard/assets/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('dashboard/assets/libs/prismjs/prism.js')}}"></script>
<script src="{{asset('dashboard/assets/js/prism-custom.js')}}"></script>
<!-- Sticky JS -->
<script src="{{asset('dashboard/assets/js/sticky.js')}}"></script>

<!-- Simplebar JS -->
<script src="{{asset('dashboard/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/simplebar.js')}}"></script>

<!-- Color Picker JS -->
<script src="{{asset('dashboard/assets/libs/@simonwep/pickr/pickr.es5.min.js')}}"></script>


<!-- JSVector Maps JS -->
<script src="{{asset('dashboard/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>

<!-- JSVector Maps MapsJS -->
<script src="{{asset('dashboard/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

<!-- Apex Charts JS -->
<script src="{{asset('dashboard/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- Chartjs Chart JS -->
<script src="{{asset('dashboard/assets/libs/chart.js/chart.min.js')}}"></script>

<!-- CRM-Dashboard -->
<script src="{{asset('dashboard/assets/js/crm-dashboard.js')}}"></script>


<!-- Custom-Switcher JS -->
<script src="{{asset('dashboard/assets/js/custom-switcher.min.js')}}"></script>

<!-- Custom JS -->
<script src="{{asset('dashboard/assets/js/custom.js')}}"></script>

<script src="{{asset('dashboard/assets/js/blog-create.js')}}"></script>


<script src="{{asset('dashboard/assets/js/custom-switcher.min.js')}}"></script>

<script src="{{asset('dashboard/assets/libs/filepond/filepond.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js')}}"></script>


<!-- Popper JS -->
<script src="{{asset('dashboard/assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>

<!-- Bootstrap JS -->
<script src="{{asset('dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Defaultmenu JS -->
<script src="{{asset('dashboard/assets/js/defaultmenu.min.js')}}"></script>

<!-- Node Waves JS-->
<script src="{{asset('dashboard/assets/libs/node-waves/waves.min.js')}}"></script>

<!-- Sticky JS -->
<script src="{{asset('dashboard/assets/js/sticky.js')}}"></script>

<!-- Simplebar JS -->
<script src="{{asset('dashboard/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('dashboard/assets/js/simplebar.js')}}"></script>

<!-- Color Picker JS -->
<script src="{{asset('dashboard/assets/libs/@simonwep/pickr/pickr.es5.min.js')}}"></script>

<script src="{{asset('dashboard/assets/js/apexcharts-line.js')}}"></script>



<!-- Date & Time Picker JS -->
<script src="{{asset('dashboard/assets/libs/flatpickr/flatpickr.min.js')}}"></script>

<!-- Quill Editor JS -->
<script src="{{asset('dashboard/assets/libs/quill/quill.min.js')}}"></script>

<script src="{{asset('dashboard/assets/js/todolist.js')}}"></script>

<script>
    CKEDITOR.replace('details', {
        removePlugins: 'uploadimage',
        on: {
            instanceReady: function(ev) {
                ev.editor.showNotification = function() { return false; };
            }
        }
    });

    CKEDITOR.replace('description', {
        removePlugins: 'uploadimage',
        on: {
            instanceReady: function(ev) {
                ev.editor.showNotification = function() { return false; };
            }
        }
    });


    CKEDITOR.replace('content', {
        removePlugins: 'uploadimage',
        on: {
            instanceReady: function(ev) {
                ev.editor.showNotification = function() { return false; };
            }
        }
    });
</script>


@stack('script')

