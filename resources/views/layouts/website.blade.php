<!doctype html>
<html lang="en">

<head>
    <title>H&Co Properties | {{ $title }}</title>
    @include('website.partials._head')
</head>

<body>

<div class="preloader">
    <div class="loader xy-center"></div>
</div>

<div id="page_wrapper" class="{{ $bg }}">
    <!--============== Header Section Start ==============-->
    @if ($headerType == '_header')
        @include('website.partials._header')
    @elseif ($headerType == '_header_pages')
        @include('website.partials._header_pages')
    @endif
    <!--============== Header Section End ==============-->

    @yield('content')

    <!--============== Footer Section Start ==============-->
    @include('website.partials._footer')
    <!--============== Footer Section End ==============-->

    @isset($popularProjects)
    @include('website.partials._modal')
    @endisset

</div>

@include('website.partials._scripts')
</body>
</html>
