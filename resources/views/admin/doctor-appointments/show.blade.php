
<div class="modal-header">
    <h4 class="modal-title">Test Order Details</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="row justify-content-center">
        <div class="col-md-12 ">

            <div class="card">
                <div class="card-header">
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
                <div class="card-block table-border-style">
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
                    <div class="row justify-content-end">
                        <div class="col-5">
                             <div class="table-responsive">
                                 <table class="table table-striped table-hover table-bordered center_table">
                                     <thead>
                                     <tr class="">
                                         <th>Amount</th>
                                         <th>{{$testOrder->amount}}</th>
                                     </tr>
                                     <tr class="">
                                         <th>Discount (-)</th>
                                         <th>{{$testOrder->discount}}</th>
                                     </tr>
                                     <tr class="">
                                         <th>Service Charge (+)</th>
                                         <th>{{$testOrder->service_charge}}</th>
                                     </tr>
                                     <tr class="">
                                         <th>Total Amount</th>
                                         <th>{{$testOrder->reconciliation_amount}}</th>
                                     </tr>
                                     </thead>
                                 </table>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
