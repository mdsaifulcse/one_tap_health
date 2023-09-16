<!doctype html>
<html lang="en">

<!-- Mirrored from templates.envytheme.com/goldmedi/default/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jul 2023 17:38:49 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{asset('/client/assets/img/fav-icon-96x96.png')}}">

    @include('client.layout.css_file')

    <title> @yield('title')) </title>
</head>

<body data-bs-spy="scroll" data-bs-offset="70">
<!-- Start Preloader Area -->
<div class="preloader-area">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>
<!-- End Preloader Area -->

<!-- Dark Version Btn -->
<div class="dark-version-btn">
    <label id="switch" class="switch">
        <input type="checkbox" onchange="toggleTheme()" id="slider">
        <span class="slider round"></span>
    </label>
</div>

<!-- Start Navbar Area -->
@include('client.layout.navbar')
<!-- End Navbar Area -->

@yield('main-content')

<!-- Start Footer Area -->
@include('client.layout.footer')

@include('.client.layout.js_files')
</body>

<!-- Mirrored from templates.envytheme.com/goldmedi/default/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jul 2023 17:38:59 GMT -->
</html>