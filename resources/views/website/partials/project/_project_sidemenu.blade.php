<div class="widget widget_contact bg-white border p-30 shadow-one rounded mb-30">
    <h5 class="mb-2">Book Property</h5>

    <!-- Display Success or Error Messages -->
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="media mb-3">
        <div class="media-body">
            Phone Number: <a href="tel:+971559202016">+971 55 920 2016</a>
            <br>
            Email: <a href="mailto:info@handcoproperties.com">info@handcoproperties.com</a>
        </div>
    </div>
    <form class="quick-search form-icon-right" action="{{ route('booking.store') }}" method="post">
        @csrf <!-- Include CSRF token for security -->

        <!-- Hidden field for project_id to link the booking with the specific project -->
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="form-row">
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                </div>
            </div>
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" required>
                </div>
            </div>
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>
            </div>
            <div class="col-12 mb-10">
                <div class="form-group mb-0">
                    <textarea class="form-control" name="message" placeholder="Message" rows="10"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary w-100">Send Message</button>
                </div>
            </div>
        </div>
    </form>
</div>



<!--============== Recent Property Widget Start ==============-->
<!--============== Recent Property Widget Start ==============-->
<div class="widget widget_recent_property">
    <h5 class="text-secondary mb-4">Recent Projects</h5>
    <ul>
        @foreach($recentProjects as $recentProject)
            <li>
               <img src="{{ $recentProject->mainImage->media_link ?? asset('images/default.jpg') }}" alt="{{ $recentProject->title }}">

                <div class="thumb-body">
                    <h6 class="listing-title">
                        <a href="{{ route('projects.show', $recentProject->id) }}">{{ $recentProject->title }}</a>
                    </h6>
                    <span class="listing-price">AED {{ number_format($recentProject->price, 2) }}</span>
                    <ul class="d-flex quantity font-fifteen">
                        <li title="Area">
                            <span><i class="fa-solid fa-vector-square"></i></span>
                            {{ number_format($recentProject->floor_area) }} Sqft
                        </li>
                    </ul>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<!--============== Recent Property Widget End ==============-->

<!--============== Recent Property Widget End ==============-->
