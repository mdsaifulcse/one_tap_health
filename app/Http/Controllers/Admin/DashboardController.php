<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\TestOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request){


        //return TestOrder::with('testOrderPaymentHistories')->where('payment_status','!=',self::PENDING);


        // Data come form Admin Dashboard service Provider
        return view('admin.dashboard');
    }
}