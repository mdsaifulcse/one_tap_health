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
 ----------client without authentication --- Token ----
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','prefix' => 'client','as' => 'client.'],function (){

    /*--------- Common Data load api --------*/
    Route::get('/active-category-list', 'CommonDataLoadController@activeCategoryList');
    Route::get('/active-sub-category-list/{categoryId?}', 'CommonDataLoadController@activeSubcategoryList');
    Route::get('/active-third-sub-category-list/{subCategoryId?}', 'CommonDataLoadController@activeThirdSubcategoryList');

    Route::get('/active-country-list', 'CommonDataLoadController@activeCountryList');
    Route::get('/active-language-list', 'CommonDataLoadController@activeLanguageList');
    Route::get('/active-author-list', 'CommonDataLoadController@activeAuthorList');
    Route::get('/active-publisher-list', 'CommonDataLoadController@activePublisherList');
    Route::get('/active-vendors-list', 'CommonDataLoadController@activeVendorsList');
    Route::get('/active-item-search', 'CommonDataLoadController@activeItemSearch');
    Route::get('/active-membership-plan', 'CommonDataLoadController@activeMembershipPlanList');
    Route::get('/active-general-users', 'CommonDataLoadController@activeGeneralUserListList');

});



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
