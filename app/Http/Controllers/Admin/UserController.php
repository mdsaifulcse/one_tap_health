<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Validator,MyHelper,DB,Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(User $user)
    {
        $this->users=$user;
    }

    public function index()
    {

        return view('admin.users.index',['users'=>$this->users->allGeneralUsers()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        try{
            $user=$this->users->findOrFail($request->id);

            $user->update(['status'=>$request->status]);

            return redirect()->back()->with('success', 'Status updated successfully!');

        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show',['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        try{
           return view('admin.users.edit',['user'=>$user]);
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request) //UserUpdateRequest $request
    {
        try{
            //$user->update($request->except('_method','_token','user_role'));

            $id=$user->id;
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:50',
                'email'  => "required||max:100|unique:users,email,$id",
                'phone'  => "nullable|max:15|unique:users,phone,$id",
                'address'=> 'nullable|max:100',
                'status'=> 'required|in:0,1',
                'avatar' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            DB::beginTransaction();
            try{

                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'status'=>$request->status,
                ]);

                if (isset($request->contact) || isset($request->address) ||  isset($request->avatar)){

                    $userProfile=UserProfile::where('user_id',$id)->first();

                    $avatarPath='';

                    $profileInput=[
                        'address'=>$request->address,
                        'contact'=>$request->contact,
                        'bio'=>$request->bio,
                        'user_id'=>$id,
                    ];

                    if ($request->hasFile('avatar')) {
                        $avatarPath=\MyHelper::photoUpload($request->file('avatar'),'user-images',200);

                        if (!empty($userProfile) && file_exists($userProfile->avatar)){
                            unlink($userProfile->avatar);
                        }
                        $profileInput['avatar']=$avatarPath;
                    }


                    if (empty($userProfile))
                    {
                        UserProfile::create($profileInput);
                    }else{
                        $userProfile->update($profileInput);
                    }

                }

                $bug=0;
                DB::commit();

            }catch (\Exception $e){
                DB::rollback();
                $bug=$e->errorInfo[1];
            }

        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
        if($bug==0){
            return redirect()->back()->with('success','Updated successfully');
        }elseif($bug==1062){
            return redirect()->back()->with('error','The name has already been taken.');
        }else{
            return redirect()->back()->with('error','Something Error Found ! ');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->back()->with('success', 'Deleted successfully!');

        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }
}
