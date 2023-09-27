@extends('client.layout.app')
@section('title')
    Home - One Tap Health
@endsection

@section('main-content')
    <!-- Start Main Banner Area -->
    <div id="home" class="main-banner-three bg-f9faff">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="hero-slides owl-carousel owl-theme">
                                <div class="hero-content">
                                    <img src="{{asset('/client/')}}/assets/img/logo/theme.jpeg" alt="logo">
                                    {{--<a href="#" class="btn">Appointment Now</a>--}}
                                </div>


                                <div class="hero-content">
                                    <h1>Providing Quality Health Care. Your Health is Our Top Priority with <span>Comprehensive</span></h1>
                                    <p>
                                        Welcome to One Tap Health, where your well-being is our top priority. Our dedicated team of healthcare professionals is committed to providing concerned care and Medical Services. Are you looking for a trusted and experienced doctor or a safe and hygienic pathology test place, we're here to support you with all health-related services and a journey to better health.
                                    </p>
                                    {{--<a href="#" class="btn">Appointment Now</a>--}}
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-lg-5">
                            <div class="hero-image">
                                <img src="assets/img/hero-man.png" alt="hero">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Banner Area -->

    <!-- Start Boxes Area -->
    <section class="boxes-area-two ptb-35">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="single-box">
                        <i class="icofont-ambulance-cross"></i>
                        <h3>Pathology Test</h3>
                        <p>Explore our advanced pathology tests for precise diagnostics and a deeper understanding of your health. Trust our expertise.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-box">
                        <i class="icofont-doctor"></i>
                        <h3>Qualified Doctors</h3>
                        <p>Meet our highly skilled and certified doctors dedicated to your well-being and providing exceptional healthcare based on your needs and health.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-box">
                        <i class="icofont-ambulance-cross"></i>
                        <h3>Hospital</h3>
                        <p>Discover our modern, patient-centered hospital equipped with advanced technology and dedicated staff for your health and care.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-box">
                        <i class="icofont-operation-theater"></i>
                        <h3>Medicine</h3>
                        <p>Explore a wide range of pharmaceuticals and medications, ensuring your health and well-being and managing various health conditions effectively.</p>
                    </div>
                </div>

                <!-- <div class="col-lg-3 col-md-6">
                    <div class="single-box">
                        <i class="icofont-stretcher"></i>
                        <h3>Ambulance</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!-- End Boxes Area -->

    <!-- Start Dewnload App area -->
    <section id="department" class="departments-area ptb-100 bg-f9faff">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="section-title">
                        <h3>Download and register on our app for free
                            and feel safe for all your family</h3>

                    </div>
                    <div class="mx-auto flex max-w-xs space-x-4 text-center">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.khotian.one_tap_health" class="h-auto w-48 cursor-pointer"><svg id="playstore_icon" version="1.1" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 119.7 40" xml:space="preserve" style="enable-background:new 0 0 119.7 40"><style>.st1{fill:#fff}</style><path d="M110.1 0H7.5c-.7 0-1.3.1-2 .2-.6.1-1.3.3-1.9.6C3 1.1 2.5 1.5 2 2S1.1 3 .8 3.6C.5 4.2.3 4.9.2 5.5c-.1.7-.2 1.4-.2 2v24.9c0 .7.1 1.3.2 2s.3 1.3.6 1.9c.3.7.7 1.2 1.2 1.7s1 .9 1.6 1.2c.6.3 1.2.5 1.9.6.7.1 1.3.2 2 .2h104.6c.7 0 1.3-.1 2-.2s1.3-.3 1.9-.6c.6-.3 1.1-.7 1.6-1.2s.9-1 1.2-1.6c.3-.6.5-1.2.6-1.9.1-.7.2-1.3.2-2v-25c0-.7-.1-1.3-.2-2s-.3-1.3-.6-1.9c-.6-1.2-1.6-2.2-2.8-2.8-.6-.3-1.2-.5-1.9-.6-.7-.1-1.3-.2-2-.2h-2z" style="fill:#a6a6a6"></path><path d="M8.4 39.1h-.9c-.6 0-1.3-.1-1.9-.2-.6-.1-1.1-.3-1.7-.5-.5-.3-1-.6-1.4-1-.4-.4-.8-.9-1-1.4-.3-.5-.4-1.1-.5-1.7-.1-.6-.2-1.2-.2-1.9V7.5c0-.6.1-1.3.2-1.9.1-.5.3-1.1.6-1.6s.6-1 1-1.4c.4-.4.9-.7 1.4-1 .5-.3 1.1-.4 1.7-.5C6.3 1 6.9.9 7.6.9H112.2c.6 0 1.2.1 1.9.2.6.1 1.1.3 1.7.5 1 .5 1.9 1.4 2.4 2.4.3.5.4 1.1.5 1.6.1.6.2 1.3.2 1.9v24.9c0 .6-.1 1.2-.2 1.9-.1.6-.3 1.1-.5 1.7-.3.5-.6 1-1 1.4-.4.4-.9.8-1.4 1-.5.3-1.1.5-1.7.5-.6.1-1.2.2-1.9.2H8.4z"></path><g><path id="path46" d="M60.6 21.7c-2 0-3.7 1.5-3.7 3.7 0 2.1 1.7 3.7 3.7 3.7s3.7-1.6 3.7-3.7-1.7-3.7-3.7-3.7zm0 5.9c-1.1 0-2.1-.9-2.1-2.2 0-1.3 1-2.2 2.1-2.2s2.1.9 2.1 2.2c0 1.3-1 2.2-2.1 2.2zm-8.1-5.9c-2 0-3.7 1.5-3.7 3.7 0 2.1 1.7 3.7 3.7 3.7s3.7-1.6 3.7-3.7-1.7-3.7-3.7-3.7zm0 5.9c-1.1 0-2.1-.9-2.1-2.2 0-1.3 1-2.2 2.1-2.2s2.1.9 2.1 2.2c0 1.3-1 2.2-2.1 2.2zm-9.6-4.7v1.6h3.8c-.1.9-.4 1.5-.9 2s-1.4 1.1-2.9 1.1c-2.3 0-4.1-1.8-4.1-4.1s1.8-4.1 4.1-4.1c1.3 0 2.2.5 2.8 1.1l1.1-1.1c-.9-.9-2.2-1.6-3.9-1.6-3.2 0-5.8 2.5-5.8 5.7s2.7 5.7 5.8 5.7c1.7 0 3-.6 4-1.6s1.4-2.5 1.4-3.6c0-.4 0-.7-.1-1h-5.3zm39.4 1.2c-.3-.8-1.2-2.3-3.2-2.3-1.9 0-3.5 1.5-3.5 3.7 0 2 1.6 3.7 3.7 3.7 1.7 0 2.7-1 3.1-1.6l-1.3-.8c-.4.6-1 1-1.8 1s-1.4-.4-1.8-1.1l5-2-.2-.6zm-5.1 1.2c0-1.4 1.1-2.1 1.9-2.1.6 0 1.2.3 1.4.8l-3.3 1.3zm-4 3.5h1.6V18.1h-1.6v10.7zm-2.7-6.2c-.4-.4-1.1-.8-2-.8-1.9 0-3.5 1.6-3.5 3.7s1.7 3.6 3.5 3.6c.9 0 1.6-.4 1.9-.8h.1v.5c0 1.4-.8 2.2-2 2.2-1 0-1.6-.7-1.9-1.3l-1.4.6c.4 1 1.5 2.2 3.3 2.2 1.9 0 3.5-1.1 3.5-3.8V22h-1.5v.6zm-1.8 5c-1.1 0-2.1-.9-2.1-2.2 0-1.3.9-2.2 2.1-2.2 1.1 0 2 .9 2 2.2 0 1.3-.9 2.2-2 2.2zm21.2-9.5H86v10.8h1.6v-4.1h2.3c1.8 0 3.6-1.3 3.6-3.3 0-2.1-1.8-3.4-3.6-3.4zm.1 5.2h-2.3v-3.7H90c1.2 0 1.9 1 1.9 1.8 0 .9-.7 1.9-1.9 1.9zm10-1.6c-1.2 0-2.4.5-2.9 1.6l1.4.6c.3-.6.9-.8 1.5-.8.8 0 1.7.5 1.7 1.4v.1c-.3-.2-.9-.4-1.7-.4-1.6 0-3.1.8-3.1 2.4 0 1.4 1.3 2.4 2.7 2.4 1.1 0 1.7-.5 2.1-1.1h.1v.8h1.6v-4.1c-.1-1.8-1.5-2.9-3.4-2.9zm-.2 5.9c-.5 0-1.3-.3-1.3-.9 0-.8.9-1.2 1.7-1.2.7 0 1 .2 1.5.4-.1 1-1 1.7-1.9 1.7zM109 22l-1.9 4.7h-.1l-1.9-4.7h-1.8l2.9 6.5-1.7 3.6h1.7l4.5-10.1H109zm-14.6 6.8H96V18.1h-1.6v10.7z" class="st1"></path><g id="g48"><linearGradient id="path64_00000034774710040526737200000003497721616972470150_" gradientUnits="userSpaceOnUse" x1="29.119" y1="-143.219" x2="14.545" y2="-128.646" gradientTransform="matrix(1.0024 0 0 -.9907 -8.922 -111.937)"><stop offset="0" style="stop-color:#00a0ff;"></stop><stop offset=".007" style="stop-color:#00a1ff;"></stop><stop offset=".26" style="stop-color:#00beff;"></stop><stop offset=".512" style="stop-color:#00d2ff;"></stop><stop offset=".76" style="stop-color:#00dfff;"></stop><stop offset="1" style="stop-color:#00e3ff;"></stop></linearGradient><path id="path64" d="M10.4 9.5c-.3.3-.4.7-.4 1.2v19c0 .5.1.9.4 1.2l.1.1 10.8-10.7V20L10.4 9.5z" style="fill:url(#path64_00000034774710040526737200000003497721616972470150_)"></path></g><g id="g66"><linearGradient id="path78_00000183935757029055499530000011422543414374155658_" gradientUnits="userSpaceOnUse" x1="39.57" y1="-133.414" x2="18.558" y2="-133.414" gradientTransform="matrix(1.0024 0 0 -.9907 -8.922 -111.937)"><stop offset="0" style="stop-color:#ffe000;"></stop><stop offset=".409" style="stop-color:#ffbd00;"></stop><stop offset=".775" style="stop-color:orange;"></stop><stop offset="1" style="stop-color:#ff9c00;"></stop></linearGradient><path id="path78" d="m24.8 23.9-3.6-3.6V20l3.6-3.6h.1l4.3 2.4c1.2.7 1.2 1.8 0 2.5l-4.4 2.6z" style="fill:url(#path78_00000183935757029055499530000011422543414374155658_)"></path></g><g id="g80"><linearGradient id="path88_00000001648578495057745390000001676023686686193074_" gradientUnits="userSpaceOnUse" x1="24.502" y1="-138.667" x2="4.739" y2="-118.904" gradientTransform="matrix(1.0024 0 0 -.9907 -8.922 -111.937)"><stop offset="0" style="stop-color:#ff3a44;"></stop><stop offset="1" style="stop-color:#c31162;"></stop></linearGradient><path id="path88" d="m24.9 23.9-3.7-3.6L10.4 31c.4.4 1.1.5 1.8.1l12.7-7.2" style="fill:url(#path88_00000001648578495057745390000001676023686686193074_)"></path></g><g id="g90"><linearGradient id="path104_00000156576165621196468300000004243087164845919620_" gradientUnits="userSpaceOnUse" x1="9.283" y1="-143.383" x2="18.107" y2="-134.559" gradientTransform="matrix(1.0024 0 0 -.9907 -8.922 -111.937)"><stop offset="0" style="stop-color:#32a071;"></stop><stop offset=".069" style="stop-color:#2da771;"></stop><stop offset=".476" style="stop-color:#15cf74;"></stop><stop offset=".801" style="stop-color:#06e775;"></stop><stop offset="1" style="stop-color:#00f076;"></stop></linearGradient><path id="path104" d="M24.9 16.6 12.2 9.5c-.7-.4-1.4-.4-1.8.1l10.9 10.7 3.6-3.7z" style="fill:url(#path104_00000156576165621196468300000004243087164845919620_)"></path></g><path d="M42.4 11c0 1.7-1.2 2.8-3 2.8h-1.8V8.2h1.8c1.8 0 3 1.1 3 2.8zm-3 2.1c1.3 0 2-.8 2-2 0-1.3-.7-2.1-2-2.1h-.9v4.1h.9zM45.2 13.9c-1.3 0-2.2-.9-2.2-2.3s1-2.3 2.2-2.3c1.3 0 2.2.9 2.2 2.3.1 1.4-.9 2.3-2.2 2.3zm0-.8c.7 0 1.4-.5 1.4-1.5s-.6-1.5-1.3-1.5c-.7 0-1.3.5-1.3 1.5-.1 1 .5 1.5 1.2 1.5zM47.9 9.4h.9l.9 3.5.9-3.5h1l.9 3.5.9-3.5h.9l-1.4 4.4h-1l-.9-3.3-.9 3.3h-1l-1.2-4.4zM58.1 11.3c0-.8-.4-1.2-1.1-1.2-.7 0-1.1.4-1.1 1.2v2.5H55V9.4h.9v.5c.3-.4.8-.6 1.3-.6 1 0 1.8.6 1.8 1.9v2.6h-.9v-2.5zM60.2 7.9h.9v5.9h-.9V7.9zM64.2 13.9c-1.2 0-2.2-.9-2.2-2.3s1-2.3 2.2-2.3c1.3 0 2.2.9 2.2 2.3.1 1.4-.9 2.3-2.2 2.3zm0-.8c.7 0 1.4-.5 1.4-1.5s-.6-1.5-1.3-1.5c-.7 0-1.3.5-1.3 1.5-.1 1 .5 1.5 1.2 1.5zM69.2 9.3c.7 0 1.3.4 1.5.7v-.6h.9v4.4h-.9v-.7c-.3.4-.8.7-1.5.7-1.1 0-2.1-.9-2.1-2.3s.9-2.2 2.1-2.2zm.2.8c-.7 0-1.3.5-1.3 1.5s.7 1.5 1.3 1.5c.7 0 1.3-.5 1.3-1.5s-.6-1.5-1.3-1.5zM74.6 9.3c.6 0 1.2.3 1.5.7V7.9h.9v5.9h-.9v-.7c-.3.4-.8.7-1.5.7-1.2 0-2.1-.9-2.1-2.3s.9-2.2 2.1-2.2zm.2.8c-.7 0-1.3.5-1.3 1.5s.7 1.5 1.3 1.5c.7 0 1.3-.5 1.3-1.5s-.6-1.5-1.3-1.5zM82.2 13.9c-1.2 0-2.2-.9-2.2-2.3s1-2.3 2.2-2.3c1.3 0 2.2.9 2.2 2.3.1 1.4-.9 2.3-2.2 2.3zm0-.8c.7 0 1.4-.5 1.4-1.5s-.6-1.5-1.3-1.5c-.7 0-1.3.5-1.3 1.5s.5 1.5 1.2 1.5zM88.6 11.3c0-.8-.4-1.2-1.1-1.2-.7 0-1.1.4-1.1 1.2v2.5h-.9V9.4h.9v.5c.3-.4.8-.6 1.3-.6 1 0 1.8.6 1.8 1.9v2.6h-.9v-2.5zM92.8 10.1h-.5v-.7h.5V8.3h.9v1.1h1.1v.7h-1.1v2.4c0 .3.1.5.5.5h.6v.8h-.7c-.8 0-1.3-.3-1.3-1.2v-2.5zM95.7 7.9h.9v2c.3-.4.8-.6 1.4-.6 1 0 1.8.6 1.8 1.9v2.6h-.9v-2.5c0-.8-.4-1.2-1.1-1.2-.7 0-1.1.4-1.1 1.2v2.5h-.9V7.9zM102.8 13.9c-1.3 0-2.2-.9-2.2-2.3s.9-2.3 2.2-2.3c1.3 0 2.1.9 2.1 2.2v.4h-3.4c.1.7.6 1.2 1.3 1.2.6 0 .9-.3 1-.6h1c-.3.8-1 1.4-2 1.4zm-1.3-2.7h2.4c0-.7-.6-1.1-1.2-1.1s-1.1.4-1.2 1.1z" class="st1"></path></g></svg></a> <a target="_blank" href="#" class="h-auto w-48 cursor-pointer"><svg id="apple_store__icon" width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 119.7 40" xml:space="preserve" style="enable-background: new 0 0 119.7 40"><style>
                                    .st1 {
                                        fill: #fff;
                                    }
                                </style> <path d="M110.1 0H7.5c-.7 0-1.3.1-2 .2-.6.1-1.3.3-1.9.6C3 1.1 2.5 1.5 2 2S1.1 3 .8 3.6C.5 4.2.3 4.9.2 5.5c-.1.7-.2 1.4-.2 2v24.9c0 .7.1 1.3.2 2s.3 1.3.6 1.9c.3.7.7 1.2 1.2 1.7s1 .9 1.6 1.2c.6.3 1.2.5 1.9.6.7.1 1.3.2 2 .2h104.6c.7 0 1.3-.1 2-.2s1.3-.3 1.9-.6c.6-.3 1.1-.7 1.6-1.2s.9-1 1.2-1.6c.3-.6.5-1.2.6-1.9.1-.7.2-1.3.2-2v-25c0-.7-.1-1.3-.2-2s-.3-1.3-.6-1.9c-.6-1.2-1.6-2.2-2.8-2.8-.6-.3-1.2-.5-1.9-.6-.7-.1-1.3-.2-2-.2h-2z" style="fill: #a6a6a6"></path> <path d="M8.4 39.1h-.9c-.6 0-1.3-.1-1.9-.2-.6-.1-1.1-.3-1.7-.5-.5-.3-1-.6-1.4-1-.4-.4-.8-.9-1-1.4-.3-.5-.4-1.1-.5-1.7-.1-.6-.2-1.2-.2-1.9V7.5c0-.6.1-1.3.2-1.9.1-.5.3-1.1.6-1.6s.6-1 1-1.4c.4-.4.9-.7 1.4-1 .5-.3 1.1-.4 1.7-.5C6.3 1 6.9.9 7.6.9H112.2c.6 0 1.2.1 1.9.2.6.1 1.1.3 1.7.5 1 .5 1.9 1.4 2.4 2.4.3.5.4 1.1.5 1.6.1.6.2 1.3.2 1.9v24.9c0 .6-.1 1.2-.2 1.9-.1.6-.3 1.1-.5 1.7-.3.5-.6 1-1 1.4-.4.4-.9.8-1.4 1-.5.3-1.1.5-1.7.5-.6.1-1.2.2-1.9.2H8.4z"></path> <g id="_Group_"><g id="_Group_2"><g id="_Group_3"><path id="_Path_" d="M24.8 20.3c0-1.7.9-3.3 2.4-4.2-.9-1.3-2.4-2.1-4-2.2-1.7-.2-3.3 1-4.2 1-.9 0-2.2-1-3.6-1-1.9.1-3.6 1.1-4.5 2.7-1.9 3.3-.5 8.3 1.4 11 .9 1.3 2 2.8 3.4 2.8 1.4-.1 1.9-.9 3.6-.9 1.7 0 2.1.9 3.6.9s2.4-1.3 3.3-2.7c.7-.9 1.2-2 1.5-3.1-1.8-.6-2.9-2.4-2.9-4.3z" class="st1"></path> <path id="_Path_2" d="M22 12.2c.8-1 1.2-2.2 1.1-3.5-1.2.1-2.4.7-3.2 1.7-.8.9-1.2 2.1-1.1 3.4 1.3 0 2.4-.6 3.2-1.6z" class="st1"></path></g></g> <path d="M42.3 27.1h-4.7l-1.1 3.4h-2L39 18.1h2l4.5 12.4h-2l-1.2-3.4zm-4.2-1.5h3.8L40 20.1h-.1l-1.8 5.5zM55.2 26c0 2.8-1.5 4.6-3.8 4.6-1.2.1-2.3-.6-2.8-1.6v4.5h-1.9v-12h1.8V23c.6-1 1.7-1.6 2.9-1.6 2.2-.1 3.8 1.8 3.8 4.6zm-2 0c0-1.8-.9-3-2.4-3-1.4 0-2.4 1.2-2.4 3s1 3 2.4 3c1.5 0 2.4-1.2 2.4-3zM65.1 26c0 2.8-1.5 4.6-3.8 4.6-1.2.1-2.3-.6-2.8-1.6v4.5h-1.9v-12h1.8V23c.6-1 1.7-1.6 2.9-1.6 2.3-.1 3.8 1.8 3.8 4.6zm-1.9 0c0-1.8-.9-3-2.4-3-1.4 0-2.4 1.2-2.4 3s1 3 2.4 3c1.5 0 2.4-1.2 2.4-3zM71.7 27c.1 1.2 1.3 2 3 2 1.6 0 2.7-.8 2.7-1.9 0-1-.7-1.5-2.3-1.9l-1.6-.4c-2.3-.6-3.3-1.6-3.3-3.3 0-2.1 1.9-3.6 4.5-3.6s4.4 1.5 4.5 3.6h-1.9c-.1-1.2-1.1-2-2.6-2s-2.5.8-2.5 1.9c0 .9.7 1.4 2.3 1.8l1.4.3c2.5.6 3.6 1.6 3.6 3.4 0 2.3-1.9 3.8-4.8 3.8-2.8 0-4.6-1.4-4.7-3.7h1.7zM83.3 19.3v2.1H85v1.5h-1.7v5c0 .8.3 1.1 1.1 1.1h.6v1.5c-.3.1-.7.1-1 .1-1.8 0-2.5-.7-2.5-2.4V23h-1.3v-1.5h1.3v-2.1h1.8zM86.1 26c0-2.8 1.7-4.6 4.3-4.6 2.6 0 4.3 1.8 4.3 4.6 0 2.9-1.7 4.6-4.3 4.6-2.7 0-4.3-1.8-4.3-4.6zm6.7 0c0-2-.9-3.1-2.4-3.1S88 24 88 26s.9 3.1 2.4 3.1 2.4-1.2 2.4-3.1zM96.2 21.4H98V23c.2-1 1.2-1.7 2.2-1.6.2 0 .4 0 .6.1v1.7c-.3-.1-.6-.1-.8-.1-1 0-1.9.8-1.9 1.8v5.7h-1.9v-9.2zM109.4 27.8c-.2 1.6-1.9 2.8-3.9 2.8-2.6 0-4.3-1.8-4.3-4.6s1.6-4.7 4.2-4.7c2.5 0 4.1 1.7 4.1 4.5v.6h-6.4v.1c-.1 1.3.8 2.4 2.1 2.6h.3c.9.1 1.8-.4 2.1-1.3h1.8zm-6.3-2.7h4.5c.1-1.2-.9-2.2-2.1-2.3h-.2c-1.2 0-2.2 1-2.2 2.3z" class="st1"></path></g> <g id="_Group_4"><path d="M37.8 8.7c1.5-.1 2.7 1 2.8 2.4v.5c0 1.9-1 3-2.8 3h-2.2v-6h2.2zm-1.2 5.2h1.1c1 .1 1.9-.7 2-1.8v-.4c.1-1-.6-2-1.6-2.1h-1.5v4.3zM41.7 12.4c-.1-1.2.7-2.2 1.9-2.3 1.2-.1 2.2.7 2.3 1.9v.4c.1 1.2-.7 2.2-1.9 2.3-1.2.1-2.2-.7-2.3-1.9v-.4zm3.3 0c0-1-.4-1.5-1.2-1.5-.8 0-1.2.6-1.2 1.5 0 1 .4 1.6 1.2 1.6.8 0 1.2-.6 1.2-1.6zM51.6 14.7h-.9l-.9-3.3h-.1l-.9 3.3h-.9l-1.2-4.5h.9l.8 3.4h.1l.9-3.4h.9l.9 3.4h.1l.8-3.4h.9l-1.4 4.5zM53.9 10.2h.9v.7h.1c.2-.5.8-.8 1.3-.8.8-.1 1.5.5 1.6 1.4V14.7h-.9V12c0-.7-.3-1.1-1-1.1-.6 0-1.1.4-1.1 1V14.7h-.9v-4.5zM59.1 8.4h.9v6.3h-.9V8.4zM61.2 12.4c-.1-1.2.7-2.2 1.9-2.3 1.2-.1 2.2.7 2.3 1.9v.4c.1 1.2-.7 2.2-1.9 2.3s-2.2-.7-2.3-1.9v-.4zm3.4 0c0-1-.4-1.5-1.2-1.5-.8 0-1.2.6-1.2 1.5 0 1 .4 1.6 1.2 1.6.7 0 1.2-.6 1.2-1.6zM66.4 13.4c0-.8.6-1.3 1.7-1.3l1.2-.1v-.4c0-.5-.3-.7-.9-.7-.5 0-.8.2-.9.5h-.9c.1-.8.8-1.3 1.8-1.3 1.1 0 1.8.6 1.8 1.5v3.1h-.9v-.6h-.1c-.3.5-.8.7-1.4.7-.7.1-1.4-.5-1.5-1.2.1-.1.1-.1.1-.2zm2.9-.4v-.4l-1.1.1c-.6 0-.9.3-.9.6 0 .4.4.6.8.6.6.2 1.1-.2 1.2-.9 0 .1 0 .1 0 0zM71.3 12.4c0-1.4.7-2.3 1.9-2.3.6 0 1.1.3 1.4.8h.1V8.4h.9v6.3h-.9V14h-.1c-.3.5-.8.8-1.4.8-1.1 0-1.9-.9-1.9-2.4zm1 0c0 1 .5 1.5 1.2 1.5s1.2-.6 1.2-1.5-.5-1.5-1.2-1.5c-.8 0-1.2.6-1.2 1.5zM79.2 12.4c-.1-1.2.7-2.2 1.9-2.3s2.2.7 2.3 1.9v.4c.1 1.2-.7 2.2-1.9 2.3-1.2.1-2.2-.7-2.3-1.9v-.4zm3.4 0c0-1-.4-1.5-1.2-1.5-.8 0-1.2.6-1.2 1.5 0 1 .4 1.6 1.2 1.6.7 0 1.2-.6 1.2-1.6zM84.7 10.2h.9v.7h.1c.2-.5.8-.8 1.3-.8.8-.1 1.5.5 1.6 1.4V14.7h-.9V12c0-.7-.3-1.1-1-1.1-.6 0-1.1.4-1.1 1V14.7h-.9v-4.5zM93.5 9.1v1.1h1v.8h-1v2.3c0 .5.2.7.6.7h.3v.7h-.5c-1 0-1.4-.3-1.4-1.2V11h-.7v-.7h.7V9.1h1zM95.7 8.4h.9v2.5h.1c.2-.5.8-.9 1.4-.8.8 0 1.5.6 1.6 1.4V14.7h-.9V12c0-.7-.3-1.1-1-1.1-.6 0-1.1.4-1.1 1V14.7h-.9l-.1-6.3zM104.8 13.5c-.2.8-1.1 1.4-2 1.3-1.1 0-2.1-.9-2.1-2v-.3c-.2-1.1.6-2.2 1.8-2.3h.3c1.3 0 2 .9 2 2.3v.3h-3.2c-.1.7.4 1.2 1.1 1.3h.1c.4.1.9-.2 1.1-.5l.9-.1zm-3.2-1.5h2.3c0-.6-.4-1.1-1-1.2h-.1c-.6.1-1.2.6-1.2 1.2z" class="st1"></path></g></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Dewnload App area -->

    <!-- Start Why Choose One Area -->
    <section id="about" class="why-choose-us ptb-100 bg-f9faff">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="row about-image">
                        <div class="col-6 col-lg-6 col-md-6">
                            <div class="image">
                                <img src="{{asset('/client/')}}/assets/img/about-img1.jpg" alt="about">
                            </div>
                        </div>

                        <div class="col-6 col-lg-6 col-md-6">
                            <div class="image">
                                <img src="{{asset('/client/')}}/assets/img/about-img2.jpg" alt="about">
                            </div>
                        </div>

                        <div class="col-6 col-lg-6 col-md-6">
                            <div class="image mt-30">
                                <img src="{{asset('/client/')}}/assets/img/about-img3.jpg" alt="about">
                            </div>
                        </div>

                        <div class="col-6 col-lg-6 col-md-6">
                            <div class="image mt-30">
                                <img src="{{asset('/client/')}}/assets/img/about-img4.jpg" alt="about">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="section-title">
                        <h3>Why Choose <b> OneTapHealth </b></h3>
                        <span>Read About Us</span>
                    </div>

                    <div class="why-choose-us-text">
                        <p>At One Tap Health, we are dedicated to your well-being. With a legacy of excellence and a commitment to care, we offer complete healthcare services.
                            Our team of experienced professionals is driven by a shared passion for providing quality care to our patients.</p>


                        <ul>
                            <li>Your health is our priority, and we tailor our services to your unique needs.</li>
                            <li>Our skilled healthcare professionals bring years of experience and expertise to every patient interaction.</li>
                            <li>We embrace the latest advancements in medical technology to ensure accurate diagnoses and effective treatments.</li>
                            <li>We maintain the highest standards of medical care, ensuring your safety and satisfaction.</li>
                            <li>Our aim is to make healthcare accessible to all, offering suitable locations and over-phone options.</li>
                            <li>We believe in partnering with you to achieve your health goals and provide a supportive healthcare environment.</li>
                        </ul>

                        <a href="#" class="btn">Our Work</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Why Choose Us Area -->

    <!-- Start Who We Are Area -->
    <section class="who-we-are ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="section-title">
                        <h3>Who We Are</h3>
                        <span>Meet the Entire Doctor</span>
                    </div>

                    <div class="who-we-are-text">
                        <p>Know about our experienced doctors, specialists, and consultants who are here to provide you with the highest standard of medical care. With a passion for healing, a commitment to care, and a focus on your individual needs, we are here to guide you on your journey to recovery. Get to know the faces behind your healthcare at One Tap Health. </p>
                        {{--<a href="#" class="btn">Appointment Now</a>--}}
                    </div>
                </div>

                <div class="col-lg-8 col-md-12">
                    <ul class="team-members">
                        <li class="clearfix">
                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img1.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img2.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img3.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="clearfix">
                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img4.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img2.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img1.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="clearfix">
                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img1.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img4.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="member-details">
                                <div>
                                    <img src="{{asset('/client/')}}/assets/img/doctor-img2.png" alt="doctor">
                                    <div class="member-info">
                                        <h3>DR. John Doe</h3>
                                        <p>Dental Specialist</p>
                                        <ul>
                                            <li><a href="#" class="icofont-facebook"></a></li>
                                            <li><a href="#" class="icofont-twitter"></a></li>
                                            <li><a href="#" class="icofont-linkedin"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Who We Are Area -->

    <!-- Start Departments Area -->
    <section id="department" class="departments-area ptb-100 bg-f9faff">
        <div class="container">
            <div class="section-title">
                <h3>Our Departments</h3>
                <span>Which Services We Provide</span>
                <p>We offer all-inclusive medical departments to meet your healthcare needs. Our dedicated team of specialists and professionals is committed to providing you with top-quality care in a variety of fields.</p>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="tab">
                        <ul class="tabs">
                            <li><a href="#">
                                    <i class="icofont-laboratory"></i>
                                    <br>
                                    Pathology Test
                                </a></li>

                            <li><a href="#">
                                    <i class="icofont-doctor"></i>
                                    <br>
                                    Doctor
                                </a></li>

                            <li><a href="#">
                                    <i class="icofont-hospital"></i>
                                    <br>
                                    Hospital
                                </a></li>

                            <li><a href="#">
                                    <i class="icofont-medicine"></i>
                                    <br>
                                    Medicine
                                </a></li>

                            <li><a href="#">
                                    <i class="icofont-ambulance"></i>
                                    <br>
                                    Ambulance
                                </a></li>

                            <li><a href="#">
                                    <i class="icofont-blood"></i>
                                    <br>
                                    Blood Donation
                                </a></li>
                        </ul>

                        <div class="tab_content">
                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_img">
                                            <img src="{{asset('/client/')}}/assets/img/department-img1.jpg" alt="department">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_content">
                                            <h3>Welcome to Pathology Test</h3>
                                            {{--<p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>--}}
                                            <ul>
                                                <li>Accurate diagnostics are crucial. Our pathology tests deliver precise results, aiding in informed healthcare decisions. </li>
                                                <li>Precise diagnostics with advanced technology.</li>
                                                <li>Comprehensive range of tests.</li>
                                                <li>Accurate results for informed healthcare decisions.</li>
                                                <li>Dedicated team of experienced pathologists</li>
                                            </ul>
                                            {{--<a href="#" class="btn">Appointment Now</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_img">
                                            <img src="{{asset('/client/')}}/assets/img/department-img1.jpg" alt="department">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_content">
                                            <h3>Our Doctors are</h3>
                                            {{--<p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>--}}
                                            <ul>
                                                <li>Our dedicated doctors prioritize your health. With expertise, they provide individual care to ensure your better treatment.</li>
                                                <li>Experienced healthcare professionals.</li>
                                                <li>Compassionate care tailored to you.</li>
                                                <li>Trusted expertise in various specialties.</li>
                                                <li>Your partners in health and well-being.</li>
                                            </ul>
                                            {{--<a href="#" class="btn">Appointment Now</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_img">
                                            <img src="{{asset('/client/')}}/assets/img/department-img1.jpg" alt="department">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_content">
                                            <h3>Our Hospital Provide</h3>
                                            {{--<p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>--}}
                                            <ul>
                                                <li>Experience exceptional care at our modern hospital. Advanced facilities, skilled medical staff, and patient-centric approach for your well-being.</li>
                                                <li>Advanced medical facilities and technology.</li>
                                                <li>Skilled and experienced healthcare professionals.</li>
                                                <li>Patient-focused approach for personalized care.</li>
                                                <li> commitment to your health and well-being.</li>
                                            </ul>
                                            {{--<a href="#" class="btn">Appointment Now</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_img">
                                            <img src="{{asset('/client/')}}/assets/img/department-img1.jpg" alt="department">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_content">
                                            <h3>Welcome to Medicine Department</h3>
                                            {{--<p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>--}}
                                            <ul>
                                                <li>Explore our trusted medicines. Expertly prescribed for your well-being, providing effective solutions for various health conditions. Your health is our priority.</li>
                                                <li>Trusted medications for various conditions.</li>
                                                <li>Ensuring your health and well-being.</li>
                                                <li>Effective and safe for managing various health conditions.</li>
                                                <li>Quality assured for optimal results.</li>
                                            </ul>
                                            {{--<a href="#" class="btn">Appointment Now</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_img">
                                            <img src="{{asset('/client/')}}/assets/img/department-img1.jpg" alt="department">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_content">
                                            <h3>Welcome to Ambulance Department</h3>
                                            {{--<p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>--}}
                                            <ul>
                                                <li>Our expert team ensures swift, safe transport, and immediate care during medical emergencies. Your health matters.</li>
                                                <li>Swift response during emergencies.</li>
                                                <li>Highly trained medical teams.</li>
                                                <li>Timely and safe patient transport.</li>
                                                <li>Saving lives is our mission.</li>
                                            </ul>
                                            {{--<a href="#" class="btn">Appointment Now</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tabs_item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_img">
                                            <img src="{{asset('/client/')}}/assets/img/department-img1.jpg" alt="department">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tabs_item_content">
                                            <h3>Welcome to Blood Donation</h3>
                                            {{--<p>This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.</p>--}}
                                            <ul>
                                                <li>Give the gift of life through blood donation. Join us in saving lives and making a meaningful impact in our community.</li>
                                                <li>Donate to save lives</li>
                                                <li>Community support</li>
                                                <li>Easy process</li>
                                                <li>Join us in making a difference</li>
                                            </ul>
                                            {{--<a href="#" class="btn">Appointment Now</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Departments Area -->

    <!-- Start Make an Appointment Area -->
    {{--<section id="appointment" class="appointment-area ptb-100">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-lg-6 col-md-6">--}}
                    {{--<div class="section-title">--}}
                        {{--<h3>Make an Appointment</h3>--}}
                        {{--<span>Visit Your Primary Care Physician</span>--}}
                    {{--</div>--}}

                    {{--<div class="faq">--}}
                        {{--<ul class="accordion">--}}
                            {{--<li class="accordion-item">--}}
                                {{--<a class="accordion-title active" href="javascript:void(0)">What is One Tap Health? <i class="icofont-plus"></i></a>--}}
                                {{--<p class="accordion-content show">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.</p>--}}
                            {{--</li>--}}

                            {{--<li class="accordion-item">--}}
                                {{--<a class="accordion-title" href="javascript:void(0)">What is One Tap Health? <i class="icofont-plus"></i></a>--}}
                                {{--<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.</p>--}}
                            {{--</li>--}}

                            {{--<li class="accordion-item">--}}
                                {{--<a class="accordion-title" href="javascript:void(0)">What is One Tap Health? <i class="icofont-plus"></i></a>--}}
                                {{--<p class="accordion-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.</p>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-lg-6 col-md-6">--}}
                    {{--<div class="appointment-form">--}}
                        {{--<form>--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-lg-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="text" class="form-control" placeholder="Name">--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="email" class="form-control" placeholder="Email">--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="text" class="form-control" placeholder="Phone Number">--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<select class="form-control">--}}
                                            {{--<option>Department</option>--}}
                                            {{--<option>1</option>--}}
                                            {{--<option>2</option>--}}
                                            {{--<option>3</option>--}}
                                            {{--<option>4</option>--}}
                                            {{--<option>5</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<select class="form-control">--}}
                                            {{--<option>Doctor</option>--}}
                                            {{--<option>1</option>--}}
                                            {{--<option>2</option>--}}
                                            {{--<option>3</option>--}}
                                            {{--<option>4</option>--}}
                                            {{--<option>5</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-6">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<input type="text" id="datepicker" class="form-control" placeholder="Booking Date">--}}
                                        {{--<span><i class="icofont-calendar"></i></span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-12">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<textarea class="form-control" cols="30" rows="4" placeholder="Message"></textarea>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="col-lg-12">--}}
                                    {{--<button type="submit" class="btn">Book Now</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
    <!-- End Make an Appointment Area -->

    <!-- Start Services Area -->
    <section id="service" class="services-area ptb-100 bg-f9faff">
        <div class="container">
            <div class="section-title">
                <h3>Our Services</h3>
                <span>Which Services We Provide</span>
                <p>Explore our comprehensive healthcare services, including diagnostics, treatments, and wellness programs, designed to support your well-being at every stage of life.</p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single-services">
                        <i class="icofont-surgeon"></i>
                        <h3>Plastic Surgery</h3>
                        <p>Discover the art of transformation with our board-certified plastic surgeons. Achieve your desired look with safe, expert procedures to achieve your unique goals.</p>
                        {{--<a href="#" class="icofont-paper-plane"></a>--}}
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-services">
                        <i class="icofont-nurse"></i>
                        <h3>Breast Screening</h3>
                        <p>Prioritize your breast health with our advanced screening services. Early detection is key our specialized screenings empower you with knowledge and peace of mind.</p>
                        {{--<a href="#" class="icofont-paper-plane"></a>--}}
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-services">
                        <i class="icofont-herbal"></i>
                        <h3>Nutrition and Dietetics</h3>
                        <p>Optimize your health with personalized nutrition plans. Our registered dietitians empower you to make informed choices, fostering well-being through balanced eating. </p>
                        {{--<a href="#" class="icofont-paper-plane"></a>--}}
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="single-services">
                        <i class="icofont-icu"></i>
                        <h3>Occupational Therapy</h3>
                        <p>Enhance your daily life and independence. Our skilled occupational therapists provide personalized strategies to overcome challenges, promoting a fulfilling, meaningful life.</p>
                        {{--<a href="#" class="icofont-paper-plane"></a>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Services Area -->

    <!-- Start Fun Facts Area -->
    <section class="fun-facts-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="fun-fact">
                        <i class="icofont-wink-smile"></i>
                        <h3 class="count">25000</h3>
                        <span>Happy Patients</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="fun-fact">
                        <i class="icofont-doctor-alt"></i>
                        <h3 class="count">180</h3>
                        <span>Experienced Doctors</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="fun-fact">
                        <i class="icofont-patient-bed"></i>
                        <h3 class="count">1200</h3>
                        <span>Successful Operations</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="fun-fact">
                        <i class="icofont-bed"></i>
                        <h3 class="count">2800</h3>
                        <span>Number of Beds</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Fun Facts Area -->

    <!-- Start Gallery Area -->
    <section id="gallery" class="gallery-area ptb-100">
        <div class="container">
            <div class="section-title">
                <h3>Photo Gallery</h3>
                <span>Which Services We Provide</span>
                <p>Explore our photo gallery showcasing our healthcare facilities, compassionate staff, advanced technology, and the positive impact on our community's well-being.</p>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="shorting-menu">
                        <button class="filter" data-filter="all">All</button>
                        <button class="filter" data-filter=".cardiology">Cardiology</button>
                        <button class="filter" data-filter=".neurology">Neurology</button>
                        <button class="filter" data-filter=".sergury">Sergury</button>
                        <button class="filter" data-filter=".orthopaedics">Orthopaedics</button>
                        <button class="filter" data-filter=".urology">Urology</button>
                    </div>
                </div>
            </div>

            <div class="shorting">
                <div class="row">
                    <div class="col-lg-4 col-md-6 mix cardiology">
                        <div class="single-photo">
                            <img src="{{asset('/client/')}}/assets/img/gallery-img1.jpg" alt="gallery">
                            <div class="gallery-content">
                                <h3>Blood Pressure</h3>
                                <span>Cardiology</span>
                                <a href="#" class="link-btn"><i class="icofont-link"></i></a>
                                <a href="{{asset('/client/')}}/assets/img/gallery-img1.jpg" class="popup-btn"><i class="icofont-expand"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix neurology">
                        <div class="single-photo">
                            <img src="{{asset('/client/')}}/assets/img/gallery-img2.jpg" alt="gallery">
                            <div class="gallery-content">
                                <h3>Blood Pressure</h3>
                                <span>Cardiology</span>
                                <a href="#" class="link-btn"><i class="icofont-link"></i></a>
                                <a href="{{asset('/client/')}}/assets/img/gallery-img2.jpg" class="popup-btn"><i class="icofont-expand"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix sergury">
                        <div class="single-photo">
                            <img src="{{asset('/client/')}}/assets/img/gallery-img3.jpg" alt="gallery">
                            <div class="gallery-content">
                                <h3>Blood Pressure</h3>
                                <span>Cardiology</span>
                                <a href="#" class="link-btn"><i class="icofont-link"></i></a>
                                <a href="{{asset('/client/')}}/assets/img/gallery-img3.jpg" class="popup-btn"><i class="icofont-expand"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix orthopaedics">
                        <div class="single-photo">
                            <img src="{{asset('/client/')}}/assets/img/gallery-img4.jpg" alt="gallery">
                            <div class="gallery-content">
                                <h3>Blood Pressure</h3>
                                <span>Cardiology</span>
                                <a href="#" class="link-btn"><i class="icofont-link"></i></a>
                                <a href="{{asset('/client/')}}/assets/img/gallery-img4.jpg" class="popup-btn"><i class="icofont-expand"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix urology">
                        <div class="single-photo">
                            <img src="{{asset('/client/')}}/assets/img/gallery-img5.jpg" alt="gallery">
                            <div class="gallery-content">
                                <h3>Blood Pressure</h3>
                                <span>Cardiology</span>
                                <a href="#" class="link-btn"><i class="icofont-link"></i></a>
                                <a href="{{asset('/client/')}}/assets/img/gallery-img5.jpg" class="popup-btn"><i class="icofont-expand"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mix orthopaedics cardiology">
                        <div class="single-photo">
                            <img src="{{asset('/client/')}}/assets/img/gallery-img6.jpg" alt="gallery">
                            <div class="gallery-content">
                                <h3>Blood Pressure</h3>
                                <span>Cardiology</span>
                                <a href="#" class="link-btn"><i class="icofont-link"></i></a>
                                <a href="{{asset('/client/')}}/assets/img/gallery-img6.jpg" class="popup-btn"><i class="icofont-expand"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Gallery Area -->

    <!-- Start Pricing Area -->
    <!-- <section id="price" class="pricing-area ptb-100 bg-f9faff">
        <div class="container">
            <div class="section-title">
                <h3>Our Pricing</h3>
                <span>Our Best Price Offer</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3>Blood Test</h3>
                        </div>

                        <div class="price">
                            <span><sup>$</sup>145</span>
                        </div>

                        <div class="pricing-features">
                            <ul>
                                <li>Cholesterol and lipid tests</li>
                                <li>Oestrogen blood test</li>
                                <li>Thyroid function tests</li>
                                <li>Kidney function tests</li>
                                <li>C-reactive protein (CRP) test</li>
                                <li>Cholesterol and lipid tests</li>
                                <li>Oestrogen blood test</li>
                                <li>Thyroid function tests</li>
                            </ul>
                        </div>

                        <div class="pricing-footer">
                            <a href="#" class="btn">Appointment Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3>Body CT Scan</h3>
                        </div>

                        <div class="price">
                            <span><sup>$</sup>350</span>
                        </div>

                        <div class="pricing-features">
                            <ul>
                                <li>Cholesterol and lipid tests</li>
                                <li>Oestrogen blood test</li>
                                <li>Thyroid function tests</li>
                                <li>Kidney function tests</li>
                                <li>C-reactive protein (CRP) test</li>
                                <li>Cholesterol and lipid tests</li>
                                <li>Oestrogen blood test</li>
                                <li>Thyroid function tests</li>
                            </ul>
                        </div>

                        <div class="pricing-footer">
                            <a href="#" class="btn">Appointment Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 offset-lg-0 offset-md-3">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3>Urine Test</h3>
                        </div>

                        <div class="price">
                            <span><sup>$</sup>125</span>
                        </div>

                        <div class="pricing-features">
                            <ul>
                                <li>Cholesterol and lipid tests</li>
                                <li>Oestrogen blood test</li>
                                <li>Thyroid function tests</li>
                                <li>Kidney function tests</li>
                                <li>C-reactive protein (CRP) test</li>
                                <li>Cholesterol and lipid tests</li>
                                <li>Oestrogen blood test</li>
                                <li>Thyroid function tests</li>
                            </ul>
                        </div>

                        <div class="pricing-footer">
                            <a href="#" class="btn">Appointment Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- End Pricing Area -->

    <!-- Start Testimonials Area -->
    <section class="testimonials-area ptb-100">
        <div class="container">
            <div class="section-title">
                <h3>Testimonials</h3>
                <span>Our Patient Feedback</span>
                <p>Exceptional care, compassionate staff, and life-changing results. Discover why our healthcare is trusted by many.</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-feedback">
                        <div class="client-info">
                            <div class="img">
                                <img src="{{asset('/client/')}}/assets/img/client-avatar1.jpg" alt="client">
                            </div>
                            <h4>Sadia Afroz Mouri</h4>
                            <span>Teacher</span>
                        </div>

                        <p>I am always grateful to 'OneTap Health' team for providing such a wonderful service</p>

                        <i class="icofont-quote-right"></i>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feedback">
                        <div class="client-info">
                            <div class="img">
                                <img src="{{asset('/client/')}}/assets/img/client-avatar2.jpg" alt="client">
                            </div>
                            <h4>Mehedi Hasan</h4>
                            <span>Doctor</span>
                        </div>

                        <p>As a Son who works as a doctor, I am relieved to see that this services have been a great help for my Parents and he is able to get proper treatment, thanks to 'OneTapHealth' team.</p>

                        <i class="icofont-quote-right"></i>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feedback">
                        <div class="client-info">
                            <div class="img">
                                <img src="{{asset('/client/')}}/assets/img/client-avatar3.jpg" alt="client">
                            </div>
                            <h4>Mrs.Samira</h4>
                            <span>Student</span>
                        </div>

                        <p>I am very happy to have this kind of service</p>

                        <i class="icofont-quote-right"></i>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Testimonials Area -->


    <!-- Start Contact Area -->
    <section id="contact" class="contact-area ptb-100">
        <div class="container">
            <div class="row">


                <div class="col-lg-4 col-md-12">
                    <div class="get-in-touch">
                        <h3>Get in Touch</h3>
                        <p>Have questions or need assistance? Contact our caring team for personalized support, appointments, or inquiries. We're here to help you. </p>
                        <ul>
                            <li><a href="#"><i class="icofont-facebook"></i></a></li>
                            <li><a href="#"><i class="icofont-twitter"></i></a></li>
                            <li><a href="#"><i class="icofont-linkedin"></i></a></li>
                            <li><a href="#"><i class="icofont-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12">
                    <form id="contactForm">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name" required data-error="Please enter your name" placeholder="Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email" required data-error="Please enter your email" placeholder="Email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="4" required data-error="Write your message" placeholder="Message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <button type="submit" class="btn">Send Message</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Area -->
    @endsection
