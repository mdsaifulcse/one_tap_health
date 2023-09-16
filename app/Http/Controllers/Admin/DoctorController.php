<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Validator,MyHelper,DB;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors=Doctor::orderBy('sequence','DESC')->get();
        return view('admin.doctors.index',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $degrees=Doctor::degree();
        $department=Doctor::department();
        $maxSerial=Doctor::max('sequence');
        return view('admin.doctors.create',compact('maxSerial','degrees','department'));
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
            'name' => 'required|max: 150',
            'email' => 'nullable|max: 100',
            'mobile' => 'nullable|max: 15',
            'bio' => 'nullable|max: 500',
            'address' => 'nullable|max: 250',
            'degree' => 'required|max: 100',
            'department' => 'required|max: 120',
            'photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:8120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('photo'))
            {
                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/doctor/',250,155);
            }
            Doctor::create($input);
            return redirect()->back()->with('success','Doctor Created Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        $data=$doctor;
        $maxSerial=Doctor::max('sequence');
        $degrees=Doctor::degree();
        $department=Doctor::department();
        return view('admin.doctors.edit',compact('data','maxSerial','degrees','department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        $input = $request->all();
        $id=$doctor->id;

        $validator = Validator::make($input, [
            'name' => 'required|max: 150',
            'email' => 'nullable|max: 100',
            'mobile' => 'nullable|max: 15',
            'bio' => 'nullable|max: 500',
            'address' => 'nullable|max: 250',
            'degree' => 'required|max: 100',
            'department' => 'required|max: 120',
            'photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:8120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('photo')) {
                $input['photo']=\MyHelper::photoUpload($request->file('photo'),'images/doctor/',250,155);

                if($doctor->photo!=null and file_exists($doctor->photo)){
                    unlink($doctor->photo);
                }
            }
            $doctor->update($input);
            return redirect()->back()->with('success','Hospital Updated Successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        try{
            $doctor->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }
}
