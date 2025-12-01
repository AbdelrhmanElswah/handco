<!--============== Register Section Start ==============-->
<div class="full-row bg-primary py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <h3 class="text-white xs-text-center my-20 font-400">Discover your next opportunity in real estate</h3>
            </div>
            <div class="col-lg-3 col-md-4">
                <a href="{{route('contact')}}" class="btn btn-white y-center position-relative d-table xs-mx-auto ms-auto">Contact Us</a>
            </div>
        </div>
    </div>
</div>
<!--============== Register Section End ==============-->

<footer class="full-row footer-default-dark bg-footer" style="padding-bottom: 30px">
    <div class="container">
        <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1">
            <div class="col">
                <div class="footer-widget mb-4">
                    <div class="footer-logo">
                        <a href="#"><img src="{{ asset('assets/images/logo/logo-light.png') }}" alt="Image not found!"/></a>
                    </div>
                </div>
                <p style="margin-top: 40px">
                    H&Co Properties is a Dubai-based real estate company, offering expert guidance on buying, selling, and
                    investing in premium properties across the UAE.
                </p>
                <div class="footer-widget media-widget mb-4">
                    @if(isset($socialLinksSection) && $socialLinksSection && $socialLinksSection->is_active && !empty($socialLinksSection->social_links))
                        @foreach($socialLinksSection->social_links as $s)
                            @php
                                $url = $s['url'] ?? '#';
                                $platform = strtolower($s['platform'] ?? '');
                                $platformName = $s['platform'] ?? 'Social Link';
                                
                                // Determine correct icon based on platform name or URL
                                $iconClass = 'fab fa-link'; // default
                                
                                if (stripos($platform, 'instagram') !== false || stripos($url, 'instagram.com') !== false) {
                                    $iconClass = 'fab fa-instagram';
                                } elseif (stripos($platform, 'linkedin') !== false || stripos($url, 'linkedin.com') !== false) {
                                    $iconClass = 'fab fa-linkedin-in';
                                } elseif (stripos($platform, 'facebook') !== false || stripos($url, 'facebook.com') !== false) {
                                    $iconClass = 'fab fa-facebook-f';
                                } elseif (stripos($platform, 'twitter') !== false || stripos($url, 'twitter.com') !== false || stripos($url, 'x.com') !== false) {
                                    $iconClass = 'fab fa-twitter';
                                } elseif (stripos($platform, 'tiktok') !== false || stripos($url, 'tiktok.com') !== false) {
                                    $iconClass = 'fab fa-tiktok';
                                } elseif (stripos($platform, 'google') !== false || stripos($url, 'google.com') !== false || stripos($url, 'share.google') !== false) {
                                    $iconClass = 'fab fa-google';
                                } elseif (stripos($platform, 'youtube') !== false || stripos($url, 'youtube.com') !== false) {
                                    $iconClass = 'fab fa-youtube';
                                } elseif (stripos($platform, 'pinterest') !== false || stripos($url, 'pinterest.com') !== false) {
                                    $iconClass = 'fab fa-pinterest-p';
                                } elseif (stripos($platform, 'whatsapp') !== false || stripos($url, 'wa.me') !== false || stripos($url, 'whatsapp.com') !== false) {
                                    $iconClass = 'fab fa-whatsapp';
                                } elseif (!empty($s['icon_class']) && stripos($s['icon_class'], 'fa-') !== false) {
                                    // Use provided icon if it's a valid Font Awesome class
                                    $iconClass = $s['icon_class'];
                                }
                            @endphp
                            @if(!empty($url) && $url !== '#' && filter_var($url, FILTER_VALIDATE_URL))
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $platformName }}" class="social-link-item">
                                    <i class="{{ $iconClass }}"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="footer-widget contact-widget mb-4">
                    <h3 class="widget-title mb-4">Contact Info</h3>
                    <ul>
                        @if(isset($contactInfoSection) && $contactInfoSection)
                            @if($contactInfoSection->contact_addresses)
                                @foreach($contactInfoSection->contact_addresses as $addr)
                                <li>
                                    <a href="#">
                                        <i class="fa fa-map-marked" aria-hidden="true"></i>
                                        {{ $addr['title'] ?? 'Address' }} : {{ $addr['content'] ?? '' }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                            @if($contactInfoSection->contact_phones)
                                @foreach($contactInfoSection->contact_phones as $ph)
                                <li>
                                    <a href="tel:{{ $ph['number'] ?? '' }}">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        {{ $ph['title'] ?? 'Phone' }} : {{ $ph['number'] ?? '' }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                            @if($contactInfoSection->contact_emails)
                                @foreach($contactInfoSection->contact_emails as $em)
                                <li>
                                    <a href="mailto:{{ $em }}">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        {{ $em }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget footer-nav mb-4">
                    <h3 class="widget-title mb-4">Essential Links</h3>
                    <ul>
                        <li><a href="{{ route('projects') }}">Properties</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Free Consultation</a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget newslatter-widget mb-4">
                    <h4 class="widget-title mb-4">Appointment</h4>
                    <p>
                        Need assistance? We’re here for you—schedule a free consultation today!
                    </p>
                    <a href="{{route('projects')}}" class="btn btn-primary w-100">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!--============== Copyright Section Start ==============-->
<div class="copyright bg-footer text-default py-4">
    <div class="container">
        <div class="row row-cols-md-2 row-cols-1">
            <div class="col">
                <span class="text-white">Copy Rights © 2025 - All Rights Reserved - Powered By <a href="https://teleoceans.com/" target="_blank">Teleoceans.com</a></span>
            </div>
            <div class="col">
                <ul class="line-menu float-end list-color-gray">
                    <li><a href="#">Privacy & Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--============== Copyright Section End ==============-->

<!-- WhatsApp Floating Icon -->
<a href="https://wa.me/+971527785359"
   class="btn btn-success rounded-circle position-fixed d-flex align-items-center justify-content-center shadow"
   style="bottom: 20px; right: 20px; width: 60px; height: 60px; z-index: 9999;"
   target="_blank">
    <i class="fab fa-whatsapp text-white" style="font-size: 24px;"></i>
</a>


