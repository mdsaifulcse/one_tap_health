<?php
namespace App\Http\Controllers\SSLCommerz;
use App\Http\Traits\ApiResponseTrait;
use App\Models\DoctorAppointment;
use App\Models\DoctorAppointmentPaymentHistory;
use App\Models\Setting;
use App\Models\TestOrder;
use App\Models\TestOrderPaymentHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers\Controller;
use PhpParser\Comment\Doc;
use Symfony\Component\HttpFoundation\Response;
use DB,Validator,Auth;
class DoctorAppointmentSslCommerzPaymentController extends Controller
{
    use ApiResponseTrait;

    public function validationRules($request){
        $rules=[
            'doctor_appointment_id' => "exists:doctor_appointments,id",
            'service_charge' => 'nullable|numeric|max:999999|min:10'
        ];
        return $rules;
    }


    public function index(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

// START Doctor Appointment Data Validation.
        $rules=$this->validationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        // check Doctor Appointment payment_status (payment_amount=Service Charge)
        $doctorAppointmentId=$request->doctor_appointment_id;
        $doctorAppointment=DoctorAppointment::with('patient')->findOrFail($doctorAppointmentId);

        if ($doctorAppointment->payment_status==DoctorAppointment::FULLPAYMENT){
            return $this->respondWithValidation('Already full payment is done',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        // End Doctor Appointment Data Validation.

        // START Customized Business Logic.



        $tranId=DoctorAppointmentPaymentHistory::generateDoctorAppointmentTrxID($doctorAppointmentId);
        $totalAmount=$request->service_charge??$doctorAppointment->service_charge;

        // update service charge if service charge ---------
        if ($totalAmount==0){
            $totalAmount=Setting::first()->value('appointment_service_charge');
            $doctorAppointment->update(['service_charge'=>$totalAmount]);
        }

        // delete old pending paymentHistory data --------------
        $oldPendingData=DoctorAppointmentPaymentHistory::where(['doctor_appointment_id'=>$doctorAppointmentId,'payment_status'=>DoctorAppointment::PENDING])->first();

        if (!empty($oldPendingData)){
            $oldPendingData->delete();
        }


        // Create payment initiate ------------
        DoctorAppointmentPaymentHistory::create([
            'user_id'=>$doctorAppointment->user_id,
            'doctor_appointment_id'=>$doctorAppointmentId,
            'transaction_id'=>$tranId,
            'payment_date'=>Carbon::now(),
            'payment_amount'=>$totalAmount,
            'payment_type'=>DoctorAppointmentPaymentHistory::ONLINEPAYMENT,
            'currency'=>'BDT',
            'payment_status'=>DoctorAppointmentPaymentHistory::PENDING,
        ]);

        // Set Customer information ------
        $custName=$doctorAppointment->patient?$doctorAppointment->patient->name:'customer Name';
        $custPhone=$doctorAppointment->patient?$doctorAppointment->patient->mobile??'01701000000':'01701000000';
        $custEmail=$doctorAppointment->patient?$doctorAppointment->patient->email??'cust@customer.com':'cust@customer.com';
        $custAddress=$doctorAppointment->patient?$doctorAppointment->patient->address??'Dhaka':'Dhaka';


// END of Customized Business Logic.


        $post_data = array();
        $post_data['total_amount'] = $totalAmount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] =$tranId;  // tran_id must be unique

        #Start to save these value  in session to pick in success page.
        //$_SESSION['payment_values']['tran_id']=$post_data['tran_id'];




        #End to save these value  in session to pick in success page.


        $server_name=$request->root()."/";
        $post_data['success_url'] = $server_name ."api/v1/sslPay/doctor-appointment/"."success";
        $post_data['fail_url'] = $server_name . "api/v1/sslPay/doctor-appointment/"."fail";
        $post_data['cancel_url'] = $server_name . "api/v1/sslPay/doctor-appointment/"."cancel";

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

        $post_data['value_a'] = $tranId;
        $_SESSION['payment_tranId']=$tranId;
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        $sslc = new SSLCommerz();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->initiate($post_data, false);

        //dd($payment_options);

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
        $tran_id=$request->value_a??$_SESSION['payment_tranId'];

        #End to received these value from session. which was saved in index function.

        #Check order status in order table against the transaction id or order id.
         // ----- For Doctor Appointment Pay (service charge) ----------------------------------------------------------------------
            $doctorAppointmentPaymentHistory=DoctorAppointmentPaymentHistory::where(['transaction_id'=>$tran_id])->first();

            if($doctorAppointmentPaymentHistory->payment_status==DoctorAppointmentPaymentHistory::PENDING)
            {
                $validation = $sslc->orderValidate($tran_id, $doctorAppointmentPaymentHistory->payment_amount, $doctorAppointmentPaymentHistory->currency, $request->all());
                if($validation == TRUE)
                {
                    /*
                    That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successfull transaction to customer
                    */
                /*-----------------Change status Doctor Appointment Payment history & Test_order -------------*/
                    $doctorAppointmentPaymentHistory->update([
                        'payment_status'=>DoctorAppointmentPaymentHistory::COMPLETE,
                        'store_amount'=>$request->store_amount??0,
                        'payment_gateway'=>$request->card_type??'',
                        'payment_date'=>Carbon::now(),
                        'payment_track'=>json_encode($request->all())
                    ]);

                    $doctorAppointmentId=$doctorAppointmentPaymentHistory->doctor_appointment_id;

                    $doctorAppointment=DoctorAppointment::findOrFail($doctorAppointmentId);
                    $totalPaymentAmount=DoctorAppointmentPaymentHistory::totalPaymentAmount($doctorAppointmentId);

                    // Doctor Appointment Payment status change -------------------
                    if ($totalPaymentAmount<$doctorAppointment->service_charge){
                        $doctorAppointment->update(['payment_status'=>DoctorAppointment::PARTIALPAYMENT]);

                    }elseif ($totalPaymentAmount>=$doctorAppointment->service_charge){
                        $doctorAppointment->update(['payment_status'=>DoctorAppointment::FULLPAYMENT]);

                    }else{
                        $doctorAppointment->update(['payment_status'=>DoctorAppointment::PENDING]);
                    }

                    $data['payment_amount']=$doctorAppointmentPaymentHistory->payment_amount;
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
                    $doctorAppointmentPaymentHistory->update(['payment_status'=>DoctorAppointmentPaymentHistory::FAILED]);

                    $data['payment_amount']=0;
                    $data['status']='failed';
                    $data['message']="validation Fail";

                    return view('ssl.ssl-web-view',compact('data'));
                    //return $this->respondWithValidation('validation Fail','validation Fail',Response::HTTP_BAD_REQUEST);
                }
            }
            else if($doctorAppointmentPaymentHistory->payment_status==DoctorAppointmentPaymentHistory::COMPLETE)
            {
                /*
                 That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
                 */
                /*-----------------Change status Test order history & Test_order -------------*/
                $doctorAppointmentPaymentHistory->update([
                    'payment_status'=>DoctorAppointmentPaymentHistory::COMPLETE,
                    'store_amount'=>$request->store_amount,
                    'payment_gateway'=>$request->card_type,
                    'payment_track'=>json_encode($request->all())
                ]);

                $doctorAppointmentId=$doctorAppointmentPaymentHistory->doctor_appointment_id;

                $doctorAppointment=DoctorAppointment::findOrFail($doctorAppointmentId);
                $totalPaymentAmount=DoctorAppointmentPaymentHistory::totalPaymentAmount($doctorAppointmentId);

                if ($totalPaymentAmount<$doctorAppointment->service_charge){
                    $doctorAppointment->update(['payment_status'=>DoctorAppointment::PARTIALPAYMENT]);

                }elseif ($totalPaymentAmount>=$doctorAppointment->service_charge){
                    $doctorAppointment->update(['payment_status'=>DoctorAppointment::FULLPAYMENT]);

                }else{
                    $doctorAppointment->update(['payment_status'=>DoctorAppointment::PENDING]);
                }

                $data['payment_amount']=$doctorAppointmentPaymentHistory->payment_amount;
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

    }

    public function fail(Request $request)
    {
        $tran_id=$request->value_a??$_SESSION['payment_tranId'];

            $doctorAppointmentPaymentHistory = DoctorAppointmentPaymentHistory::where(['transaction_id' => $tran_id])->first();

            if($doctorAppointmentPaymentHistory->payment_status==DoctorAppointmentPaymentHistory::PENDING)
            {
                $doctorAppointmentPaymentHistory->update(['payment_status'=>DoctorAppointmentPaymentHistory::FAILED]);

                $data['payment_amount']=0;
                $data['status']='failed';
                $data['message']="Transaction is Fail";

                return view('ssl.ssl-web-view',compact('data'));

                //return $this->respondWithValidation('Transaction is Fail','Transaction is Fail',Response::HTTP_BAD_REQUEST);
            }
            else if($doctorAppointmentPaymentHistory->payment_status==DoctorAppointmentPaymentHistory::COMPLETE)
            {

                $data['payment_amount']=$doctorAppointmentPaymentHistory->payment_amount;
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

    }

    public function cancel(Request $request)
    {
        $tran_id=$request->value_a??$_SESSION['payment_tranId'];

            $doctorAppointmentPaymentHistory = DoctorAppointmentPaymentHistory::where(['transaction_id' => $tran_id])->first();

            if ($doctorAppointmentPaymentHistory->payment_status==DoctorAppointmentPaymentHistory::PENDING) {

                $doctorAppointmentPaymentHistory->update(['payment_status' => DoctorAppointmentPaymentHistory::CANCELED]);

                $data['payment_amount']=0;
                $data['status']='canceled';
                $data['message']="The payment has been canceled";

                return view('ssl.ssl-web-view',compact('data'));
                //return $this->respondWithValidation('Transaction is Fail', 'Transaction is Fail', Response::HTTP_BAD_REQUEST);

            } else if ($doctorAppointmentPaymentHistory->payment_status==DoctorAppointmentPaymentHistory::COMPLETE) {

                $data['payment_amount']=$doctorAppointmentPaymentHistory->payment_amount;
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
