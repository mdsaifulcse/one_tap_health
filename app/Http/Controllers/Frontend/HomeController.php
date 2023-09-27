<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        return view('client.index');
    }

    public function termAndCondition(){
        return view('client.terms-condition');
    }

    public function privacyPolicy(){
        return view('client.privacy-policy');
    }
    public function refundPolicy(){
        return view('client.refund-policy');
    }
}
