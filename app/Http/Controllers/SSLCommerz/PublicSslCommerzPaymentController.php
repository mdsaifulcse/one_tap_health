<?php
namespace App\Http\Controllers\SSLCommerz;
use App\Http\Traits\ApiResponseTrait;
use App\Models\TestOrder;
use App\Models\TestOrderPaymentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use DB,Validator,Auth;
class PublicSslCommerzPaymentController extends Controller
{
    use ApiResponseTrait;

    public function testOrderPaymentValidationRules($request){
        $rules=[
            'payment_amount' => 'nullable|numeric|max:999999',
            'test_order_id' => "exists:test_orders,id"
        ];
        return $rules;
    }


    public function index(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

// START Test Order Data Validation.
        $rules=$this->testOrderPaymentValidationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        // check test Order payment_status (partial/full payment)
        $testOrderId=$request->test_order_id;
        $testOrder=TestOrder::with('patient')->findOrFail($testOrderId);

        if ($testOrder->payment_status==TestOrder::FULLPAYMENT){
            return $this->respondWithValidation('Already full payment is done',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

// End Test Order Data Validation.

// START Customized Business Logic.



        $tranId=TestOrderPaymentHistory::generateTestOrderTrxID($testOrderId);
        $totalAmount=$request->payment_amount??$testOrder->reconciliation_amount;

        // Create payment initiate ------------
        TestOrderPaymentHistory::create([
            'user_id'=>$testOrder->user_id,
            'test_order_id'=>$testOrderId,
            'transaction_id'=>$tranId,
            'payment_date'=>Carbon::now(),
            'payment_amount'=>$totalAmount,
            'payment_type'=>TestOrderPaymentHistory::ONLINEPAYMENT,
            'currency'=>'BDT',
            'payment_status'=>TestOrderPaymentHistory::PENDING,
        ]);

        // Set Customer information ------
        $custName=$testOrder->patient?$testOrder->patient->name:'customer Name';
        $custPhone=$testOrder->patient?$testOrder->patient->mobile??'01701000000':'01701000000';
        $custEmail=$testOrder->patient?$testOrder->patient->email??'cust@customer.com':'cust@customer.com';
        $custAddress=$testOrder->patient?$testOrder->patient->address??'Dhaka':'Dhaka';


// END of Customized Business Logic.


        $post_data = array();
        $post_data['total_amount'] = $totalAmount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] =$tranId;  // tran_id must be unique

        #Start to save these value  in session to pick in success page.
        //$_SESSION['payment_values']['tran_id']=$post_data['tran_id'];




        #End to save these value  in session to pick in success page.


        $server_name=$request->root()."/";
        $post_data['success_url'] = $server_name ."api/v1/sslPay/"."success";
        $post_data['fail_url'] = $server_name . "api/v1/sslPay/"."fail";
        $post_data['cancel_url'] = $server_name . "api/v1/sslPay/"."cancel";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $custName;
        $post_data['cus_email'] = $custEmail;
        $post_data['cus_add1'] = $custAddress;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $custPhone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = 'testonetap72x';
        $post_data['ship_add1 '] = 'Dhaka';
        $post_data['ship_add2'] = "";
        $post_data['ship_city'] = "";
        $post_data['ship_state'] = "";
        $post_data['ship_postcode'] = "";
        $post_data['ship_country'] = "Bangladesh";

        # OPTIONAL PARAMETERS
        if ($request->test_order_id){ // Test order Payment ----------
            //$_SESSION['payment_values']['pay_for']='test_order_pay';
            $post_data['value_a'] = "test_order_pay";
        }elseif (1){
            $post_data['value_a'] = "doctor_book";
        }

        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        $sslc = new SSLCommerz();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->initiate($post_data, false);

        return (object) $payment_options;


        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id =$request->tran_id;
        $payFor=$request->value_a;

        #End to received these value from session. which was saved in index function.

        #Check order status in order tabel against the transaction id or order id.
         // ----- For test Order Pay -------------------------------------------------------------------
        if ($payFor=='test_order_pay'){
            $testOrderPaymentHistory=TestOrderPaymentHistory::where(['transaction_id'=>$tran_id])->first();

            if($testOrderPaymentHistory->payment_status==TestOrderPaymentHistory::PENDING)
            {
                $validation = $sslc->orderValidate($tran_id, $testOrderPaymentHistory->payment_amount, $testOrderPaymentHistory->currency, $request->all());
                if($validation == TRUE)
                {
                    /*
                    That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successfull transaction to customer
                    */
                /*-----------------Change status Test order history & Test_order -------------*/
                    $testOrderPaymentHistory->update([
                        'payment_status'=>TestOrderPaymentHistory::COMPLETE,
                        'store_amount'=>$request->store_amount,
                        'payment_gateway'=>$request->card_type,
                        'payment_date'=>Carbon::now(),
                        'payment_track'=>json_encode($request->all())
                    ]);

                    $testOrderId=$testOrderPaymentHistory->test_order_id;

                    $testOrder=TestOrder::findOrFail($testOrderId);
                    $totalPaymentAmount=TestOrderPaymentHistory::totalPaymentAmount($testOrderId);

                    // Test order status change -------------------
                    if ($totalPaymentAmount<$testOrder->reconciliation_amount){
                        $testOrder->update(['payment_status'=>TestOrder::PARTIALPAYMENT]);

                    }elseif ($totalPaymentAmount>=$testOrder->reconciliation_amount){
                        $testOrder->update(['payment_status'=>TestOrder::FULLPAYMENT]);

                    }else{
                        $testOrder->update(['payment_status'=>TestOrder::PENDING]);
                    }

                    $data['payment_amount']=$testOrderPaymentHistory->payment_amount;
                    $data['status']='success';
                    $data['message']="";

                    return view('ssl.ssl-web-view',compact('data'));
                   // return $this->respondWithSuccess('Transaction is successfully Complete','',Response::HTTP_OK);
                }
                else
                {
                    /*
                    That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $testOrderPaymentHistory->update(['payment_status'=>TestOrderPaymentHistory::FAILED]);

                    $data['payment_amount']=0;
                    $data['status']='failed';
                    $data['message']="validation Fail";

                    return view('ssl.ssl-web-view',compact('data'));
                    //return $this->respondWithValidation('validation Fail','validation Fail',Response::HTTP_BAD_REQUEST);
                }
            }
            else if($testOrderPaymentHistory->payment_status==TestOrderPaymentHistory::COMPLETE)
            {
                /*
                 That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
                 */
                /*-----------------Change status Test order history & Test_order -------------*/
                $testOrderPaymentHistory->update([
                    'payment_status'=>TestOrderPaymentHistory::COMPLETE,
                    'store_amount'=>$request->store_amount,
                    'payment_gateway'=>$request->card_type,
                    'payment_track'=>json_encode($request->all())
                ]);

                $testOrderId=$testOrderPaymentHistory->test_order_id;

                $testOrder=TestOrder::findOrFail($testOrderId);
                $totalPaymentAmount=TestOrderPaymentHistory::totalPaymentAmount($testOrderId);

                if ($totalPaymentAmount<$testOrder->reconciliation_amount){
                    $testOrder->update(['payment_status'=>TestOrder::PARTIALPAYMENT]);

                }elseif ($totalPaymentAmount>=$testOrder->reconciliation_amount){
                    $testOrder->update(['payment_status'=>TestOrder::FULLPAYMENT]);

                }else{
                    $testOrder->update(['payment_status'=>TestOrder::PENDING]);
                }

                $data['payment_amount']=$testOrderPaymentHistory->payment_amount;
                $data['status']='success';
                $data['message']="Transaction is successfully Complete";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithSuccess('Transaction is successfully Complete','',Response::HTTP_OK);
            }
            else
            {
                $data['payment_amount']=0;
                $data['status']='failed';
                $data['message']="Invalid Transaction";

                return view('ssl.ssl-web-view',compact('data'));
                #That means something wrong happened. You can redirect customer to your product page.
               // return $this->respondWithValidation('Invalid Transaction','Invalid Transaction',Response::HTTP_BAD_REQUEST);
            }
        }elseif (1){
            // ----- For Doctor Book Pay -------------------------------------------------------------------
            return '';
        }





    }
    public function fail(Request $request)
    {
        $tran_id =$request->tran_id;
        $payFor=$request->value_a;

        if ($payFor=='test_order_pay') { // Test Order Pay----------------
            $testOrderPaymentHistory = TestOrderPaymentHistory::where(['transaction_id' => $tran_id])->first();

            if($testOrderPaymentHistory->payment_status==TestOrderPaymentHistory::PENDING)
            {
                $testOrderPaymentHistory->update(['payment_status'=>TestOrderPaymentHistory::FAILED]);

                $data['payment_amount']=0;
                $data['status']='failed';
                $data['message']="Transaction is Fail";

                return view('ssl.ssl-web-view',compact('data'));

                //return $this->respondWithValidation('Transaction is Fail','Transaction is Fail',Response::HTTP_BAD_REQUEST);
            }
            else if($testOrderPaymentHistory->payment_status==TestOrderPaymentHistory::COMPLETE)
            {

                $data['payment_amount']=$testOrderPaymentHistory->payment_amount;
                $data['status']='failed';
                $data['message']="Transaction is successfully Complete";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithSuccess('Transaction is successfully Complete','',Response::HTTP_OK);
            }
            else
            {
                $data['payment_amount']=0;
                $data['status']='failed';
                $data['message']="Invalid Transaction";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithValidation('Invalid Transaction','Invalid Transaction',Response::HTTP_BAD_REQUEST);
            }


        }elseif (1){
            return 'No';
        }



    }

    public function cancel(Request $request)
    {
        $tran_id =$request->tran_id;
        $payFor=$request->value_a;

        if ($payFor=='test_order_pay') { // Test Order Pay----------------
            $testOrderPaymentHistory = TestOrderPaymentHistory::where(['transaction_id' => $tran_id])->first();


            if ($testOrderPaymentHistory->payment_status==TestOrderPaymentHistory::PENDING) {

                $testOrderPaymentHistory->update(['payment_status' => TestOrderPaymentHistory::CANCELED]);

                $data['payment_amount']=0;
                $data['status']='canceled';
                $data['message']="The payment has been canceled";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithValidation('Transaction is Fail', 'Transaction is Fail', Response::HTTP_BAD_REQUEST);

            } else if ($testOrderPaymentHistory->payment_status==TestOrderPaymentHistory::COMPLETE) {

                $data['payment_amount']=$testOrderPaymentHistory->payment_amount;
                $data['status']='success';
                $data['message']="Transaction is successfully Complete";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithSuccess('Transaction is successfully Complete', '', Response::HTTP_OK);

            } else {
                $data['payment_amount']=0;
                $data['status']='canceled';
                $data['message']="Invalid Transaction";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithValidation('Invalid Transaction', 'Invalid Transaction', Response::HTTP_BAD_REQUEST);
            }
        }elseif (1){
            return 'No';
        }


    }
    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('order_id', $tran_id)
                ->select('order_id', 'order_status','currency','grand_total')->first();

            if($order_details->order_status =='Pending')
            {
                $sslc = new SSLCommerz();
                $validation = $sslc->orderValidate($tran_id, $order_details->grand_total, $order_details->currency, $request->all());
                if($validation == TRUE)
                {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successfull transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('order_id', $tran_id)
                        ->update(['order_status' => 'Processing']);

                    echo "Transaction is successfully Complete";
                }
                else
                {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('order_id', $tran_id)
                        ->update(['order_status' => 'Failed']);

                    echo "validation Fail";
                }

            }
            else if($order_details->order_status == 'Processing' || $order_details->order_status =='Complete')
            {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Complete";
            }
            else
            {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        }
        else
        {
            echo "Inavalid Data";
        }
    }

}
