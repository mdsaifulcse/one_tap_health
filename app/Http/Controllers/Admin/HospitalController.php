<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalWiseTestPrice;
use Illuminate\Http\Request;
use Validator,MyHelper,DB;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals=Hospital::withCount('hospitalTestPrice')->orderBy('sequence','DESC')->paginate(50);
        return view('admin.hospitals.index',compact('hospitals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maxSerial=Hospital::max('sequence');
        return view('admin.hospitals.create',compact('maxSerial'));
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
            'name' => 'required|max: 180',
            'address1' => 'required|max: 240',
            'branch' => 'required|unique:hospitals,branch,NULL,id,deleted_at,NULL',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('photo'))
            {
                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/hospital/',250,155);
            }
            Hospital::create($input);
            return redirect()->back()->with('success','Hospital Successfully Created');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show(Hospital $hospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function edit(Hospital $hospital)
    {
        $data=$hospital;
        $maxSerial=Hospital::max('sequence');
        return view('admin.hospitals.edit',compact('data','maxSerial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hospital $hospital)
    {
        $input = $request->all();
        $id=$hospital->id;

        $validator = Validator::make($input, [
            'name' => 'required|max: 180',
            'address1' => 'required|max: 240',
            'branch' => "required|unique:hospitals,branch,$id,id,deleted_at,NULL",
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('photo')) {
                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/hospital/',250,155);

                if($hospital->photo!=null and file_exists($hospital->photo)){
                    unlink($hospital->photo);
                }
            }
            $hospital->update($input);
            return redirect()->back()->with('success','Hospital Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        try{
            // Delete old test price data -------
            $hospitalWiseTestPrice=HospitalWiseTestPrice::where(['hospital_id'=>$hospital->id])->first();
            if (!empty($hospitalWiseTestPrice)){
                HospitalWiseTestPrice::where(['hospital_id'=>$hospital->id])->delete();
            }

            $hospital->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }
}
