<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorResourceCollection;
use App\Http\Resources\HospitalResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorApiController extends Controller
{
    use ApiResponseTrait;

    public function activeDoctorDepartmentsList(){
        try{
            $activeDoctorDepartments=Doctor::department();
            return $this->respondWithSuccess('Active Doctor Departments List',$activeDoctorDepartments,Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function activeDoctorsList(){
        try{
            $activeDoctors=Doctor::where(['status'=>Doctor::ACTIVE])->paginate(500);
            return $this->respondWithSuccess('Active Doctors List',DoctorResourceCollection::make($activeDoctors),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function doctorsByHospital($hospitalId){
        try{
            $hospital=Hospital::with('doctorSchedules','doctorSchedules.doctor')->findOrFail($hospitalId);
            return $this->respondWithSuccess('Hospital wise doctors',new HospitalResource($hospital),Response::HTTP_OK);
        }catch(Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function doctorWiseScheduleForHospital($doctorId){
        try{
            $doctorSchedules=Doctor::with('doctorSchedules')->findOrFail($doctorId);
            return $this->respondWithSuccess('Doctor hospital wise schedules',new DoctorResource($doctorSchedules),Response::HTTP_OK);
        }catch(Exception $e){
            return $this->respondWithError('Something went wrong, Try again later '.$e->getMessage(),'',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchActiveDoctors(Request $request){
        try{
            if ($request->q){
                $search=$request->q;
                 $activeDoctors=Doctor::select('name','email','mobile','id')->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orWhere('mobile', 'LIKE', '%'.$search.'%')
                    ->latest()->get();
            }else{
                $activeDoctors='';
            }
            return $this->respondWithSuccess('Active doctors',$activeDoctors,Response::HTTP_OK);

        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
