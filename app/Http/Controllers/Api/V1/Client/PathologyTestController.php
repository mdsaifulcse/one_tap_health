<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\CostOfHospitalTestCollection;
use App\Http\Resources\TestResourceCollection;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubCategoryResourceCollection;
use App\Http\Resources\ThirdSubCategoryResource;
use App\Http\Resources\ThirdSubCategoryResourceCollection;
use App\Models\Author;
use App\Models\HospitalWiseTestPrice;
use App\Models\Item;
use App\Models\Test;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Image,DB,Auth,Validator,MyHelper,Route,DataLoad;

class PathologyTestController extends Controller
{
    use ApiResponseTrait;

    public function activeItemSearch(Request $request)
    {
        if ($request->q && !empty($request->q)){
            return Item::select('title','id')
                ->where('title', 'like', '%' .$request->q. '%')->get();
        }else{
            return [];
        }
    }

    public function activeGeneralUserListList(){
        try{
            $generalUsers=DataLoad::generalUserList();
            return $this->respondWithSuccess('Active General User List',$generalUsers,Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function costOfHospitalsTest(Request $request){
        try{
            if (!is_array($request->test_ids) || !isset($request->test_ids)){
                return $this->respondWithValidation('Validation Fail','Query params must be test_ids & array',Response::HTTP_BAD_REQUEST);
            }
            $testIds=$request->test_ids;


           //return $costOfHospitalTest=HospitalWiseTestPrice::with('hospital')->where('test_id',3)->paginate(50);

            $groupByTests=HospitalWiseTestPrice::with('test:id,title')->select('test_id')->whereIn('test_id',$testIds)
                ->groupBy('test_id')->get();

            $testWiseHospitals=HospitalWiseTestPrice::with('test:id,title','hospital:id,name,branch,address1,latitude,longitude')->whereIn('test_id',$testIds)
                ->orderBy('test_id')->get();

            foreach ($groupByTests as $i=>$groupByTest){

                $hospitalArray=[];
                foreach ($testWiseHospitals as $j=>$testWiseHospital){

                    if ($groupByTest->test_id==$testWiseHospital->test_id){

                        $hospitalArray[]=[
                            'test_id'=>$testWiseHospital->test->id,
                            'test_title'=>$testWiseHospital->test->title,
                            'hospital_name'=>$testWiseHospital->hospital->name,
                            'hospital_branch'=>$testWiseHospital->hospital->branch,
                            'latitude'=>$testWiseHospital->hospital->latitude?$testWiseHospital->hospital->latitude:'',
                            'longitude'=>$testWiseHospital->hospital->longitude?$testWiseHospital->hospital->longitude:'',
                            'hospital_photo'=>$testWiseHospital->hospital->photo?url($testWiseHospital->hospital->photo):'',
                            'price'=>$testWiseHospital->price,
                            'discount'=>$testWiseHospital->discount,
                            'price_after_discount'=>$testWiseHospital->price_after_discount,
                        ];
                    }


                }

                $groupByTest['hospitals']=$hospitalArray;
            }

            return $this->respondWithSuccess('Cost of test for hospital list',$groupByTests,Response::HTTP_OK);
            //return $this->respondWithSuccess('Cost of test for hospital',CostOfHospitalTestCollection::make($testWiseHospitals),Response::HTTP_OK);

        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later '.$e->getMessage(),'',Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function categoryWiseActiveTestList($categoryId){
        try{

            $categoryActiveTests=Test::with('testCategory')->where(['category_id'=>$categoryId,'status'=>Test::ACTIVE])->orderBy('title','ASC')->get();

            return $this->respondWithSuccess('Category Wise Active Test list',TestResourceCollection::make($categoryActiveTests),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function activeCategoryList(){
        try{

            $categories=DataLoad::activeCategoryForApi();
            return $this->respondWithSuccess('Active Category list',CategoryResourceCollection::make($categories),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function activeSubcategoryList($categoryId=null){
        try{
            $subCategories=DataLoad::subCatForApi($categoryId);
            return $this->respondWithSuccess('Active Sub Category list',SubCategoryResourceCollection::make($subCategories),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function activeThirdSubcategoryList($subCategoryId=null){
        try{
            $thirdCategories=DataLoad::thirdSubCatForApi($subCategoryId);
            return $this->respondWithSuccess('Active Third Sub Category list',ThirdSubCategoryResourceCollection::make($thirdCategories),Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
