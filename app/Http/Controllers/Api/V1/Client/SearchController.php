<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    use ApiResponseTrait;

    public function searchActiveUsers(Request $request){
        try{
            if ($request->q){
                $search=$request->q;
                $activeUsers=User::select('name','phone','email','id')->where(function ($query)use($search){
                    $query->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%')
                        ->orWhere('phone', 'LIKE', '%'.$search.'%');
                })->where('status',User::ACTIVE)->latest()->get();
            }else{
                $activeUsers='';
            }
            return $this->respondWithSuccess('Active Patients',$activeUsers,Response::HTTP_OK);

        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function searchActivePatients(Request $request){
        try{
            if ($request->q){
                $search=$request->q;
                $activePatients=Patient::select('name','patient_no','mobile','id')->where(function ($query)use ($search){
                    $query->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('patient_no', 'LIKE', '%'.$search.'%')
                        ->orWhere('mobile', 'LIKE', '%'.$search.'%');
                })->where('status',Patient::ACTIVE)->latest()->get();
            }else{
                $activeDoctors='';
            }
            return $this->respondWithSuccess('Active Patients',$activePatients,Response::HTTP_OK);

        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function searchActiveDoctors(Request $request){
        try{
            if ($request->q){
                $search=$request->q;
                $activeDoctors=Doctor::select('name','email','mobile','id','department')->where(function ($query)use ($search){
                    $query->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%')
                        ->orWhere('mobile', 'LIKE', '%'.$search.'%');
                })->where('status',Doctor::ACTIVE)->latest()->get();
            }else{
                $activeDoctors='';
            }
            return $this->respondWithSuccess('Active doctors',$activeDoctors,Response::HTTP_OK);

        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function searchActiveHospitals(Request $request){
        try{
            if ($request->q){
                $search=$request->q;
                $activeHospitals=Hospital::select('name','branch','address1','id')->where('name', 'LIKE', '%'.$search.'%')->latest()->get();
            }else{
                $activeHospitals='';
            }
            return $this->respondWithSuccess('Active hospitals',$activeHospitals,Response::HTTP_OK);

        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
