@extends('admin.layout.app')
@section('title')
   Edit doctor for hospital | Dashboard
@endsection
@section('style')

    <style>
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
                <h4>Edit doctor for hospital : {{$hospitalWiseDoctor->hospital->name}}, Branch: {{$hospitalWiseDoctor->hospital->branch}}, {{$hospitalWiseDoctor->hospital->address}}  </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.hospital-wise-doctor-schedule.index',['hospital_id'=>$hospitalWiseDoctor->hospital_id])}}" class="btn btn-info btn-sm"  title="Back"><i class="icofont icofont-double-left"></i> Back</a>
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
                        {!! Form::open(array('route' => ['admin.hospital-wise-doctor-schedule.update',$hospitalWiseDoctor->id],'method'=>'PUT','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Doctor Schedule & Visit fee Details</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                {{--<i class="icofont icofont-refresh"></i>--}}
                                {{--<i class="icofont icofont-close-circled"></i>--}}
                            </div>
                        </div>
                        <div class="card-block ">

                            <div class="login-card0 auth-body0">

                                <div class="form-group row justify-content-center">

                                    <div class="col-10">
                                        <label class="col-form-label text-right">Doctor <sup class="text-danger">*</sup></label>
                                        <input type="hidden" name="hospital_id" value="{{$hospitalWiseDoctor->hospital->id}}"/>

                                        {{Form::select('doctor_id', [],[], ['class' => 'form-control js-data-example-ajax','placeholder'=>'Select one','required'=>false])}}
                                        @if ($errors->has('doctor_id'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('doctor_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">

                                    <div class="col-5">
                                        <label class="col-form-label text-right">Visit Fee (tk) <sup class="text-danger">*</sup></label>
                                        <input type="number" name="doctor_fee" value="{{old('doctor_fee',$hospitalWiseDoctor->doctor_fee)}}"  autocomplete="off" class="form-control" required placeholder="Doctor Visit fee">
                                        @if ($errors->has('doctor_fee'))
                                            <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('doctor_fee') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <label class="col-form-label text-right">Fee Discount</label>
                                        <input type="number" name="discount" value="{{old('discount',$hospitalWiseDoctor->discount??0)}}"  autocomplete="off" class="form-control" placeholder="Fee Discount">
                                        @if ($errors->has('discount'))
                                            <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('discount') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">

                                    <div class="col-5">
                                        <label class="col-form-label text-right">Available From <sup class="text-danger">*</sup></label>
                                        <input type="time" name="available_from" value="{{old('available_from',$hospitalWiseDoctor->available_from)}}"  autocomplete="off" class="form-control" required>
                                        @if ($errors->has('available_from'))
                                            <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('available_from') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <label class="col-form-label text-right">Available To <sup class="text-danger">*</sup></label>
                                        <input type="time" name="available_to" value="{{old('available_to',$hospitalWiseDoctor->available_to)}}"  autocomplete="off" class="form-control" required>
                                        @if ($errors->has('available_to'))
                                            <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('available_to') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row justify-content-center">
                                    <div class="col-5">
                                        <label class="col-form-label text-right">Available days <sup class="text-danger">*</sup></label>
                                        {{Form::select('available_day[]', $availableDys,json_decode($hospitalWiseDoctor->available_day), ['class' => 'form-control select2','placeholder'=>'Select one','required'=>true,'multiple'=>true])}}

                                        @if ($errors->has('available_day'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('available_day') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <label class="control-label text-right">Status</label>
                                        {{Form::select('status', [\App\Models\HospitalWiseDoctorSchedule::ACTIVE  => 'Active' , \App\Models\HospitalWiseDoctorSchedule::INACTIVE  => 'Inactive'],$hospitalWiseDoctor->status, ['class' => 'form-control'])}}

                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>


                                </div>


                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">

                                <div class="col-10">
                                    <button type="submit" class="btn btn-warning form-footer">Save</button>

                                </div>
                                <div class="col-2">
                                    <a href="{{route('admin.hospital-wise-doctor-schedule.index',['hospital_id'=>$hospitalWiseDoctor->hospital_id])}}" class="btn btn-secondary pull-right">Cancel</a>
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
    <!-- Multiselect js -->
    <script>
        "use strict";
        $(document).ready(function(){
            $('.select2').select2({
                placeholder: 'Select an option'
            });

            $(".js-data-example-ajax").select2(
                {
                tags: true,
                closeOnSelect: true,
                multiple:false,
               // select:'Doctor 1',
                ajax: {
                    url: "{{url('/api/v1/client/search-active-doctors')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                        };
                    },
                    processResults: function(data, params) {
                        //return console.log(params)
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        return {
                            results: data.result,
                        };
                    },
                    cache: true
                },
                escapeMarkup: function(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: function(result) {
                    if (result.loading) return 'Loading';
                    var markup ="<div class='select2-result-repository__title'>" + result.name + "</div>";
                    return markup;
                },
                templateSelection: function(result) {
                    return result.name || "{{$hospitalWiseDoctor->doctor->name}}";
                }
            });


        });
    </script>

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