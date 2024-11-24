<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item {{ Request::is('projects') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('projects') }}">Properties</a>
        </li>
        <li class="nav-item {{ Request::is('featured-projects') ? 'active' : '' }}">

            <a class="nav-link" href="{{ route('featured_projects') }}">
                Hot Sale</a>
        </li>
        <li class="nav-item {{ Request::is('blogs') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('blogs') }}">Blogs</a>
        </li>
        <li class="nav-item {{ Request::is('about-us') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('about') }}">About Us</a>
        </li>
    </ul>
    <a href="{{ route('contact') }}" class="btn btn-primary add-listing-btn">Contact Us</a>
</div>
