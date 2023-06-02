@extends('admin.layout.app')
@section('title')
    Add doctor to hospital | Dashboard
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/assets/pages/data-table/css/buttons.dataTables.min.css')}}">
    <style>
        #dom-jqry_wrapper{
            padding:10px;
        }
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
                <h4>Add doctor to hospital : {{$hospital->name}}, Branch: {{$hospital->branch}}, {{$hospital->address}}  </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        {{--<a href="{{route('admin.doctors.create')}}" class="btn btn-info btn-sm" title="Create New Doctor"><i class="icofont icofont-plus"></i> Doctor</a>--}}
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
                    {!! Form::open(array('route' => 'admin.hospital-wise-doctor-schedule.store','class'=>'','files'=>true)) !!}

                    <div class="card">
                        <div class="card-header">
                            <h5>Doctor Schedule & Visit fee Details</h5>
                            <span></span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down icon-up"></i>
                                {{--<i class="icofont icofont-refresh"></i>--}}
                                {{--<i class="icofont icofont-close-circled"></i>--}}
                            </div>
                        </div>
                        <div class="card-block " style="display: block;">

                            <div class="login-card0 auth-body0">

                                <div class="form-group row justify-content-center">

                                    <div class="col-10">
                                        <label class="col-form-label text-right">Doctor <sup class="text-danger">*</sup></label>
                                        <input type="hidden" name="hospital_id" value="{{$hospital->id}}"/>
                                        {{Form::select('doctor_id',[],[], ['class' => 'form-control js-data-example-ajax','placeholder'=>'Select one','multiple'=>false,'required'=>true])}}

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
                                        <input type="number" name="doctor_fee" value="{{old('doctor_fee')}}" min="0" max="999999" autocomplete="off" class="form-control" required placeholder="0.0">
                                        @if ($errors->has('doctor_fee'))
                                            <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('doctor_fee') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <label class="col-form-label text-right">Fee Discount</label>
                                        <input type="number" name="discount" value="{{old('discount',0)}}"  min="0" max="999999" autocomplete="off" class="form-control" placeholder="Fee Discount">
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
                                        <input type="time" name="available_from" value="{{old('available_from')}}"  autocomplete="off" class="form-control" required>
                                        @if ($errors->has('available_from'))
                                            <span class="help-block">
                                        <strong class="text-danger text-center">{{ $errors->first('available_from') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <label class="col-form-label text-right">Available To <sup class="text-danger">*</sup></label>
                                        <input type="time" name="available_to" value="{{old('available_to')}}"  autocomplete="off" class="form-control" required>
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
                                        {{Form::select('available_day[]', $availableDys,[], ['class' => 'form-control select2','placeholder'=>'Select one','required'=>true,'multiple'=>true])}}

                                        @if ($errors->has('available_day'))
                                            <span class="help-block">
                                            <strong class="text-danger text-center">{{ $errors->first('available_day') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-5">
                                        <label class="control-label text-right">Status</label>
                                        {{Form::select('status', [\App\Models\HospitalWiseDoctorSchedule::ACTIVE  => 'Active' , \App\Models\HospitalWiseDoctorSchedule::INACTIVE  => 'Inactive'],[], ['class' => 'form-control'])}}

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

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>All Doctors List for {{$hospital->name}}, Branch: {{$hospital->branch}}</h5>
                            <span> </span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                {{--<i class="icofont icofont-refresh"></i>--}}
                                {{--<i class="icofont icofont-close-circled"></i>--}}
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table id="dom-jqry" class="table table-striped table-hover table-bordered center_table">
                                    <thead>
                                    <tr class="">
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Fee</th>
                                        <th>Schedule</th>
                                        <th>Days</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @forelse($hospitalWiseDoctors as $data)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$data->doctor->name}}</td>
                                            <td>{{$data->doctor_fee}}</td>
                                            <td>{{date('h:i:s a', strtotime($data->available_from))}} to {{date('h:i:s a', strtotime($data->available_to))}}</td>

                                            <td><span class="">{{$data->doctorAvailableDay}}</span> </td>

                                            <td>
                                                @if($data->status==\App\Models\HospitalWiseDoctorSchedule::ACTIVE)
                                                    <i class="icofont icofont-check-circled icofont-2x text-success"></i> Active
                                                @elseif($data->status==\App\Models\HospitalWiseDoctorSchedule::INACTIVE)
                                                    <i class="icofont icofont-ui-close text-danger"></i> Inactive
                                                @endif
                                            </td>
                                            <td>{{$data->created_at->diffForHumans()}} </td>
                                            <td>
                                                {!! Form::open(array('route' => ['admin.hospital-wise-doctor-schedule.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}

                                                <a href="{{route('admin.hospital-wise-doctor-schedule.edit',$data->id) }}" class="btn btn-success btn-sm" title="Click here for edit hospital data"><i class="icofont icofont-edit"></i> </a>
                                                <button type="button" class="btn btn-danger btn-sm" onclick='return deleteConfirm("deleteForm{{$data->id}}")'><i class="icofont icofont-trash"></i></button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> No Data Found! </td>
                                        </tr>
                                    @endforelse


                                    </tbody>
                                </table>
                                {{$hospitalWiseDoctors->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Table header styling table end -->
        </div>
        <!-- Page-body end -->
    </div>


    <!-- Modal -->
    <div id="testPriceModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >

            <!-- Modal content-->
            <div class="modal-content" id="testPriceModalContent">
              <!-- content-->
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('admin/assets/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/assets/js/jquery.quicksearch.js')}}"></script>
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
                     url: "{{url('/api/v1/client/search-active-doctors')}}",
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

                    var markup ="<div class='select2-result-repository__title'>" + result.name + "</div>";
                    return markup;
                },
                templateSelection: function(result) {
                    return result.name || 'Search Doctor';
                }
            });


        });


    </script>

    <script src="{{asset('admin/assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/assets/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('admin/assets/pages/data-table/js/data-table-custom.js')}}"></script>
    <script type="text/javascript">
        function showTestPriceModal(hospitalId) {

            $('#testPriceModalContent').html('<center><img src=" {{asset('images/default/loading.gif')}}"/></center>')
                    .load('{{URL::to("admin/set-test-price")}}/'+hospitalId);

            $('#testPriceModal').modal('show')
        }

    </script>
@endsection