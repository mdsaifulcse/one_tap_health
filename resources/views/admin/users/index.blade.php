@extends('admin.layout.app')
@section('title')
    Dashboard | Admin
@endsection

@section('style')
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
                <h4> User List </h4>
                <span>There are all approve, rejected followed by pending users list in here</span>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <i class="icofont icofont-plus"></i>
                        <a href="{{route('admin.users.create')}}">Create User</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">

            <div class="card">
                <div class="card-header">
                    <h5>User List</h5>
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
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Control</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tbody>
                            {{--@forelse($users as $key=>$user)--}}
                                {{--<tr>--}}
                                    {{--<th scope="row">{{$key+1}}</th>--}}
                                    {{--<td>{{$user->name}}</td>--}}
                                    {{--<td>{{$user->email}}</td>--}}
                                    {{--<td>{{$user->phone}}</td>--}}
                                    {{--<td>{{$user->approval_status}}</td>--}}
                                    {{--<td>--}}


                                        {{--{{Form::open(array('route'=>['admin.users.destroy',$user->id],'method'=>'DELETE','id'=>"deleteForm$user->id"))}}--}}
                                        {{--<a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-warning btn-sm"> Edit </a>--}}
                                        {{--<a href="javascript:void(0)" id="userDetail" data-userid="{{$user->id}}" class="btn btn-info btn-sm"> Details </a>--}}
                                        {{--<button type="button" class="btn btn-danger btn-sm" onclick="return deleteConfirm('deleteForm{{$user->id}}')">--}}
                                            {{--<i class="icofont icofont-trash"></i>--}}
                                        {{--</button>--}}
                                        {{--{!! Form::close() !!}--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@empty--}}
                                {{--<tr>--}}
                                    {{--<th colspan="6" class="text-center text-danger">No Data Found</th>--}}
                                {{--</tr>--}}
                            {{--@endforelse--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- Page-body end -->
    </div>


    <!-- Modal -->
    <div id="userDetailModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content" id="modalContent">

            </div>

        </div>
    </div>


@endsection

@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

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
                    { data: 'name',name:'users.name'},
                    { data: 'email',name:'users.email'},
                    { data: 'phone',name:'users.phone'},
                    { data: 'age',name:'users.age'},
                    { data: 'status',name:'users.approval_status'},
                    { data: 'created_at'},
                    { data: 'control'},
                ]
            });
        });
    </script>

    <script>
        function showUserDetailsModal(userId) {


            $('#userDetailModal').modal('show')
            $('#modalContent').load('{{URL::to("admin/users")}}/'+userId);

            //$('#userDetailModalBody').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{url('admin/users')}}/'+userId);
        }

        {{--$('#userDetail').on('click',function () {--}}

            {{--$('#userDetailModal').modal('show')--}}
            {{--var userId=$(this).data('userid')--}}
            {{--$('#modalContent').load('{{URL::to("admin/users")}}/'+userId);--}}

            {{--//$('#userDetailModalBody').html('<center><img src=" {{asset('images/default/loader.gif')}}"/></center>').load('{{url('admin/users')}}/'+userId);--}}
        {{--})--}}
    </script>

@endsection