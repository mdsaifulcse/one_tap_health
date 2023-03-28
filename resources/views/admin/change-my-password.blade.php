@extends('admin.layout.app')
@section('title')
    Dashboard | Admin
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Change password </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <i class="icofont icofont-list"></i>
                        <a href="#">Password Change</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <!-- Table header styling table start -->
                    <form class="md-float-material" method="POST" action="{{ route('admin.update-my-password',$user->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{$user->name}} | Change my password <i class="icofont icofont-key"></i> </h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                <i class="icofont icofont-close-circled"></i>
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="login-card0 auth-body0">

                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-right">Current Password</label>
                                        <div class="col-6">
                                            <input type="password" name="current_password" required autocomplete="off" class="form-control" placeholder="">
                                            @if ($errors->has('current_password'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('current_password') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-right">New Password</label>
                                        <div class="col-6">
                                            <input type="password" name="new_password" required autocomplete="off" class="form-control" placeholder="">
                                            @if ($errors->has('new_password'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('new_password') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-right">Confirm Password</label>
                                        <div class="col-6">
                                            <input type="password" name="new_confirm_password" required autocomplete="off" class="form-control" placeholder="">
                                            @if ($errors->has('new_confirm_password'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('new_confirm_password') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>




                                <!-- end of form -->
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" class="btn btn-warning form-footer">Submit</button>

                                </div>
                                <div class="col-2">
                                    <a href="{{url('admin/users')}}" class="btn btn-secondary pull-right">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- Table header styling table end -->
        </div>
        <!-- Page-body end -->
    </div>
@endsection

@section('script')
@endsection