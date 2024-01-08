<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Validator,MyHelper,DB,Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
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

        if (request()->ajax()) {
            $users=DB::table('users')->where('user_role',User::USER);
            return  DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex','')
                ->addColumn('status','
                     @if($status==\App\Models\User::ACTIVE)
                        <button class="btn btn-success btn-sm">Active</button
                       
                            @else
                            <button class="btn btn-warning btn-sm">InActive</button>
                        @endif
                 
                ')
                ->addColumn('created_at','
                    {{date(\'M-d-Y h:i A\',strtotime($created_at))}}
                ')
                ->addColumn('control','
                    <span class=\'dropdown\'>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                           
                            <li><a href="{{route(\'admin.users.edit\', $id)}}" target="_blank" class="btn btn-warning btn-sm" title="Click here for order details">Edit <i class="icofont icofont-pencil"></i> </a></li>
                            <li><a href="javascript:void(0)" onclick="showUserDetailsModal({{$id}})" class="btn btn-info btn-sm"> Details </a></li>
                           
                            <li>
                                {!! Form::open(array(\'route\' => [\'admin.users.destroy\',$id],\'method\'=>\'DELETE\',\'id\'=>"deleteForm$id")) !!}
                                <button type="button" class="btn btn-danger btn-sm" onclick=\'return deleteConfirm("deleteForm{{$id}}")\'>Delete <i class="icofont icofont-trash"></i></button>
                                {!! Form::close() !!}
                            </li>
                            
                        </ul>
                    </span>
                ')
                ->rawColumns(['status','created_at','control'])
                ->make(true);
        }

        return view('admin.users.index');
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
                    'age'=>$request->age,
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
