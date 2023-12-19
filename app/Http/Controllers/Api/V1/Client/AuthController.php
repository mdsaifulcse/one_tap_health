<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB,Validator,Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function generalUserRegister(Request $request){
        $rules=$this->registerValidationRules($request);
        $validator = Validator::make( $request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        //DB::beginTransaction();
        try{
            $input=[
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address?$request->address:'',
                'firebase_token'=>$request->firebase_token?$request->firebase_token:'',
                'user_role'=>$request->user_role,
                'status'=>$this->user::APPROVED,
                'password'=>Hash::make($request->password)
            ];

            // Photo upload ------
            $avatarPath='';
            if ($request->hasFile('photo')){
                $avatarPath=\MyHelper::photoUpload($request->file('photo'),'images/user-photo',150);
                $input['profile_photo_path']=$avatarPath;
            }

            $input['birth_date']=$request->birth_date?date('Y-m-d',strtotime($request->birth_date)):null;

            $user = $this->user->create($input);

            //$user->assignRole($request->input('roles'));
            //DB::commit();
            return $this->respondWithSuccess('You have successfully registered',new UserResource($user),Response::HTTP_OK);
            //return $this->adminLogin('User has been successfully registered and logged in',$user,'',$request->password);
        }catch (\Exception $e){
            //DB::rollback();
            return $this->respondWithError('Something went wrong',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function registerValidationRules($request){
        $rules=[
            'name' => 'required|max:100',
            'email'  => "nullable|unique:users,email,NULL,id,deleted_at,NULL|email|max:100",
            'phone'  => "required|unique:users,phone,NULL,id,deleted_at,NULL|max:15",
            'user_role' => 'required|in:3,4,5',
            'birth_date' => 'date',
            'address' => 'nullable|max:250',
            'password' => 'required|same:confirm_password',
            'photo' => 'image|mimes:jpeg,jpg,png,gif|nullable|max:4048',
        ];
        return $rules;
    }

    public function login(Request $request){

        $rules=$this->loginValidationRules($request);
        $validator = Validator::make($request->all(), $rules); //$request->json()->all()

        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        try{

            $user = User::where('phone', $request->username)
                ->orWhere('email',$request->username)
                //->orWhere('username',$request->username)
                //->where('user_role',User::ADMIN)
                ->activeUser([$this->user::USER])
                ->first();

            if (!$user) {
                return $this->respondWithError('Credentials do not match',['Credentials do not match'],Response::HTTP_NOT_FOUND);
            }

            // Update fcm_token for new device login -------
            if ($request->filled('fcm_token') && $user->fcm_token!=$request->fcm_token){
                $user->update(['fcm_token'=>$request->fcm_token]);
            }

            return $this->clientLogin('You have successfully logged in',new UserResource($user),'client-login',$request->password);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function loginValidationRules($request){

        $rules=[
            'password' => 'required',
            'username' => 'required'
        ];

        return $rules;

//        if ($request->has('mobile_number')){
//            $rules+=[
//                'mobile_number' => 'required'
//            ];
//        }elseif ($request->has('email')){
//            $rules+=[
//                'email' => 'required'
//            ];
//        }
//        return $rules;
    }


    public function logout(){
        $user= Auth::user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->respondWithSuccess('You successfully logged out',[],Response::HTTP_OK);
    }

    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(),
            [
                'username' => ['required'],
                'new_password' => ['required','min:8'],
                'new_confirm_password' => ['same:new_password'],
            ]);

        if ($validator->fails()) {
            return $this->respondWithValidation('Validation Fail',$validator->errors()->first(),Response::HTTP_BAD_REQUEST);
        }

        try{

            $user = User::where('phone', $request->username)
                ->activeUser([$this->user::USER])
                ->first();

            if (!$user) {
                return $this->respondWithError('Username does not match to our record',['Username does not match to our record'],Response::HTTP_NOT_FOUND);
            }

            // Password Update -------
            $user->update([
                'password'=>Hash::make($request->new_password),
            ]);
            return $this->respondWithSuccess('You password is Successfully Update',[],Response::HTTP_OK);
        }catch(\Exception $e){
            return $this->respondWithError('Something went wrong, Try again later',$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
