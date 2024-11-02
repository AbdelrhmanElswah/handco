<!-- Message Form -->
<div class="widget widget_contact bg-white border p-30 shadow-one rounded mb-30">
    <h5 class="mb-2">Book Property</h5>
    <div class="media mb-3">
        <div class="media-body">
            Phone Number: <a href="tel:+971559202016">+971 55 920 2016</a>
            <br>
            Email: <a href="mailto:info@handcoproperties.com">info@handcoproperties.com</a>
        </div>
    </div>
    <form class="quick-search form-icon-right" action="#" method="post">
        <div class="form-row">
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" name="name" placeholder="Your Name">
                </div>
            </div>
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                </div>
            </div>
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <input type="email" class="form-control" name="email" placeholder="Your Email">
                </div>
            </div>
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <textarea class="form-control" name="message" placeholder="Message" rows="10"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-0">
                    <button class="btn btn-primary w-100">Send Message</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!--============== Recent Property Widget Start ==============-->
<div class="widget widget_recent_property">
    <h5 class="text-secondary mb-4">Recent Projects</h5>
    <ul>
        <li>
            <img src="{{ url('/') }}/assets/images/thumbnaillist/01.jpg" alt="">
            <div class="thumb-body">
                <h6 class="listing-title"><a href="property-single-1.html">Nirala Appartment</a></h6>
                <span class="listing-price">$3200<small>( Monthly )</small></span>
                <ul class="d-flex quantity font-fifteen">
                    <li title="Area"><span><i class="fa-solid fa-vector-square"></i></span>6500 Sqft</li>

                </ul>
            </div>
        </li>
        <li>
            <img src="{{ url('/') }}/assets/images/thumbnaillist/02.jpg" alt="">
            <div class="thumb-body">
                <h6 class="listing-title"><a href="property-single-1.html">Condo House</a></h6>
                <span class="listing-price">$11500<small>( Monthly )</small></span>
                <ul class="d-flex quantity font-fifteen">
                    <li title="Area"><span><i class="fa-solid fa-vector-square"></i></span>2200 Sqft</li>
                </ul>
            </div>
        </li>
        <li>
            <img src="{{ url('/') }}/assets/images/thumbnaillist/03.jpg" alt="">
            <div class="thumb-body">
                <h6 class="listing-title"><a href="property-single-1.html">Luxury Condos</a></h6>
                <span class="listing-price">$17000<small>( Monthly )</small></span>
                <ul class="d-flex quantity font-fifteen">
                    <li title="Area"><span><i class="fa-solid fa-vector-square"></i></span>3500 Sqft</li>
                </ul>
            </div>
        </li>
        <li>
            <img src="{{ url('/') }}/assets/images/thumbnaillist/04.jpg" alt="">
            <div class="thumb-body">
                <h6 class="listing-title"><a href="property-single-1.html">Small Appartment</a></h6>
                <span class="listing-price">$5200<small>( Monthly )</small></span>
                <ul class="d-flex quantity font-fifteen">
                    <li title="Area"><span><i class="fa-solid fa-vector-square"></i></span>1200 Sqft</li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<!--============== Recent Property Widget End ==============-->
