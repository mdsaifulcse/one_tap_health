<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorResourceCollection;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorApiController extends Controller
{
    use ApiResponseTrait;

    public function activeDoctorsList(){
        try{
            $activeDoctors=Doctor::where(['status'=>Doctor::ACTIVE])->paginate(10);
            return $this->respondWithSuccess('Active Doctors List',DoctorResourceCollection::make($activeDoctors),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function doctorWiseScheduleForHospital($doctorId){
        try{
            $doctorSchedules=Doctor::with('doctorSchedules')->findOrFail($doctorId);
            return $this->respondWithSuccess('Doctor hospital wise schedules',new DoctorResource($doctorSchedules),Response::HTTP_OK);
        }catch(Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
