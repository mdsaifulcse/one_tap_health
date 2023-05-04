@extends('admin.layout.app')
@section('title')
    Hospital List
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
    </style>
@endsection
@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Doctors List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.doctors.create')}}" class="btn btn-info btn-sm" title="Create New Doctor"><i class="icofont icofont-plus"></i> Doctor</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>All Doctors List</h5>
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
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Degree</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @forelse($doctors as $data)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->mobile}}</td>
                                            <td>{{$data->email??'N/A'}}</td>
                                            <td>{{ucfirst($data->department)}}</td>
                                            <td>{{ucfirst($data->degree)}}</td>
                                            <td>
                                                @if($data->status==\App\Models\Doctor::ACTIVE)
                                                    <i class="icofont icofont-check-circled icofont-2x text-success"></i> Active
                                                @elseif($data->status==\App\Models\Doctor::INACTIVE)
                                                    <i class="icofont icofont-ui-close text-danger"></i> Inactive
                                                @endif
                                            </td>
                                            <td>{{$data->created_at->diffForHumans()}} </td>
                                            <td>
                                                {!! Form::open(array('route' => ['admin.doctors.destroy',$data->id],'method'=>'DELETE','id'=>"deleteForm$data->id")) !!}
                                                {{--@if($data->hospital_test_price_count>0)--}}
                                                    {{--<a href="{{route('admin.set-test-price.edit',$data->id) }}" class="btn btn-warning btn-sm" title="Click to Update Test Price"><i class="icofont icofont-money-bag icofont-2x"></i> </a>--}}
                                                    {{--<a href="javascript:void(0)" class="btn btn-info btn-sm" title="Click to View Test Price" onclick="showTestPriceModal({{$data->id}})"><i class="icofont icofont-eye-alt"></i> </a>--}}
                                                {{--@else--}}
                                                    {{--<a href="{{route('admin.set-test-price.create',['hospitalId'=>$data->id]) }}" class="btn btn-info btn-sm" title="Click to set Test Price"><i class="icofont icofont-money-bag icofont-2x"></i> </a>--}}
                                                {{--@endif--}}
                                                <a href="{{route('admin.doctors.edit',$data->id) }}" class="btn btn-success btn-sm" title="Click here for edit hospital data"><i class="icofont icofont-edit"></i> </a>
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
                                {{$doctors->links()}}
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