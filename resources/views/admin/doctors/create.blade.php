@extends('admin.layout.app')
@section('title')
   Create Doctor | Dashboard
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Create Doctor </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.doctors.index')}}" class="btn btn-info btn-sm"  title="Hospital List here"><i class="icofont icofont-list"></i> Doctor List</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <!-- Form -->
                        {!! Form::open(array('route' => 'admin.doctors.store','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Create new Doctor</h5>
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
                                        <label class="col-form-label col-2 text-right">Name <sup class="text-danger">*</sup></label>
                                        <div class="col-9">
                                            <input type="text" name="name" value="{{old('name')}}" required autocomplete="off" class="form-control" placeholder="Doctor Name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('name') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Mobile<sup class="text-danger">*</sup></label>
                                        <div class="col-9">
                                            <input type="text" name="mobile" value="{{old('mobile')}}" required autocomplete="off" class="form-control" placeholder="Doctor mobile">
                                            @if ($errors->has('mobile'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('mobile') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Email</label>
                                        <div class="col-9">
                                            <input type="email" name="email" value="{{old('email')}}" autocomplete="off" class="form-control" placeholder="Doctor email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('email') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Contact no</label>
                                        <div class="col-9">
                                            <input type="text" name="contact" value="{{old('contact')}}"  autocomplete="off" class="form-control" placeholder="Your contact">
                                            @if ($errors->has('contact'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('contact') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Institute</label>
                                        <div class="col-9">
                                            <input type="text" name="institute" value="{{old('institute')}}"  autocomplete="off" class="form-control" placeholder="Doctor Institute">
                                            @if ($errors->has('institute'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('institute') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Designation</label>
                                        <div class="col-9">
                                            <input type="text" name="designation" value="{{old('designation')}}"  autocomplete="off" class="form-control" placeholder="Doctor designation">
                                            @if ($errors->has('designation'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('designation') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Degree <sup class="text-danger">*</sup></label>
                                        <div class="col-9">
                                            {{Form::select('degree', $degrees,[], ['class' => 'form-control','placeholder'=>'Select one','required'=>true])}}

                                            @if ($errors->has('degree'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('degree') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Department <sup class="text-danger">*</sup></label>
                                        <div class="col-9">
                                            {{Form::select('department', $department,[], ['class' => 'form-control','placeholder'=>'Select one','required'=>true])}}

                                            @if ($errors->has('department'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('department') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Doctor bio</label>
                                        <div class="col-9">

                                            <textarea rows="4" placeholder="Doctor bio " class="form-control"  name="bio" cols="50"></textarea>
                                            @if ($errors->has('bio'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('bio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                <div class="form-group row">
                                    {{Form::label('address', 'Address', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-md-9">
                                        {{Form::textArea('address',$value=old('address'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Doctor Address','required'=>false])}}
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('photo') ? 'has-error' : '' }}">

                                    <label class="col-md-2 control-label text-right">&nbsp;</label>
                                    <div class="col-3">
                                        {{Form::select('status', [\App\Models\Doctor::ACTIVE  => 'Active' , \App\Models\Doctor::INACTIVE  => 'Inactive'],[], ['class' => 'form-control'])}}
                                        <span>Status</span>

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <?php $max=$maxSerial+1; ?>
                                    <div class="col-md-3">
                                        {{Form::number('sequence',$max, ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                        <span>Sequence</span>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="upload_photo upload icon_upload" for="file">
                                            <!--  -->
                                            <img id="image_load" src="{{asset('images/default/default.png')}}"  style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                            {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                        </label>
                                        <input type="file" id="file" style="display: none;" name="photo" accept="image/*" onchange="photoLoad(this, this.id)" />
                                        @if ($errors->has('photo'))
                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('photo') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" class="btn btn-warning form-footer">Submit</button>

                                </div>
                                <div class="col-2">
                                    <a href="{{url('admin/doctors')}}" class="btn btn-secondary pull-right">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </div>
                {!! Form::close() !!}
                    <!-- end of form -->
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