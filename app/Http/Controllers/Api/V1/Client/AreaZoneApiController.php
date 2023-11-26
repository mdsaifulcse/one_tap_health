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
class AreaZoneApiController extends Controller
{
    use ApiResponseTrait;

    public function activeDistrictList(){
        try{

            $activeDistricts=DataLoad::activeDistrictsForApi();
            return $this->respondWithSuccess('Active District list',$activeDistricts,Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function activeAreaByDistrict($zoneAreaId=null){
        try{
            $areaByDistrict=DataLoad::activeZoneAreaForApi($zoneAreaId);
            return $this->respondWithSuccess('Active Area (zone) list',$areaByDistrict,Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
