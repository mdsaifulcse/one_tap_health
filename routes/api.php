<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*
 ----------SSL Commerce ----
*/

Route::group(['namespace'=>'App\Http\Controllers\SSLCommerz','prefix' => 'sslPay','as' => 'sslPay.'],function (){
    Route::POST('/pay',  'PublicSslCommerzPaymentController@index');
    Route::POST('/success', 'PublicSslCommerzPaymentController@success');
    Route::POST('/fail', 'PublicSslCommerzPaymentController@fail');
    Route::POST('/cancel', 'PublicSslCommerzPaymentController@cancel');
    Route::POST('/ipn', 'PublicSslCommerzPaymentController@ipn');

});



/*
 ---------- Client Without-Authentication -------
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','prefix' => 'client','as' => 'client.'],function (){
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@generalUserRegister');
});

/*

/*
 ----------client without authentication --- Token ----
*/

Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','prefix' => 'client','as' => 'client.'],function (){
    Route::get('/search-active-users', 'SearchController@searchActiveUsers');
    Route::get('/search-active-patients', 'SearchController@searchActivePatients');
    Route::get('/search-active-doctors', 'SearchController@searchActiveDoctors');
    Route::get('/search-active-hospitals', 'SearchController@searchActiveHospitals');
});



/*
 ----------client with authentication --- Token ----
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','middleware' => ['auth:sanctum'],'prefix' => 'client','as' => 'client.'],function (){

    /*--------- Doctor Appointment Api --------*/
    Route::apiResource('/doctor-appointment', 'DoctorAppointmentController');

    /*--------- Test Order Api --------*/
    Route::apiResource('/test-order', 'TestOrderController');

    /*--------- Hospital Api --------*/
    Route::get('/active-hospital-list', 'HospitalApiController@activeHospitalsList');
    Route::get('hospital-wise-test-details/{hospitalId}', 'HospitalApiController@hospitalWiseTestDetails');

    /*--------- Doctor Api --------*/
    Route::get('/active-doctors-list', 'DoctorApiController@activeDoctorsList');
    Route::get('/doctor-schedules/{doctorId}', 'DoctorApiController@doctorWiseScheduleForHospital');

    /*--------- Pathology Test Api --------*/
    Route::get('/active-category-list', 'PathologyTestController@activeCategoryList');
    Route::get('/active-sub-category-list/{categoryId?}', 'PathologyTestController@activeSubcategoryList');
    Route::get('/active-third-sub-category-list/{subCategoryId?}', 'PathologyTestController@activeThirdSubcategoryList');

    Route::get('/category-wise-active-test-list/{categoryId}', 'PathologyTestController@categoryWiseActiveTestList');

    Route::get('/cost-of-hospitals-test', 'PathologyTestController@costOfHospitalsTest');

    Route::get('/active-general-users', 'PathologyTestController@activeGeneralUserListList');

    // ------------- User Profile ----------------------------
    Route::post('/logout', 'AuthController@logout');
    Route::get('/my-profile', 'ProfileController@profileInfo');
    Route::put('/my-profile-update', 'ProfileController@profileUpdate');
    Route::put('/my-password-change', 'ProfileController@changeMyPassword');

});



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
