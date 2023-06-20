<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    use ApiResponseTrait;

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
