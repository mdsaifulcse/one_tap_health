<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalWiseTestPrice;
use App\Models\Test;
use Illuminate\Http\Request;
use Validator,MyHelper,DB,DataLoad;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests=Test::with('testCategory','testSubCategory','testThirdCategory')->orderBy('sequence','DESC')->paginate(50);
        return view('admin.tests.index',compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=DataLoad::categoryForWeb();
        $subCategories=DataLoad::subCatForWeb();
        $maxSerial=Test::max('sequence');
        return view('admin.tests.create',compact('maxSerial','categories','subCategories'));
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
            'title' => 'required|unique:tests,title,NULL,id,deleted_at,NULL',
            'sub_title' => 'nullable|max: 150',
            'description' => 'nullable|max: 200',
            'category_id'=>'required|exists:categories,id',
            'subcategory_id'=>'required|exists:sub_categories,id',
            'third_category_id'=>'nullable|exists:third_sub_categories,id',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/test-icon/',150,110);
            }
            Test::create($input);
            return redirect()->back()->with('success','Test Successfully Created');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        $data=$test;
        $maxSerial=Test::max('sequence');
        $categories=DataLoad::categoryForWeb();
        $subCategories=DataLoad::subCatForWeb($data->category_id);
        $thirdSubCategories=DataLoad::thirdSubCatForWeb($data->sub_category_id);
        return view('admin.tests.edit',compact('data','maxSerial','categories','subCategories','thirdSubCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $input = $request->all();
        $id=$test->id;

        $validator = Validator::make($input, [
            'title' => "required|unique:tests,title,$id,id,deleted_at,NULL",
            'sub_title' => 'nullable|max: 150',
            'description' => 'nullable|max: 200',
            'category_id'=>'required|exists:categories,id',
            'subcategory_id'=>'required|exists:sub_categories,id',
            'third_category_id'=>'nullable|exists:third_sub_categories,id',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',

        ]);
        if ($validator->fails()) {
            //return $validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            if ($request->hasFile('icon_photo')) {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/test-icon/',250,155);

                if($test->icon_photo!=null and file_exists($test->icon_photo)){
                    unlink($test->icon_photo);
                }
            }
            $test->update($input);
            return redirect()->back()->with('success','Tests Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        try{
            // Delete old test price data -------
            $hospitalWiseTestPrice=HospitalWiseTestPrice::where(['test_id'=>$test->id])->first();
            if (!empty($hospitalWiseTestPrice)){
                HospitalWiseTestPrice::where(['test_id'=>$test->id])->delete();
            }

            $test->delete();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Some thing error found !'.$e->getMessage());
        }
    }
}
