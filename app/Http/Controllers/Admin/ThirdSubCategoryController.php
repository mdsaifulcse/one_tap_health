<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Test;
use App\Models\ThirdSubCategory;
use Illuminate\Http\Request;
use DB,Auth,Validator,MyHelper;

class ThirdSubCategoryController extends Controller
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
        if (is_null($request->link))
        {
            $input['link']= MyHelper::slugify($request->third_sub_category);
        }


        $validator = Validator::make($input, [
            'third_sub_category' => 'required|unique:third_sub_categories,third_sub_category,NULL,id,deleted_at,NULL',
            'link' => 'required|unique:third_sub_categories,link,NULL,id,deleted_at,NULL',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input['created_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/third-sub-categories/',100);
            }

            ThirdSubCategory::create($input);
            return redirect()->back()->with('success','Data Successfully Inserted');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThirdSubCategory  $thirdSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $sutCategory=SubCategory::with('category')->findOrFail($id);
        $allData=ThirdSubCategory::with('subCategory')->where('sub_category_id',$id)->orderBy('sequence','DESC')
            ->paginate(50);

        $max_serial=ThirdSubCategory::where('sub_category_id',$id)->max('sequence');

        return view('admin.categories.third-sub-category',compact('allData','sutCategory','max_serial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThirdSubCategory  $thirdSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ThirdSubCategory $thirdSubCategory)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThirdSubCategory  $thirdSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        if (is_null($request->link))
        {
            $input['link']= MyHelper::slugify($request->third_sub_category);
        }

        $validator = Validator::make($input, [
            'third_sub_category' => "required|unique:third_sub_categories,third_sub_category,$id,id,deleted_at,NULL",
            'link' => "required|unique:third_sub_categories,link,$id,id,deleted_at,NULL",
            'sub_category_id' => 'required|exists:sub_categories,id',
            'icon_photo' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:5120',
        ]);
        if ($validator->fails())
        {

            return redirect()->back()->with('error','Something Error found.'.$validator->getmessagebag());
        }
        $data=ThirdSubCategory::findOrFail($id);
        $input['updated_by']=\Auth::user()->id;

        try{

            if ($request->hasFile('icon_photo'))
            {
                $input['icon_photo']=\MyHelper::photoUpload($request->file('icon_photo'),'images/third-sub-categories/',100);

                if($data->icon_photo!=null and file_exists($data->icon_photo))
                {
                    unlink($data->icon_photo);
                }
            }


            $data->update($input);
            return redirect()->back()->with('success','Data Successfully Updated');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something Error Found ! '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThirdSubCategory  $thirdSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThirdSubCategory $thirdSubCategory)
    {

        try{
            $thirdSubCategory->delete();
            $bug=0;
            $error=0;
        }catch(\Exception $e)
        {
            $bug=$e->errorInfo[1];
            $error=$e->errorInfo[2];
        }
        if($bug==0)
        {
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }elseif($bug==1451)
        {
            return redirect()->back()->with('error','This Data is Used anywhere ! ');
        }
        elseif($bug>0)
        {
            return redirect()->back()->with('error','Some thing error found !'.$bug);
        }
    }
}
