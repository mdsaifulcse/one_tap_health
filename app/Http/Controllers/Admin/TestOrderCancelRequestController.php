<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestOrder;
use App\Models\TestOrderCancelRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Validator,MyHelper,DB,Yajra\DataTables\DataTables;

class TestOrderCancelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $allData=DB::table('test_order_cancel_requests')
                ->leftJoin('test_orders',function ($join){
                    $join->on('test_orders.id','=','test_order_cancel_requests.test_order_id');
                })->leftjoin('hospitals',function ($join){
                    $join->on('hospitals.id','=','test_orders.hospital_id');
                })
               ->leftjoin('patients',function ($join){
                   $join->on('patients.id','=','test_orders.patient_id');
               })
                ->select('test_orders.id','test_orders.order_no','test_orders.payment_status','test_orders.reconciliation_amount','patients.id','patients.name as patient_name',
                    'patients.mobile','hospitals.id','hospitals.id','hospitals.name as hospital_name','test_order_cancel_requests.*');

            //$allData=TestOrderCancelRequest::with('testOrder:id,order_no','testOrder.hospital:id,name','testOrder.patient:id,name,email,mobile');

            return  DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
//                ->addColumn('hospitals_name',
//                    '$hospital_name??\'N/A\''
//                )
//                ->addColumn('patient_name','$patient_name??\'N/A\'')
//                ->addColumn('patient_mobile','$mobile??\'N/A\'')
                ->addColumn('cancel_status','
                <a href="#"
                 data-toggle="modal" data-target="#cancelStatusModal{{$id}}" 
                
                 title="Click for changing status"> 
                     @if($cancel_status==\App\Models\TestOrderCancelRequest::PENDING)
                        <button class="btn btn-warning btn-sm">Pending</button>
                        
                            @else
                            <button class="btn btn-success btn-sm">Approved</button>
                        @endif
                 </a>
                 
                     <!-- Modal -->
                      <div class="modal fade" id="cancelStatusModal{{$id}}" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          {!! Form::open(array(\'route\' => [\'admin.test-order-cancel-request.update\', $id],\'method\'=>\'PUT\',\'class\'=>\'kt-form kt-form--label-right\',\'files\'=>true)) !!}
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class ="modal-title text-danger">Are sure to change <span style=\'color:#000\'>CANCEL</span> status?</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                               <div class="form-group row">
                                    
                                    <div class="col-md-10">
                                        {{Form::select(\'cancel_status\', [\App\Models\TestOrderCancelRequest::PENDING  => \'Pending\' , \App\Models\TestOrderCancelRequest::APPROVED  => \'Approved\'],[$cancel_status], [\'class\' => \'form-control\'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="display:block;">
                              <button type="submit" class="btn btn-warning pull-left"  onclick="return confirm(\'Are you sure? You can not revert the status.\')">Save    </button>
                            </div>
                          </div>
                           {!! Form::close() !!}
                          
                        </div>
                      </div>
                ')
                ->addColumn('refund_status','
                <a href="#"
                 data-toggle="modal" data-target="#refundStatusModal{{$id}}" 
                
                 title="Click for changing status"> 
                 @if($payment_status==\App\Models\TestOrder::DUEPAYMENT)
                  <button class="btn btn-sm">Not Refundable</button>
                 @else
                   @if($refund_status==\App\Models\TestOrderCancelRequest::NOTREFUNDED)
                        <button class="btn btn-default btn-sm">Not Refund</button>
                        
                        @elseif($refund_status==\App\Models\TestOrderCancelRequest::REFUNDED)
                        <button class="btn btn-success btn-sm">Refund</button>
                            @else
                            <button class="btn btn-default btn-sm">Something Wrong</button>
                        @endif
                 @endif
                 </a>
                 
                  @if($payment_status!=\App\Models\TestOrder::DUEPAYMENT)
                     <!-- Modal -->
                      <div class="modal fade" id="refundStatusModal{{$id}}" role="dialog">
                        <div class="modal-dialog">
                        
                          <!-- Modal content-->
                          {!! Form::open(array(\'route\' => [\'admin.changeRefundStatus\', $id],\'method\'=>\'PUT\',\'class\'=>\'kt-form kt-form--label-right\',\'files\'=>false)) !!}
                          {{Form::hidden(\'id\',$value=$id)}}
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class ="modal-title text-danger">Are sure to change <span style=\'color:#000\'>Refund</span> status?</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                               <div class="form-group row">
                                    
                                    <div class="col-md-5">
                                        <label>Refund Status</label>
                                        {{Form::select(\'refund_status\', [\App\Models\TestOrderCancelRequest::NOTREFUNDED  => \'Not Refund\' , \App\Models\TestOrderCancelRequest::REFUNDED  => \'Refund\'],[$refund_status], [\'class\' => \'form-control refund-status\'])}}
                                    </div>
                                     <div class="col-md-5">
                                        <label>Refund Amount</label>
                                         {{Form::number(\'refund_amount\',$value=$refund_amount,[\'class\' => \'form-control custom-selectbox\',\'min\' => \'1\',\'required\'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="display:block;">
                              <button type="submit" class="btn btn-warning pull-left"  onclick="return confirm(\'Are you sure?\')">Save    </button>
                            </div>
                          </div>
                           {!! Form::close() !!}
                          
                        </div>
                      </div>
                      @endif
                ')
                ->addColumn('payment_status',
                    '@if($payment_status==\App\Models\TestOrder::PARTIALPAYMENT)
                        <button class="btn btn-warning btn-sm">Partial</button>
                        
                        @elseif($payment_status==\App\Models\TestOrder::FULLPAYMENT)
                        <button class="btn btn-success btn-sm">Full</button>
                            @else
                            <button class="btn btn-danger btn-sm">Due</button>
                        @endif'
                )
                ->addColumn('created_at','
                    {{date(\'M-d-Y\',strtotime($created_at))}}
                ')
                ->addColumn('control','
                    <span class=\'dropdown\'>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                           
                            <li><a href="javascript:void(0)" onclick="showTestOrderDetailsModal({{$test_order_id}})" class="btn btn-success btn-sm" title="Click here for order details">Order Details <i class="icofont icofont-eye"></i> </a></li>
                           
                            @if($cancel_status==\App\Models\TestOrderCancelRequest::NOTREFUNDED)
                            <li>
                                {!! Form::open(array(\'route\' => [\'admin.test-order-cancel-request.destroy\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}
                                <button type="button" class="btn btn-danger btn-sm" onclick=\'return deleteConfirm("deleteForm{{$id}}")\'>Delete <i class="icofont icofont-trash"></i></button>
                                {!! Form::close() !!}
                            </li>
                            @endif
                            
                        </ul>
                    </span>
                ')

                ->rawColumns(['hospitals_name','patient_name','patient_mobile','cancel_status','refund_status','payment_status','created_at','control'])
                ->toJson();
        }
        return view('admin.test-order-cancel-request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeRefundStatus(Request $request)
    {
        $validator = Validator::make( $request->all(),
            [
                'id.*' => "exists:test_order_cancel_requests,id",
                'refund_amount'  => "required|numeric|digits_between:1,9999999|min:1|max:9999999",
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        try{
            $testOrderCancelRequest=TestOrderCancelRequest::findOrFail($request->id);


            $testOrderCancelRequest->update(['refund_amount'=>$request->refund_amount,'refund_status'=>$request->refund_status,'refund_by '=>auth()->user()->id,'refund_at'=>Carbon::now()]);

            return redirect()->back()->with('success',"Refund Status has been Changed Successfully ");
        }catch(\Exception $e){
            Log::error('Refund Status error:'.$e->getMessage());
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),
            [
            'test_order_id' => "required|exists:test_orders,id",
            'notes' => 'required|max: 200|min:10',
            ]);
        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        $testOrder=TestOrder::with('cancelRequest')->findOrFail($request->test_order_id);

        if ($testOrder->user_id!==auth()->user()->id){
            return $this->respondWithValidation('Validation Fail','Test Order ID does not belong to you!',Response::HTTP_BAD_REQUEST);
        }

        if ($testOrder->cancelRequest){
            return $this->respondWithValidation('Validation Fail','Already Cancel Request has been submitted',Response::HTTP_BAD_REQUEST);
        }


        try{

            TestOrderCancelRequest::create(
                [
                    'test_order_id' => $request->test_order_id,
                    'notes' => $request->notes??'',
                    'created_by' => \Auth::user()->id,
                ]);


            Log::info('Test order Cancel Request from api');
            return $this->respondWithSuccess('Test order Cancel Request has been Placed successful',['Test order Cancel Request has been Placed successful'],Response::HTTP_OK);

        }catch(\Exception $e){
            Log::info('Test order Cancel Request error api: '.$e->getMessage());
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestOrderCancelRequest  $testOrderCancelRequest
     * @return \Illuminate\Http\Response
     */
    public function show(TestOrderCancelRequest $testOrderCancelRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestOrderCancelRequest  $testOrderCancelRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(TestOrderCancelRequest $testOrderCancelRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestOrderCancelRequest  $testOrderCancelRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestOrderCancelRequest $testOrderCancelRequest)
    {
        try{

            if ($request->cancel_status==TestOrderCancelRequest::PENDING && $testOrderCancelRequest->cancel_status==TestOrderCancelRequest::APPROVED){
                return redirect()->back()->with('error','You can not change CANCEL Status - Approved to Pending');
            }

            // check: is cancel request Approved or not?---------
            if ($testOrderCancelRequest->cancel_status==TestOrderCancelRequest::APPROVED){
                return redirect()->back()->with('error','Already Cancel Request Approved');
            }

           TestOrder::findOrFail($testOrderCancelRequest->test_order_id)->update(['order_status'=>TestOrder::ORDERCANCEL]);

            $testOrderCancelRequest->update(['cancel_status'=>$request->cancel_status,'cancel_by '=>auth()->user()->id,'cancel_at'=>Carbon::now()]);

            return redirect()->back()->with('success',"Cancel Request has been Approved Successfully ");
        }catch(\Exception $e){
        Log::error('Test order cancel request error:'.$e->getMessage());
        return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestOrderCancelRequest  $testOrderCancelRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestOrderCancelRequest $testOrderCancelRequest)
    {
        return $testOrderCancelRequest;
    }
}
