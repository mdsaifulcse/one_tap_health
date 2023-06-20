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

                        <a href="{{route('admin.test-orders.index')}}" class="btn btn-info btn-sm"  title="Hospital List here"><i class="icofont icofont-list"></i> Test Order List</a>
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
                                        <label class="col-form-label col-2 text-right">Patient Name</label>
                                        <div class="col-9">
                                            <input type="text" name="patient_name" value="{{old('patient_name')}}" required autocomplete="off" class="form-control" placeholder="Patient Name">
                                            @if ($errors->has('patient_name'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_name') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-2 text-right">Patient Mobile</label>
                                        <div class="col-9">
                                            <input type="text" name="patient_mobile" value="{{old('patient_mobile')}}" required autocomplete="off" class="form-control" placeholder="Patient Mobile">
                                            @if ($errors->has('patient_mobile'))
                                                <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('patient_mobile') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {{Form::label('patient_address', 'Patient Address', array('class' => 'col-md-2 control-label text-right'))}}
                                        <div class="col-md-9">
                                            {{Form::textArea('patient_address',$value=old('patient_address'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Hospital Address','required'=>true])}}
                                            @if ($errors->has('patient_address'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('patient_address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{Form::label('Test Date', 'Test Date', array('class' => 'col-md-2 control-label text-right'))}}
                                        <div class="col-md-9">
                                            {{Form::date('test_date',$value=old('test_date'), ['class' => 'form-control','rows'=>'2','placeholder'=>'Test Date','required'=>true])}}
                                            @if ($errors->has('test_date'))
                                                <span class="help-block">
                                                <strong class="text-danger text-center">{{ $errors->first('test_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                <div class="form-group row">
                                    {{Form::label('Hospital', 'Hospital', array('class' => 'col-md-2 control-label text-right'))}}
                                    <div class="col-9">

                                        {{Form::select('hospital_id',[],[], ['class' => 'form-control js-data-example-ajax','id'=>'hospitalId','placeholder'=>'Select one','multiple'=>false,'required'=>true])}}

                                        @if ($errors->has('doctor_id'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('doctor_id') }}</strong>
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
            $('.select2').select2({
                placeholder: 'Select an option'
            });

            $(".js-data-example-ajax").select2({
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
                        console.log(data.result);
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