@extends('admin.layout.app')
@section('title')
    Payment-Test Order
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
                <h4> Payment for Test Order </h4>
            </div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{url('/')}}">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.test-orders.create')}}" class="btn btn-info btn-sm" title="Create New Hospital"><i class="icofont icofont-plus"></i> Test Order</a>
                        {{--<a href="{{route('admin.test-orders.create')}}" class="btn btn-info btn-sm" title="Create New Hospital"><i class="icofont icofont-plus"></i> Test Order</a>--}}
                    </li>
                </ul>
            </div>
        </div>
        <!-- Page-header end -->
        <!-- Page-body start -->
        <div class="page-body">
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h5>Payment for test order No.: {{$testOrder->order_no}} </h5>
                            <span> </span>
                            <div class="card-header-right">
                                <i class="icofont icofont-rounded-down"></i>
                            </div>
                        </div>
                        <!-- Form -->
                        {!! Form::open(array('route' => 'admin.test-order-manual-payment','class'=>'','files'=>true)) !!}
                        <input type="hidden" name="test_order_id" value="{{$testOrder->id}}">
                        <div class="card-block">

                            <div class="header">
                                <div class="row">
                                    <div class="col-6">
                                        Order No.: #{{$testOrder->order_no}} <br>
                                        Test Date.: {{date('d-M-Y',strtotime($testOrder->test_date))}} <br>
                                        Amount: Tk.{{$testOrder->reconciliation_amount}} <br>
                                        Patient Name: {{$testOrder->patient->name}} <br>
                                        Patient Mobile: {{$testOrder->patient->mobile}} <br>
                                        Patient Address: {{$testOrder->patient->address}} <br>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-right">

                                            Payment Status:
                                            @if($testOrder->payment_status==\App\Models\TestOrder::PARTIALPAYMENT)
                                                <b class="badge badge-warning ">Partial Payment</b>

                                            @elseif($testOrder->payment_status==\App\Models\TestOrder::FULLPAYMENT)
                                                <b class="badge badge-primary">Full Paid</b>
                                            @else
                                                <b class="badge badge-danger ">Due</b>
                                            @endif
                                            <br>
                                            Visit Status:
                                            @if($testOrder->visit_status==\App\Models\TestOrder::YES)
                                                <b class="badge btn-success ">Yes</b>
                                            @else
                                                <b class="badge btn-warning ">No</b>
                                            @endif
                                            <br>
                                            Hospital: {{$testOrder->hospital->name}} <br>
                                            Branch: {{$testOrder->hospital->branch}} <br>
                                            Address: {{$testOrder->hospital->address1}} <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                                    <thead>
                                    <tr class="">
                                        <th width="4">SL.</th>
                                        <th>Test</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @forelse($testOrder->testOrderDetails as $testOrderDetail)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$testOrderDetail->test->title}}</td>
                                            <td>{{$testOrderDetail->price}}</td>
                                            <td>{{$testOrderDetail->discount}}</td>
                                            <td>{{$testOrderDetail->price_after_discount}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center"> No Data Found! </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                            </div>
                            <br>
                            <div class="row ">
                                <div class="col-5">
                                    <div class="table-responsive">
                                        <h5 class="text-center">Amount Details</h5>
                                        <hr>
                                        <table class="table table-striped table-hover table-bordered center_table">
                                            <thead>
                                            <tr class="">
                                                <td>Amount</td>
                                                <th>{{$testOrder->amount}}</th>
                                            </tr>
                                            <tr class="">
                                                <td>Discount (-)</td>
                                                <th>{{$testOrder->discount}}</th>
                                            </tr>
                                            <tr class="">
                                                <td>Service Charge (+)</td>
                                                <th>{{$testOrder->service_charge}}</th>
                                            </tr>

                                            <tr class="">
                                                <th>Total Amount</th>
                                                <th>{{$testOrder->reconciliation_amount}}</th>
                                            </tr>

                                            <tr class="">
                                                <th class="text-success">Total Paid</th>
                                                <th>{{$totalPaymentAmount}}</th>
                                            </tr>
                                            <tr class="">
                                                <th class="text-warning">Total Due</th>
                                                <th>{{$testOrder->reconciliation_amount-$totalPaymentAmount}}
                                                <input type="hidden" id="totalDue" value="{{$testOrder->reconciliation_amount-$totalPaymentAmount}}" disabled/>
                                                </th>
                                            </tr>

                                            </thead>
                                        </table>
                                    </div>
                                </div><!-- end col-5 -->

                                <div class="col-2"></div>

                                <div class="col-5">
                                    <div class="table-responsive">
                                        <h4 class="text-center text-black">Enter Payment Amount</h4>
                                        <hr>
                                        <table class="table table-striped table-hover table-bordered center_table">
                                            <thead>
                                        @if($testOrder->payment_status==\App\Models\TestOrder::FULLPAYMENT)
                                            <tr class="text-success">
                                                <td colspan="2">Full Payment Already Complete </td>
                                            </tr>

                                            @else
                                            <tr class="text-success">
                                                <th class="text-center">Current Pay</th>
                                                <th><input type="number" name="payment_amount" class="form-control" value="0" onchange="calculateCurrentDue(this.value)" onkeyup="calculateCurrentDue(this.value)" min="1" max="{{$testOrder->reconciliation_amount-$totalPaymentAmount}}" required /></th>
                                            </tr>

                                            <tr class="">
                                                <th class="text-danger text-center">Current Due</th>
                                                <th><input type="number"  id="currentDue" class="form-control" value="0" min="0" disabled /></th>
                                            </tr>

                                            <tr class="">
                                                <td colspan="2"> <button class="btn btn-success btn-block">Submit</button> </td>
                                            </tr>
                                            @endif

                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    {!! Form::close() !!}
                    <!-- end of form -->
                    </div>
                </div>
            </div>


            <!-- Table header styling table end -->
        </div>
        <!-- Page-body end -->
    </div>

@endsection

@section('script')

    <script>
        function calculateCurrentDue(currentPayment) {
            console.log(currentPayment)
            var lastTotalDue=$('#totalDue').val()
            var currentDue= parseInt(lastTotalDue) -parseInt(currentPayment)

            $('#currentDue').val(currentDue)
        }

    </script>

@endsection
