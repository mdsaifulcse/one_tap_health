<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Models\TestOrder;
use App\Models\TestOrderCancelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\ApiResponseTrait;
use DB,Validator,Auth;

class TestOrderCancelRequestController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestOrderCancelRequest  $testOrderCancelRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestOrderCancelRequest $testOrderCancelRequest)
    {
        //
    }
}
