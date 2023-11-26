@extends('admin.layout.app')
@section('title')
    Create Hospital | Dashboard
@endsection

@section('style')
    <style>
        #dom-jqry_filter{
            margin-top:-28px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            background-color: white;
            color: #000000;
        }
        .select2-results__option:first-child{
            display: none;
        }
    </style>
@endsection

@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Create Hospital </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.hospitals.index')}}" class="btn btn-info btn-sm"  title="Hospital List here"><i class="icofont icofont-list"></i> Hospital List</a>
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
                    {!! Form::open(array('route' => 'admin.hospitals.store','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Create new hospital</h5>
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
                                    <label for="example-text-input" class="col-2 text-right col-form-label">District<sup class="text-danger">*</sup></label>
                                    <div class="col-4">
                                        {!! Form::select('district_id',$districts,[], ['id'=>'loadZoneArea','placeholder' => '--Select District --','class' => 'form-control select2','required'=>true]) !!}

                                        @if ($errors->has('district_id'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('district_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <label for="example-text-input" class="col-1 text-right col-form-label">Area<sup class="text-danger">*</sup></label>
                                    <div class="col-4" id="zoneAreaList">
                                        {!! Form::select('zone_area_id',[],[], ['placeholder' => '--Select Area --','class' => 'form-control select2','required'=>true]) !!}

                                        @if ($errors->has('zone_area_id'))
                                            <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('zone_area_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-2 text-right">Name</label>
                                    <div class="col-9">
                                        <input type="text" name="name" value="{{old('name')}}" required autocomplete="off" class="form-control" placeholder="Hospital Name">
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
                                        <input type="text" name="branch" value="{{old('branch')}}" required autocomplete="off" class="form-control" placeholder="Hospital Branch">
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
                                        <input type="text" name="contact" value="{{old('contact')}}"  autocomplete="off" class="form-control" placeholder="Your contact">
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

                                        <textarea rows="4" placeholder="Service of Hospital " class="form-control"  name="service_details" cols="50"></textarea>
                                        @if ($errors->has('service_details'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('service_details') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('photo') ? 'has-error' : '' }}">

                                    <label class="col-md-2 control-label text-right">&nbsp;</label>
                                    <div class="col-3">
                                        {{Form::select('status', [\App\Models\Category::ACTIVE  => 'Active' , \App\Models\Category::INACTIVE  => 'Inactive',
                                     \App\Models\Category::OTHER  => 'Other'],[], ['class' => 'form-control'])}}
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
                                        <span>Hospital Sequence</span>
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

                                <div class="form-group row">
                                    {{Form::label('address1', 'Address', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-md-9">
                                        {{Form::textArea('address1',$value=old('address1'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Hospital Address','required'=>true])}}
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{Form::label('Map', 'Map', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-9">
                                        <div id="map" style="height: 400px;">


                                        </div>
                                        <input type="hidden" name="latitude" value="{{old('latitude')}}" id="lat" step="any" />
                                        <input type="hidden" name="longitude" value="{{old('longitude')}}" id="lng" step="any"/>
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
    <script type="text/javascript" src="{{asset('admin/assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

    <script>
        // Search active Patients -------------------
        $(".select2").select2({
            tags: true,
            closeOnSelect: true,
            multiple:false,
            placeholder: 'Select an option',
        });
    </script>

    {{--Load ZoneArea--}}
    <script>
        $('#loadZoneArea').on('change',function () {

            var districtId=$(this).val()

            if(districtId.length===0)
            {
                districtId=0
                $('#zoneAreaList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("admin/load-area-by-district")}}/'+districtId);

            }else {

                $('#zoneAreaList').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{URL::to("admin/load-area-by-district")}}/'+districtId);
            }
        })
    </script>


    <script type="text/javascript">
        function initialize() {

            let defaultLatLon={ lat: 23.81887249514827, lng: 90.4096518108767 };
            let map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLatLon,
                zoom: 10,
            });

            // Show default marker ----------------
            let marker=new google.maps.Marker({
                position: defaultLatLon,
                map,
                title: "",
                zoom:10
            });

            // get Lat, Lng on Click ------------------------
            map.addListener('click',(mapsMouseEvent)=>{
                // get & set lan, Lng for saving -------
                let selectedLatLon=mapsMouseEvent.latLng.toJSON();
            $('#lat').val((selectedLatLon.lat))
            $('#lng').val((selectedLatLon.lng))

            // change marker position ----------
            var latlng = new google.maps.LatLng(selectedLatLon.lat, selectedLatLon.lng);

            marker.setPosition(latlng);

        })


        }

        //initialize();
    </script>
    <script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&region=BD&language=en&libraries=places&callback=initialize"  > </script>

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