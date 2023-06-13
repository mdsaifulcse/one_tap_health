<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalWiseTestPrice;
use App\Models\TestOrder;
use Illuminate\Http\Request;
use Validator,MyHelper,DB,Yajra\DataTables\DataTables;

class TestOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testOrders=TestOrder::orderBy('created_at','DESC')->paginate(20);

        if (request()->ajax()) {
            $allData=TestOrder::with('hospital');

            return  DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('hospitals_name',function (TestOrder $testOrder){
                    return $testOrder->hospital->name;
                })
                ->addColumn('test_date','
                    {{date(\'M-d-Y\',strtotime($test_date))}}
                ')
                ->addColumn('visit_status','
                     @if($visit_status==\App\Models\TestOrder::YES)
                        <button class="btn btn-success btn-sm">Yes</button>
                            @else
                            <button class="btn btn-warning btn-sm">No</button>
                        @endif
                ')
                ->addColumn('payment_status','
                     @if($payment_status==\App\Models\TestOrder::PARTIALPAYMENT)
                        <button class="btn btn-warning btn-sm">Partial</button>
                        
                        @elseif($payment_status==\App\Models\TestOrder::FULLPAYMENT)
                        <button class="btn btn-success btn-sm">Full</button>
                            @else
                            <button class="btn btn-danger btn-sm">Due</button>
                        @endif
                ')
                ->addColumn('created_at','
                    {{date(\'M-d-Y\',strtotime($created_at))}}
                ')
                ->rawColumns(['hospitals_name','test_date','visit_status','payment_status','created_at'])
                ->toJson();
        }

        return view('admin.test-orders.index',compact('testOrders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maxSerial=Hospital::max('sequence');
        return view('admin.test-orders.create',compact('maxSerial'));
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
        return view('admin.test-orders.edit',compact('data','maxSerial'));
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
