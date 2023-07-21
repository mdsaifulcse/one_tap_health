@extends('admin.layout.app')
@section('title')
    Patient List
@endsection

@section('style')
    {{--<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/pages/data-table/css/buttons.dataTables.min.css')}}">--}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <style>
        .dropdown-menu li a{
            margin-bottom: 2px;
        }
        .dataTables_wrapper {
            padding:10px;
        }
        /*#dom-jqry_filter{*/
            /*margin-top:-28px;*/
        /*}*/
        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%;
            }
        }
    </style>
@endsection
@section('main-content')
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-header-title">
                <h4>Patient List </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.patients.create')}}" class="btn btn-info btn-sm" title="Create New Hospital"><i class="icofont icofont-plus"></i> Patient</a>
                        {{--<a href="{{route('admin.test-orders.create')}}" class="btn btn-info btn-sm" title="Create New Hospital"><i class="icofont icofont-plus"></i> Test Order</a>--}}
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
                            <h5>All Patient List</h5>
                            <span> </span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                                {{--<i class="icofont icofont-refresh"></i>--}}
                                {{--<i class="icofont icofont-close-circled"></i>--}}
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="datatable-ajax table table-striped table-hover table-bordered center_table">
                                    <thead>
                                    <tr class="">
                                        <th>SL</th>
                                        <th>Patient ID.</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Control</th>
                                    </tr>
                                    </thead>
                                </table>
                                {{--{{$testOrders->links()}}--}}
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
    <div id="testOrderDetailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content" id="modalContent">
              <!-- content-->
            </div>

        </div>
    </div>
@endsection

@section('script')
    {{--<script src="{{asset('admin/assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--<script src="{{asset('admin/assets/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>--}}
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    {{--<script src="{{asset('admin/assets/pages/data-table/js/data-table-custom.js')}}"></script>--}}

    <script>
        var table = null;
        $(function() {
            table= $('.datatable-ajax').DataTable( {
                processing: true,
                serverSide: true,
                "lengthMenu": [[50, 100, 200,500, -1], [50, 100, 200, 500,"All"]],

                ajax: {
                    url: window.location.href,
                    data: function (d) {
                        console.log(d)
                    },
                },
                order: [[6, "DESC"]],
                columns: [
                    { data: 'DT_RowIndex',orderable:false},
                    { data: 'patient_no',name:'patients.patient_no'},
                    { data: 'name',name:'patients.name'},
                    { data: 'mobile',name:'patients.mobile'},
                    { data: 'email',name:'patients.email'},
                    { data: 'age',name:'patients.age'},
                    { data: 'status',name:'patients.status'},
                    { data: 'created_at',name:'patients.created_at'},
                    { data: 'control'},
                ]
            });
        });
    </script>

    <script type="text/javascript">
        function showTestOrderDetailsModal(testOrderId) {
            console.log(testOrderId);

            $('#modalContent').html('<center><img src=" {{asset('images/default/loading.gif')}}"/></center>')
                .load('{{URL::to("admin/patients")}}/'+testOrderId);

            $('#testOrderDetailsModal').modal('show')
        }

    </script>
@endsection