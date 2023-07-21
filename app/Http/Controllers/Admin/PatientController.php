<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\TestOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator,MyHelper,DB,Yajra\DataTables\DataTables;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $allData=Patient::select('id','patient_no','name','mobile','email','age','status','created_at');

            return  DataTables::of($allData)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('status','
                     @if($status==\App\Models\Patient::ACTIVE)
                        <button class="btn btn-success btn-sm">Active</button>
                            @else
                            <button class="btn btn-danger btn-sm">Inactive</button>
                        @endif
                ')
                ->addColumn('created_at','
                    {{date(\'M-d-Y\',strtotime($created_at))}}
                ')
                ->addColumn('control','
                    <span class=\'dropdown\'>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route(\'admin.patients.edit\',$id) }}" class="btn btn-warning btn-sm" title="Click here for editing patient data">Edit <i class="icofont icofont-edit"></i> </a></li>
                            <li><a href="javascript:void(0)" onclick="showTestOrderDetailsModal({{$id}})" class="btn btn-success btn-sm" title="Click here for order details">Details <i class="icofont icofont-eye"></i> </a></li>
                            <li>
                                {!! Form::open(array(\'route\' => [\'admin.patients.destroy\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}
                                <button type="button" class="btn btn-danger btn-sm" onclick=\'return deleteConfirm("deleteForm{{$id}}")\'>Delete <i class="icofont icofont-trash"></i></button>
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </span>
                ')
                ->rawColumns(['status','created_at','control'])
                ->toJson();
        }

        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maxSerial=Patient::max('sequence');
        $patientId=Patient::generatePatientId();
        return view('admin.patients.create',compact('maxSerial','patientId'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patientId=Patient::generatePatientId();
        $request['order_no']=$patientId;
        $rules=$this->validationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }

//        if (count(array_unique($request->hospital_id))>1){
//            return $this->respondWithValidation('Validation Fail',"select test from same hospital at a tiem",Response::HTTP_BAD_REQUEST);
//        }

        try{
            Patient::create(
                [
                    'patient_no'=>$patientId,
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'mobile'=>$request->mobile,
                    'age'=>$request->age,
                    'status'=>$request->status,
                    'sequence'=>$request->sequence,
                    'address'=>$request->address,
                    'details'=>$request->details,
                    'created_by' => \Auth::user()->id,
                ]);

            return redirect('admin/patients')->with('success','New patient has been created successful');

        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }
    public function validationRules($request){
        $rules=[
            'patient_no' => 'unique:patients,patient_no,NULL,id,deleted_at,NULL',
            'name'  => "required|max:100",
            'mobile'  => "nullable|max:15",
            'email'  => "nullable|max:15",
            'address'  => "required|max:150",
            'details'  => "nullable|max:150",
        ];
        return $rules;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $patient->load('createdBy');
        return view('admin.patients.show',compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $maxSerial=Patient::max('sequence');
        return view('admin.patients.edit',compact('maxSerial','patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $rules=$this->updateValidationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        try{
            $patient->update( [
                'name'=>$request->name,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
                'age'=>$request->age,
                'status'=>$request->status,
                'sequence'=>$request->sequence,
                'address'=>$request->address,
                'details'=>$request->details,
                'updated_by' => \Auth::user()->id,
            ]);

            return redirect('admin/patients')->with('success','Patient has been updated successful');

        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    public function updateValidationRules($request){
        $rules=[
            'name'  => "required|max:100",
            'mobile'  => "nullable|max:15",
            'email'  => "nullable|max:15",
            'address'  => "required|max:150",
            'details'  => "nullable|max:150",
        ];
        return $rules;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        try{
            $patient->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }
}
