@extends('admin.layout.app')
@section('title')
    Dashboard | Admin
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Edit User </h4>
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
                        <a href="{{route('admin.users.index')}}"> User List</a>
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
                    <form class="md-float-material" method="POST" action="{{ route('admin.users.update',$user->id) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit user info | {{$user->name}}</h5>
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
                                        <label class="col-form-label col-2 text-right">Name</label>
                                        <div class="col-9">
                                            <input type="text" name="name" value="{{old('name',$user->name)}}" required autocomplete="off" class="form-control" placeholder="Your name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Email</label>
                                        <div class="col-9">
                                            <input type="email" name="email" value="{{old('email',$user->email)}}" required autocomplete="off" class="form-control" placeholder="Your Email Address">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('email') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Phone</label>
                                        <div class="col-9">
                                            <input type="text" name="phone" value="{{old('phone',$user->phone)}}" required autocomplete="off" class="form-control" placeholder="Your Phone Number">
                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('phone') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Address</label>
                                        <div class="col-9">
                                            <input type="text" name="address" value="{{old('address',isset($user->profile)?$user->profile->address:'')}}"  autocomplete="off" class="form-control" placeholder="Your address">
                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('address') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Contact no</label>
                                        <div class="col-9">
                                            <input type="text" name="contact" value="{{old('contact',isset($user->profile)?$user->profile->contact:'')}}"  autocomplete="off" class="form-control" placeholder="Your contact">
                                            @if ($errors->has('contact'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('contact') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Bio</label>
                                        <div class="col-9">

                                            <textarea rows="4" placeholder="Your Short Bio " class="form-control"  name="bio" cols="50">{{isset($user->profile)?$user->profile->bio:''}}</textarea>
                                            @if ($errors->has('bio'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('bio') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Profile Photo</label>
                                        <div class="col-9">

                                            <label class="slide_upload" for="file">
                                                <!--  -->

                                                @if(isset($user->profile->avatar) && file_exists($user->profile->avatar))
                                                    <img id="image_load" src="{{asset($user->profile->avatar)}}" style="width: 150px;height: 150px;cursor:pointer">
                                                @else

                                                    <img id="image_load" src="{{asset('images/default/default.png')}}" style="width: 150px; height: 150px;cursor:pointer;">

                                                @endif
                                            </label>
                                            <input id="file" style="display:none" name="avatar" type="file" onchange="photoLoad(this,this.id)" accept="image/*">


                                            @if ($errors->has('avatar'))
                                                <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('avatar') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Status</label>
                                        <div class="col-9">
                                            <select name="status" id="userStatus" class="form-control">
                                                <option value="0" @if($user->status ==App\Models\User::INACTIVE ) selected @endif>Inactive</option>
                                                <option value="1" @if($user->status ==App\Models\User::ACTIVE) selected @endif>Active</option>
                                            </select>
                                            {{--<select name="status" id="userStatus" class="form-control">--}}
                                                {{--<option value="0" @if($user->status ==0 ) selected @endif>Rejected</option>--}}
                                                {{--<option value="1" @if($user->status ==1) selected @endif>Approved</option>--}}
                                                {{--<option value="2" @if($user->status==2) selected @endif>Pending</option>--}}
                                            {{--</select>--}}

                                            @if ($errors->has('status'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
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
    <script type="text/javascript">

        function photoLoad(input,image_load) {
            var target_image='#'+$('#'+image_load).prev().children().attr('id');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(target_image).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection