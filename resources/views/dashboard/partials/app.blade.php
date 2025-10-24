<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">

@include('dashboard.partials.style')

<body>

@include('dashboard.partials.switcher')

<div class="page">
   @include('dashboard.partials.nav-bar')

    @include('dashboard.partials.side-bar')

   @yield('content')

    @include('dashboard.partials.footer')


</div>

@include('dashboard.partials.script')
</body>

</html>
