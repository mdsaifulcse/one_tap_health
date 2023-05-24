<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\HospitalWiseDoctorSchedule;
use App\Models\HospitalWiseTestPrice;
use App\Models\Test;
use Illuminate\Http\Request;
use Validator,MyHelper,DB;

class HospitalWiseDoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hospital=Hospital::select('id','name','branch','address1')->findOrFail($request->hospital_id);
        $doctors=Doctor::pluck('name','id');
        $availableDys=HospitalWiseDoctorSchedule::availableDays();

        $hospitalWiseDoctors=HospitalWiseDoctorSchedule::with('doctor')->where(['hospital_id'=>$request->hospital_id])->latest()->paginate(15);

        //$days= $hospitalWiseDoctors[0]->doctorAvailableDay;

        return view('admin.doctor-schedule.index',compact('hospital','doctors','availableDys','hospitalWiseDoctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

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
            "doctor_id"    => "required|exists:doctors,id",
            "doctor_fee"    => "required|numeric",
            "available_from"    => "required",
            "available_to"    => "required",
//            "test_id"    => "required|array|min:1",
//            "test_id.*"  => "required|min:1|max:999999",

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
           // return redirect()->back()->with('error','Wrong input ! '.$validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            HospitalWiseDoctorSchedule::create([
                'hospital_id' => $request->hospital_id,
                'doctor_id' => $request->doctor_id,
                'doctor_fee' => $request->doctor_fee,
                'discount' => $request->discount??0,
                'available_from' => $request->available_from,
                'available_to' => $request->available_to,
                'available_day' => json_encode($request->available_day),
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success','Doctor has been added successfully');
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
        $hospitalWiseDoctor=HospitalWiseDoctorSchedule::with('doctor','hospital')->findOrFail($id);
        $doctors=Doctor::pluck('name','id');
        $availableDys=HospitalWiseDoctorSchedule::availableDays();

        return view('admin.doctor-schedule.edit',compact('hospitalWiseDoctor','doctors','availableDys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HospitalWiseTestPrice  $hospitalWiseTestPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HospitalWiseDoctorSchedule $hospitalWiseDoctorSchedule) // $id==hospital id
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            "hospital_id"    => "required|exists:hospitals,id",
            "doctor_id"    => "required|exists:doctors,id",
            "doctor_fee"    => "required|numeric",
            "available_from"    => "required",
            "available_to"    => "required",

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error','Wrong input ! '.$validator->errors()->first());
            //return $validator->errors()->first();
            // return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{

            //return $request;
            $hospitalWiseDoctorSchedule->update([
                'hospital_id' => $request->hospital_id,
                'doctor_id' => $request->doctor_id,
                'doctor_fee' => $request->doctor_fee,
                'discount' => $request->discount??0,
                'available_from' => $request->available_from,
                'available_to' => $request->available_to,
                'available_day' => json_encode($request->available_day),
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success','Doctor has been updated successfully');
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
    public function destroy(HospitalWiseDoctorSchedule $hospitalWiseDoctorSchedule)
    {
        try{
            $hospitalWiseDoctorSchedule->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }
}
