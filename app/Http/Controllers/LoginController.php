<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }


//    public function username()
//    {
//        $loginType = request()->input('mobile');
//        $this->mobile = filter_var($loginType, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
//        request()->merge([$this->mobile => $loginType]);
//        return property_exists($this, 'mobile') ? $this->mobile : 'email';
//    }

}
