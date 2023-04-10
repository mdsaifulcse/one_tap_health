@extends('admin.layout.app')
@section('title')
   Edit Hospital | Dashboard
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Edit Hospital </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.hospitals.index')}}" class="btn btn-info btn-sm"  title="Hospital List here"> <i class="icofont icofont-list"></i> Hospital List</a>
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
                        {!! Form::open(array('route' => ['admin.hospitals.update',$data->id],'method'=>'PUT','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Edit hospital data </h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                <i class="icofont icofont-refresh"></i>
                                {{--<i class="icofont icofont-close-circled"></i>--}}
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="login-card0 auth-body0">

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Name</label>
                                        <div class="col-9">
                                            <input type="text" name="name" value="{{old('name',$data->name)}}" required autocomplete="off" class="form-control" placeholder="Hospital Name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('name') }}</strong>
                                        </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Branch</label>
                                        <div class="col-9">
                                            <input type="text" name="branch" value="{{old('branch',$data->branch)}}" required autocomplete="off" class="form-control" placeholder="Hospital Branch">
                                            @if ($errors->has('branch'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('branch') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Contact no</label>
                                        <div class="col-9">
                                            <input type="text" name="contact" value="{{old('contact',$data->contact)}}"  autocomplete="off" class="form-control" placeholder="Your contact">
                                            @if ($errors->has('contact'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('contact') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Service Details</label>
                                        <div class="col-9">

                                            <textarea rows="4" placeholder="Service of Hospital " class="form-control"  name="service_details" cols="50"><?php echo $data->service_details;?></textarea>
                                            @if ($errors->has('service_details'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('service_details') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    {{Form::label('address1', 'Address', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-md-9">
                                        {{Form::textArea('address1',$value=old('address1',$data->address1), ['class' => 'form-control','rows'=>'2','placeholder'=>'Hospital Address','required'=>true])}}
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-2 text-right"></label>
                                    <div class="col-5">
                                        <input type="number" name="latitude" value="{{old('latitude',$data->latitude)}}" step="any" autocomplete="off" class="form-control" placeholder="Enter latitude">
                                        <label class="col-form-label col-2 text-right">Latitude</label>
                                        @if ($errors->has('latitude'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('latitude') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <input type="number" name="longitude" value="{{old('longitude',$data->longitude)}}" step="any" autocomplete="off" class="form-control" placeholder="Enter longitude">
                                        <label class="col-form-label col-2 text-right">Longitude</label>
                                        @if ($errors->has('longitude'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('longitude') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('icon_photo') ? 'has-error' : '' }}">
                                    {{Form::label('icon_photo', 'Photo', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-md-2">
                                        <label class="upload_photo upload icon_upload" for="file">
                                            <!--  -->
                                            @if(!empty($data->photo))
                                                <img id="image_load" src="{{asset($data->photo)}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">

                                            @else
                                                <img id="image_load" src="{{asset('images/default/default.png')}}" style="max-width: 120px;border: 2px dashed #2783bb; cursor: pointer">
                                            @endif
                                            {{--<i class="upload_hover ion ion-ios-camera-outline"></i>--}}
                                        </label>
                                        <input type="file" id="file" style="display: none;" name="photo" accept="image/*" onchange="photoLoad(this, this.id)" />
                                        @if ($errors->has('photo'))
                                            <span class="help-block" style="display:block">
                            <strong>{{ $errors->first('photo') }}</strong>
                        </span>
                                        @endif
                                    </div>
                                    <div class="col-3">

                                        {{Form::select('status', [\App\Models\Category::ACTIVE  => 'Active' , \App\Models\Category::INACTIVE  => 'Inactive',
                                        \App\Models\Category::OTHER  => 'Other'],[$data->status], ['class' => 'form-control'])}}
                                        <span>Status</span>

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <?php $max=$maxSerial+1; ?>
                                    <div class="col-md-3">
                                        {{Form::number('sequence', $value=old('sequence',$data->sequence), ['min'=>'1','max'=>$max,'class' => 'form-control','required'])}}
                                        <span>Hospital Sequence</span>
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
                                    <a href="{{url('admin/hospitals')}}" class="btn btn-secondary pull-right">Cancel</a>
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