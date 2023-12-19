<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalWiseTestPrice;
use App\Models\Test;
use Illuminate\Http\Request;
use Validator,MyHelper,DB;

class HospitalWiseTestPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         $hospital=Hospital::find($request->hospitalId);
         $activeTests=Test::with('testCategory','testSubCategory','testThirdCategory')->where(['status'=>Test::ACTIVE])
            ->orderBy('sequence','DESC')->get();

        return view('admin.set-test-price.create',compact('hospital','activeTests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            "hospital_id"    => "required|exists:hospitals,id",
            "test_id"    => "required|array|min:1",
            "test_id.*"  => "required|min:1|max:999999",

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error','Wrong input ! '.$validator->errors()->first());
            //return $validator->errors()->first();
           // return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{

            foreach ($request->test_id as $key=>$testId){
                if (!empty($request->test_price[$testId])) {
                    $testPricesHospitalWise[] = [
                        'hospital_id' => $request->hospital_id,
                        'price' => $request->test_price[$testId]?$request->test_price[$testId]:0,
                        'discount' => $request->test_discount[$testId]?$request->test_discount[$testId]:0,
                        'test_id' => $testId,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];
                }
            }

            HospitalWiseTestPrice::insert($testPricesHospitalWise);

            DB::commit();
            return redirect('admin/hospitals')->with('success','Test Price Successfully Created');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HospitalWiseTestPrice  $hospitalWiseTestPrice
     * @return \Illuminate\Http\Response
     */
    public function show($id) // $id==hospital id
    {
        $hospital=Hospital::findOrFail($id);
        $activeTests=Test::with('testCategory','testSubCategory','testThirdCategory')->where(['status'=>Test::ACTIVE])
            ->orderBy('sequence','DESC')->get();
        $hospitalTestPrice=HospitalWiseTestPrice::where(['hospital_id'=>$id])->pluck('price','test_id')->toArray();

        foreach ($activeTests as $activeTest){

            if (array_key_exists($activeTest->id,$hospitalTestPrice)){
                $testPrice=HospitalWiseTestPrice::where(['hospital_id'=>$id,'test_id'=>$activeTest->id])->first();
                $activeTest['price']=$testPrice->price;
                $activeTest['discount']=$testPrice->discount;
            }else{
                $activeTest['price']=null;
                $activeTest['discount']=0;
            }
        }

        return view('admin.set-test-price.show',compact('hospital','activeTests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HospitalWiseTestPrice  $hospitalWiseTestPrice
     * @return \Illuminate\Http\Response
     */
    public function edit($id) // $id==hospital id
    {
        $hospital=Hospital::findorFail($id);
        $activeTests=Test::with('testCategory','testSubCategory','testThirdCategory')->where(['status'=>Test::ACTIVE])
            ->orderBy('sequence','DESC')->get();
        $hospitalTestPrice=HospitalWiseTestPrice::where(['hospital_id'=>$id])->pluck('price','test_id')->toArray();

        foreach ($activeTests as $activeTest){

            if (array_key_exists($activeTest->id,$hospitalTestPrice)){
                $testPrice=HospitalWiseTestPrice::where(['hospital_id'=>$id,'test_id'=>$activeTest->id])->first();
                $activeTest['price']=$testPrice->price;
                $activeTest['discount']=$testPrice->discount;
            }else{
                $activeTest['price']=null;
                $activeTest['discount']=0;
            }
        }


        return view('admin.set-test-price.edit',compact('hospital','activeTests'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HospitalWiseTestPrice  $hospitalWiseTestPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) // $id==hospital id
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            "hospital_id"    => "required|exists:hospitals,id",
            "test_id"    => "required|array|min:1",
            "test_id.*"  => "required|min:1|max:999999",

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error','Wrong input ! '.$validator->errors()->first());
            //return $validator->errors()->first();
            // return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{

            foreach ($request->test_id as $key=>$testId){
                if (!empty($request->test_price[$testId])) {
                    $testPricesHospitalWise[] = [
                        'hospital_id' => $request->hospital_id,
                        'price' => $request->test_price[$testId]?$request->test_price[$testId]:0,
                        'discount' => $request->test_discount[$testId]?$request->test_discount[$testId]:0,
                        'test_id' => $testId,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];
                }
            }

            // Delete old test price data -------
            HospitalWiseTestPrice::where(['hospital_id'=>$id])->forceDelete();
            // Create/insert new test price by hospital
            HospitalWiseTestPrice::insert($testPricesHospitalWise);

            DB::commit();
            return redirect()->back()->with('success','Test Price Successfully Update');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HospitalWiseTestPrice  $hospitalWiseTestPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalWiseTestPrice $hospitalWiseTestPrice)
    {
        //
    }
}
