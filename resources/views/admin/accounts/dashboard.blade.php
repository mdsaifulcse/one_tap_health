@extends('admin.layout.app')
@section('title')
    Accounts Dashboard | Admin
    @endsection

@section('main-content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-header-title">
                <h4>Accounts Dashboard</h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-2.html">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Home</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Accounts Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12 col-xl-3">
                    <div class="card">
                        <a href="{{route('admin.test-orders.index')}}" target="_blank">
                        <div class="widget-profile-card-1">
                            <div class="middle-user">
                                <i class="icofont icofont-4x">৳</i>
                            </div>
                        </div>
                        <div class="card-block text-center">
                            <h3>Today's</h3>
                        </div>
                        </a>
                        <div class="card-footer bg-inverse">
                            <div class="row text-center">
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-success">
                                    <h4>4</h4>
                                    <span>Paid</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-warning">

                                    <h4>4</h4>
                                    <span>Unpaid</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4">
                                    <h4>4</h4>
                                    <span>Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-3">
                    <div class="card">
                        <a href="#" target="_blank">
                        <div class="widget-profile-card-1">
                            <div class="middle-user">
                                <i class="icofont icofont-4x">৳</i>
                            </div>
                        </div>
                        <div class="card-block text-center">
                            <h3 title="Doctor Appointment">7 Days</h3>
                        </div>
                        </a>
                        <div class="card-footer bg-inverse">
                            <div class="row text-center">
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-success">
                                    <h4>4</h4>
                                    <span>Paid</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-warning">
                                    <h4>4</h4>
                                    <span>Unpaid</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4">
                                    <h4>4</h4>
                                    <span>Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-3">
                    <div class="card">
                        <a href="{{route('admin.doctors.index')}}" target="_blank">
                        <div class="widget-profile-card-1">
                            <div class="middle-user">
                                <i class="icofont icofont-4x">৳</i>
                            </div>
                        </div>
                        <div class="card-block text-center">
                            <h3>15 Days</h3>
                        </div>
                        </a>
                        <div class="card-footer bg-inverse">
                            <div class="row text-center">
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-success">
                                    <h4>4</h4>
                                    <span>Active</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-warning">
                                    <h4>4</h4>
                                    <span>Inactive</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4">
                                    <h4>4</h4>
                                    <span>Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-3">
                    <div class="card">
                        <a href="{{route('admin.hospitals.index')}}" target="_blank">
                        <div class="widget-profile-card-1">
                            <div class="middle-user">
                                <i class="icofont icofont-4x">৳</i>
                            </div>
                        </div>
                        <div class="card-block text-center">
                            <h3>30 Days</h3>
                        </div>
                        </a>
                        <div class="card-footer bg-inverse">
                            <div class="row text-center">
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-success">
                                    <h4>4</h4>
                                    <span>Active</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4 text-warning">
                                    <h4>4</h4>
                                    <span>Inactive</span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-lg-4">
                                    <h4>4</h4>
                                    <span>Total</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{--<div class="row">--}}
                {{--<div class="col-md-6 col-xl-3">--}}
                    {{--<div class="card social-widget-card">--}}
                        {{--<div class="card-block-big bg-facebook">--}}
                            {{--<h3>100 +</h3>--}}
                            {{--<span class="m-t-10">This is a dashboard</span>--}}
                            {{--<i class="icofont icofont-social-facebook"></i>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-xl-3">--}}
                    {{--<div class="card social-widget-card">--}}
                        {{--<div class="card-block-big bg-twitter">--}}
                            {{--<h3>200 +</h3>--}}
                            {{--<span class="m-t-10">This is a dashboard</span>--}}
                            {{--<i class="icofont icofont-social-twitter"></i>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-xl-3">--}}
                    {{--<div class="card social-widget-card">--}}
                        {{--<div class="card-block-big bg-linkein">--}}
                            {{--<h3>500 +</h3>--}}
                            {{--<span class="m-t-10">This is a dashboard</span>--}}
                            {{--<i class="icofont icofont-brand-linkedin"></i>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-xl-3">--}}
                    {{--<div class="card social-widget-card">--}}
                        {{--<div class="card-block-big bg-google-plus">--}}
                            {{--<h3>1000 +</h3>--}}
                            {{--<span class="m-t-10">This is a dashboard</span>--}}
                            {{--<i class="icofont icofont-social-google-plus"></i>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    @endsection