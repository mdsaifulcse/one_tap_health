@extends('admin.layout.app')
@section('title')
   Create Test Order | Dashboard
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
                <h4>Create Test Order </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/admin/dashboard')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">

                        <a href="{{route('admin.test-orders.index')}}" class="btn btn-info btn-sm"  title="Order List here"><i class="icofont icofont-list"></i> Test Order List</a>
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
                        {!! Form::open(array('route' => 'admin.test-orders.store','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Create new Test Order</h5>
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
                                        <label class="col-form-label col-1 text-right"> </label>
                                        <div class="col-5">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input patient_state" type="radio" name="patient_state" id="new_patient" value="new_patient">
                                                <label class="form-check-label" for="new_patient" style="margin-right: 25px;">New Patient</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input patient_state" type="radio" name="patient_state" id="existing_patient" checked value="existing_patient">
                                                <label class="form-check-label" for="existing_patient">Existing patient</label>
                                            </div>
                                        </div>
                                        {{Form::label('Test Date', 'Test Date:', array('class' => 'col-md-2 control-label text-right'))}}
                                        <div class="col-md-3">
                                            {{Form::date('test_date',$value=old('test_date'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Test Date','required'=>true])}}
                                            @if ($errors->has('test_date'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('test_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                <div class="patient-area" style="display: none;">

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Name <sup class="text-danger">*</sup> </label>
                                        <div class="col-9">
                                            <input type="text" name="patient_name" value="{{old('patient_name')}}" autocomplete="off" class="form-control patient_name" placeholder="Patient Name">
                                            @if ($errors->has('patient_name'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Age <sup class="text-danger">*</sup></label>
                                        <div class="col-9">
                                            <input type="text" name="patient_age" value="{{old('patient_age')}}" autocomplete="off" class="form-control patient_age" placeholder="Patient age">
                                            @if ($errors->has('patient_age'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_age') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Mobile</label>
                                        <div class="col-9">
                                            <input type="text" name="patient_mobile" value="{{old('patient_mobile')}}"  autocomplete="off" class="form-control patient_mobile" placeholder="Patient Mobile">
                                            @if ($errors->has('patient_mobile'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_mobile') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Address <sup class="text-danger">*</sup></label>
                                        <div class="col-md-9">
                                            {{Form::textArea('patient_address',$value=old('patient_address'), ['class' => 'form-control patient_address','rows'=>'2','placeholder'=>'Patient Address','required'=>false])}}
                                            @if ($errors->has('patient_address'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('patient_address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="patient-search">
                                    <div class="form-group row" >
                                        <label class="col-form-label col-2 text-right"> </label>

                                        <div class="col-5">
                                            {{Form::label('Patient', 'Patient:', array('class' => 'control-label text-right'))}}
                                            {{Form::select('patient_id',[],[], ['class' => 'form-control search-patient-data','id'=>'patientId','placeholder'=>'Search Patient','multiple'=>false,'required'=>true])}}
                                            @if ($errors->has('patient_id'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('patient_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-4">

                                            {{Form::label('Refer By', 'Refer By:', array('class' => ' control-label text-right'))}}
                                            {{Form::select('refer_by_id',[],[], ['class' => 'form-control search-user-data','id'=>'referById','placeholder'=>'Search user','multiple'=>false,'required'=>false])}}

                                            @if ($errors->has('patient_id'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_id') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{Form::label('Hospital', 'Hospital', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-9">

                                        {{Form::select('hospital_id',[],[], ['class' => 'form-control search-hospital-data','id'=>'hospitalId','placeholder'=>'Select one','multiple'=>false,'required'=>true])}}

                                        @if ($errors->has('hospital_id'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('hospital_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{Form::label('Test Details', 'Test Details', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-9">
                                        <div class="table-responsive" id="hospitalWiseTestDetails">
                                        </div>
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
                                    <a href="{{url('admin/test-orders')}}" class="btn btn-secondary pull-right">Cancel</a>
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

            $('.patient_state').on('click',function () {
                var patientState=$(this).val()
                if (patientState==='new_patient'){
                    $('.patient-area').css('display','block')
                    $('.patient-search').css('display','none')

                    $('.patient_name').attr('required',true)
                    $('.patient_age').attr('required',true)
                    $('.patient_address').attr('required',true)
                    $('#patientId').attr('required',false)

                }else {
                    $('.patient-area').css('display','none')
                    $('.patient-search').css('display','block')

                    $('.patient_name').attr('required',false)
                    $('.patient_age').attr('required',false)
                    $('.patient_address').attr('required',false)
                    $('#patientId').attr('required',true)
                }
            })

//            $('.select2').select2({
//                placeholder: 'Select an option'
//            });

            // Search active user (refered by) -------------------
            $(".search-user-data").select2({
                tags: true,
                closeOnSelect: true,
                multiple:false,
                placeholder: 'Select an option',
                ajax: {
                    url: "{{url('/api/v1/client/search-active-users')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params)
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
                        //params.page = params.page || 1;
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

                    var markup ="<div class='select2-result-repository__title'>" + result.name +' ('+result.phone +')' + "</div>";
                    return markup;
                },
                templateSelection: function(result) {
                    return result.name || 'Search user';
                }
            });


            // Search active Patients -------------------
            $(".search-patient-data").select2({
                tags: true,
                closeOnSelect: true,
                multiple:false,
                placeholder: 'Select an option',
                ajax: {
                    url: "{{url('/api/v1/client/search-active-patients')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params)
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
                        //params.page = params.page || 1;
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

                    var markup ="<div class='select2-result-repository__title'>" + result.name +' ('+result.patient_no +')' + "</div>";
                    return markup;
                },
                templateSelection: function(result) {
                    return result.name || 'Search Patient';
                }
            });


            // Search active hospital -------------------
            $(".search-hospital-data").select2({
                tags: true,
                closeOnSelect: true,
                multiple:false,
                placeholder: 'Select an option',
                ajax: {
                    url: "{{url('/api/v1/client/search-active-hospitals')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log(params)
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
                        //params.page = params.page || 1;
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

                    var markup ="<div class='select2-result-repository__title'>" + result.name +' ('+result.branch +')' + "</div>";
                    return markup;
                },
                templateSelection: function(result) {
                    return result.name || 'Search Hospital';
                }
            });


        });


    </script>

    <script>
        "use strict";
        $(document).ready(function(){
            var hospitalId=0;
           $('#hospitalId').on('change',function () {
               hospitalId=$('#hospitalId').val();
               $('#hospitalWiseTestDetails').empty().html('<center><img src=" {{asset('images/default/loading.gif')}}"/></center>')
                   .load('{{URL::to("admin/load-hospital-wise-test-details")}}/'+hospitalId);
           })
        });
    </script>
@endsection