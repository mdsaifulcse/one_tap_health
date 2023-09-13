<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorResourceCollection;
use App\Http\Resources\HospitalResource;
use App\Http\Resources\HospitalResourceCollection;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Biggapon;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerApiController extends Controller
{
    use ApiResponseTrait;

    public function activeBannerList(){
        try{
            $activeBanners=Biggapon::select('image','place','show_on_page')->where(['status'=>Biggapon::ACTIVE])->latest()->get();
            return $this->respondWithSuccess('Active Banner List',$activeBanners,Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later '.$e->getMessage(),'',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
