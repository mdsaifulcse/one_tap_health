<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestOrder;
use App\Models\TestOrderReportFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Validator,MyHelper,DB;

class TestOrderReportFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $testOrder=TestOrder::with('testReportFile','patient:id,name,mobile,address,age','testOrderDetails:id,test_order_id,test_id,price,discount,approval_status,delivery_status,delivery_date',
            'testOrderDetails.test:id,title','hospital:id,name,branch,address1')
            ->findOrFail($request->test_order_id??'');

        return view('admin.test-report.create',compact('testOrder'));
    }

    public function testReportUpload(Request $request){
        $uploadPath = \MyHelper::multiReportFileUpload($request->file('file'), 'images/test-report/big', 500);

        return response()->json([
            'name' => $uploadPath,
            'test_order_id' => $request->test_order_id ?? 0,
            //'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $rules=$this->validationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->errors()->first());
        }

        try{
            $id = $request->id ?? 0;
            $test_order_id = $request->test_order_id ?? 0;
            $testReport = TestOrderReportFile::where(['id'=>$id,'test_order_id' => $test_order_id])->first();

            if (!empty($testReport)) {
                $files = $testReport->files;
            } else {
                $files = [];
            }

            $reportFiles=[];
            if ($request->input('attachment',[]))
            {
                $reportFiles=$request->input('attachment',[]);
            }


            if (empty($testReport)){
                TestOrderReportFile::create(
                    [
                        'test_order_id'=>$request->test_order_id,
                        'title'=>$request->title,
                        'notes' => $request->notes??'',
                        'files'=>$reportFiles,
                        'status' => $request->status,
                        'created_by' => \Auth::user()->id,
                    ]);
            }else{
                $testReport->update(
                    [
                        'test_order_id'=>$request->test_order_id,
                        'title'=>$request->title,
                        'notes' => $request->notes??'',
                        'files' => array_merge($files, $reportFiles),
                        'status' => $request->status,
                        'created_by' => \Auth::user()->id,
                    ]);
            }





            Log::info('Test report uploaded by admin');
            return redirect()->back()->with('success','Order has been Placed successful');

        }catch(Exception $e){
            Log::info('Test report error web admin: '.$e->getMessage());
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }

    }

    public function validationRules($request){
        $rules=[
            'attachment' => 'required|array|min:1',
            //'attachment.*' => 'image|mimes:jpg,jpeg,bmp,png,webp|max:15240',
            'test_order_id' => "exists:test_orders,id",
            'title' => 'nullable|max:120',
            'notes' => 'nullable|max:500',
        ];
        return $rules;
    }


    public function testReportDelete(Request $request){

        $testReport=TestOrderReportFile::where(['id'=>$request->id,'test_order_id'=>$request->test_order_id])->first();

       $reportFilePath= $testReport->files;

        if (($key = array_search($request->file_path, $reportFilePath)) !== false) {
            unset($reportFilePath[$key]);
        }

        if($request->file_path!=null and file_exists($request->file_path)){
            unlink($request->file_path);
        }

        $testReport->update(['files'=>$reportFilePath]);
        return response()->json('success');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestOrderReportFile  $testOrderReportFile
     * @return \Illuminate\Http\Response
     */
    public function show(TestOrderReportFile $testOrderReportFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestOrderReportFile  $testOrderReportFile
     * @return \Illuminate\Http\Response
     */
    public function edit(TestOrderReportFile $testOrderReportFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestOrderReportFile  $testOrderReportFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestOrderReportFile $testOrderReportFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestOrderReportFile  $testOrderReportFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestOrderReportFile $testOrderReportFile)
    {

    }
}
