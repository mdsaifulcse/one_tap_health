<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorAppointmentResource;
use App\Http\Resources\DoctorAppointmentResourceCollection;
use App\Http\Resources\TestOrderResource;
use App\Http\Resources\TestOrderResourceCollection;
use App\Models\HospitalWiseTestPrice;
use App\Models\Patient;
use App\Models\TestOrder;
use App\Models\TestOrderDetail;
use App\Models\TestOrderPaymentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\ApiResponseTrait;
use DB,Validator,Auth;

class TestReportController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function testReportFileByTestOrder($testOrderId)
    {
        try{

            $testReport=TestOrder::with('patient:id,name,age','testReportFile:id,test_order_id,title,notes,files')->select('id','order_no','test_date','reconciliation_amount as amount','patient_id')->findOrFail($testOrderId);

            $test_report_files=[];
            if (!empty($testReport) && !empty($testReport->testReportFile)){

                if (sizeof($testReport->testReportFile->files)>0){
                    foreach ($testReport->testReportFile->files as $key=>$file){

                        array_push($test_report_files,url($file));
                    }
                    $testReport->testReportFile->files=$test_report_files;
                }
            }


            return $this->respondWithSuccess('Test Report File for Test Report',$testReport,Response::HTTP_OK);
        }catch(Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
