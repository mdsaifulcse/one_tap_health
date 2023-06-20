
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
                            Patient Name: {{$testOrder->patient_name}} <br>
                            Patient Mobile: {{$testOrder->patient_mobile}} <br>
                            Patient Address: {{$testOrder->patient_address}} <br>
                        </div>
                        <div class="col-6">
                            <div class="text-right">

                                Payment Status:
                                @if($testOrder->payment_status==\App\Models\TestOrder::PARTIALPAYMENT)
                                    <span class="badge badge-warning ">Partial Payment</span>

                                @elseif($testOrder->payment_status==\App\Models\TestOrder::FULLPAYMENT)
                                    <span class="badge badge-success ">Full Paid</span>
                                @else
                                    <span class="badge badge-danger ">Due</span>
                                @endif
                                <br>
                                Visit Status:
                                @if($testOrder->visit_status==\App\Models\TestOrder::YES)
                                    <span class="badge btn-success ">Yes</span>
                                @else
                                    <span class="badge btn-warning ">No</span>
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

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @forelse($testOrder->testOrderDetails as $testOrderDetail)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$testOrderDetail->test->title}}</td>
                                    <td>{{$testOrderDetail->price}}</td>
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
