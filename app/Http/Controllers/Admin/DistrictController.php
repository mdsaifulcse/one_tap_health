<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData=District::withCount('zoneArea')->orderBy('name','ASC')->get();
        return view('admin.districts.index',compact('allData'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importDistricts()
    {
        $status='Failed';
        $contents = \File::get('admin/districts.json');
        $districtsJson =(array) json_decode($contents);

         if (count($districtsJson['districts'])>0){
             foreach ($districtsJson['districts'] as $district){

                 District::withTrashed()->updateOrCreate(
                     [
                         'name'=>$district->name,
                         'bn_name'=>$district->bn_name,
                     ],[
                         'name'=>$district->name,
                         'name_bn'=>$district->bn_name,
                         'lat'=>$district->lat,
                         'long'=>$district->long,
                         'status'=>District::ACTIVE,
                         'deleted_at'=>NULL,
                 ])->restore();
             }
             $status='Succeed';
         }
         return $status;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        try{
            $district->update(
                [
                    'name'=>$request->name,
                    'bn_name'=>$request->bn_name,
                    'status'=>$request->status,
                ]
            );

            return redirect()->back()->with('success','District Successfully Updated');

        }catch (\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        try{
            $district->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !');
        }

    }
}
