<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\ZoneArea;
use Illuminate\Http\Request;
use Validator,MyHelper,DB;

class ZoneAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $district=District::findOrFail($request->district_id);

        $allData=ZoneArea::with('district')->where(['district_id'=>$request->district_id])->orderBy('name','ASC')->get();
        return view('admin.areas.index',compact('district','allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'district_id' => 'required|exists:districts,id',
            'bn_name' => 'nullable|max: 150',
            'details' => 'nullable|max:300',
            'status' => 'required|in:0,1',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
            ZoneArea::create(
                [
                    'district_id'=>$request->district_id,
                    'name'=>$request->name,
                    'bn_name'=>$request->bn_name,
                    'details'=>$request->details,
                    'status'=>$request->status,
                ]
            );

            return redirect()->back()->with('success','Area Successfully Updated');

        }catch (\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZoneArea  $zoneArea
     * @return \Illuminate\Http\Response
     */
    public function show(ZoneArea $zoneArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ZoneArea  $zoneArea
     * @return \Illuminate\Http\Response
     */
    public function edit(ZoneArea $zoneArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZoneArea  $zoneArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $zoneArea=ZoneArea::findOrFail($request->id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|max: 150',
            //'district_id' => 'required|exists:districts,id',
            'bn_name' => 'nullable|max: 150',
            'details' => 'nullable|max:300',
            'status' => 'required|in:0,1',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $zoneArea->update(
                [
                    //'district_id'=>$request->district_id,
                    'name'=>$request->name,
                    'bn_name'=>$request->bn_name,
                    'details'=>$request->details,
                    'status'=>$request->status,
                ]
            );

            return redirect()->back()->with('success','Area Successfully Updated');

        }catch (\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZoneArea  $zoneArea
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $zoneArea=ZoneArea::findOrFail($id);
        try{
            $zoneArea->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !');
        }
    }
}
