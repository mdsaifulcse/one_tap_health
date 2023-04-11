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
 ---------- Client Without-Authentication -------
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','prefix' => 'client','as' => 'client.'],function (){
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@generalUserRegister');
});

/*

/*
 ----------client with authentication --- Token ----
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','middleware' => ['auth:sanctum'],'prefix' => 'client','as' => 'client.'],function (){

    /*--------- Common Data load api --------*/
    Route::get('/active-category-list', 'CommonDataLoadController@activeCategoryList');
    Route::get('/active-sub-category-list/{categoryId?}', 'CommonDataLoadController@activeSubcategoryList');
    Route::get('/active-third-sub-category-list/{subCategoryId?}', 'CommonDataLoadController@activeThirdSubcategoryList');

    Route::get('/category-wise-active-test-list/{categoryId}', 'CommonDataLoadController@categoryWiseActiveTestList');

    Route::get('/active-general-users', 'CommonDataLoadController@activeGeneralUserListList');

    // ------------- User Profile ----------------------------
    Route::post('/logout', 'AuthController@logout');
    Route::get('/my-profile', 'ProfileController@profileInfo');
    Route::put('/my-profile-update', 'ProfileController@profileUpdate');
    Route::put('/my-password-change', 'ProfileController@changeMyPassword');

});



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
