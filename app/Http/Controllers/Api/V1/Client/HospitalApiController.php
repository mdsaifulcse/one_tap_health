<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorResourceCollection;
use App\Http\Resources\HospitalResource;
use App\Http\Resources\HospitalResourceCollection;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DataLoad;
class HospitalApiController extends Controller
{
    use ApiResponseTrait;

    public function hospitalWiseTestDetails($hospitalId){
        try{
            $testsPriceForHospital=Hospital::with('hospitalTestPrice','district:id,name,bn_name','zoneArea:id,name,bn_name')->findOrFail($hospitalId);
            return $this->respondWithSuccess('Hospital Wise Test Prices',new HospitalResource($testsPriceForHospital),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function activeHospitalsList(){
        try{
            $activeHospitals=Hospital::with('hospitalTestPrice')->where(['status'=>Hospital::ACTIVE])->orderBy('name','ASC')->get();
            return $this->respondWithSuccess('Active Hospital List',HospitalResourceCollection::make($activeHospitals),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
