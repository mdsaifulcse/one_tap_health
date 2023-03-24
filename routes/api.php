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

/*  Login For Client and Admin  */

/*
 ---------- Client Without-Authentication -------
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','prefix' => 'login','as' => 'login.'],function (){
    Route::post('/client', 'AuthController@login');
    Route::post('/register', 'AuthController@generalUserRegister');
});

/*
 ---------- Client with Authentication(Token) -------
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Client','middleware' => ['auth:sanctum'],'prefix' => 'client','as' => 'client.'],function (){

    Route::post('/logout', 'AuthController@logout');
    Route::get('/my-profile', 'ProfileController@profileInfo');
    Route::put('/my-profile-update', 'ProfileController@profileUpdate');
    Route::put('/my-password-change', 'ProfileController@changeMyPassword');
});



/*
 ----------Admin Without-Authentication  -------
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Admin','prefix' => 'login','as' => 'login.'],function (){
    Route::post('/admin', 'AuthController@login');
    Route::get('/test-data', 'CategoryController@testData');
});

/*
 ----------Admin With-Authentication(Token)  -------
*/
Route::group(['namespace'=>'App\Http\Controllers\Api\V1\Admin','middleware' => ['auth:sanctum'],'prefix' => 'admin','as' => 'admin.'],function (){

    /*--------- Common Data load api --------*/
    Route::get('/category-list', 'CommonDataLoadController@activeCategoryList');
    Route::get('/sub-category-list/{categoryId?}', 'CommonDataLoadController@activeSubcategoryList');
    Route::get('/active-third-sub-category-list/{subCategoryId?}', 'CommonDataLoadController@activeThirdSubcategoryList');

    Route::get('/active-country-list', 'CommonDataLoadController@activeCountryList');
    Route::get('/active-language-list', 'CommonDataLoadController@activeLanguageList');
    Route::get('/active-author-list', 'CommonDataLoadController@activeAuthorList');
    Route::get('/active-publisher-list', 'CommonDataLoadController@activePublisherList');
    Route::get('/active-vendors-list', 'CommonDataLoadController@activeVendorsList');
    Route::get('/active-item-search', 'CommonDataLoadController@activeItemSearch');
    Route::get('/active-membership-plan', 'CommonDataLoadController@activeMembershipPlanList');
    Route::get('/active-general-users', 'CommonDataLoadController@activeGeneralUserListList');

    /*--------- Item Return --------*/
    Route::apiResource('/item-returns', 'ItemReturnController');
    Route::get('/item-return-num', 'ItemReturnController@generateItemReturnNo');
    Route::get('/returnAbleRentalItemByRentalId/{rentalId}', 'ItemReturnController@returnAbleRentalItemByRentalId');

    /*--------- Item Rental --------*/
    Route::apiResource('/item-rentals', 'ItemRentalController');
    Route::get('/item-rental-num', 'ItemRentalController@generateItemRentalNo');

    /*--------- Vendor Payment--------*/
    Route::apiResource('/vendor-payments', 'VendorPaymentController');
    Route::get('/vendor-payment-num', 'VendorPaymentController@generateVendorPaymentNo');
    Route::get('/vendorPaymentsByReceivedId/{receivedId}', 'VendorPaymentController@vendorPaymentsByReceivedId');
    Route::get('/payableReceivedOrderByReceivedId/{receivedId}', 'VendorPaymentController@payableReceivedOrderByReceivedId');

    /*--------- Item receive--------*/
    Route::apiResource('/item-received', 'ItemReceiveController');
    Route::get('/item-received-num', 'ItemReceiveController@generateItemReceiveNo');
    Route::get('/unreceivedOrderByOrderId/{orderId}', 'ItemReceiveController@unReceivedOrderByOrderId');

    /*--------- Item Order--------*/
    Route::apiResource('/item-orders', 'ItemOrderController');
    Route::get('/item-order-num', 'ItemOrderController@generateOrderInvoiceNo');

    /*--------- Item --------*/
    Route::apiResource('/items', 'ItemController');
    Route::get('/items-inventory-stock', 'ItemController@itemsInventoryStock');
    Route::get('/item-max-sequence', 'ItemController@getMaxSequence');

    /* -------- Item Prerequisite  ------- */
    Route::apiResource('/vendors', 'VendorController');
    Route::get('/vendor-max-sequence', 'VendorController@getMaxSequence');

    Route::apiResource('/categories', 'CategoryController');
    Route::get('/category-max-sequence', 'CategoryController@getMaxSequence');

    Route::apiResource('/sub-categories', 'SubCategoryController');
    Route::get('/sub-category-max-sequence', 'SubCategoryController@getMaxSequence');

    Route::apiResource('/third-sub-categories', 'ThirdSubCategoryController');
    Route::get('/third-sub-categories-max-sequence', 'ThirdSubCategoryController@getMaxSequence');

    Route::apiResource('/authors', 'AuthorController');
    //Route::post('/authors/{id}', 'AuthorController@update');
    Route::get('/author-max-sequence', 'AuthorController@getMaxSequence');

    Route::post('/login-user', 'AuthorController@loginCustom');

    Route::apiResource('/countries', 'CountryController');
    Route::get('/country-max-sequence', 'CountryController@getMaxSequence');

    Route::apiResource('/languages', 'LanguageController');
    Route::get('/language-max-sequence', 'LanguageController@getMaxSequence');

    Route::apiResource('/publishers', 'PublisherController');
    Route::get('/publisher-max-sequence', 'PublisherController@getMaxSequence');

    Route::apiResource('/user-membership', 'UserMembershipController');

    Route::apiResource('/membership-plans', 'MembershipController');
    Route::get('/membership-plans-max-sequence', 'MembershipController@getMaxSequence');

    Route::get('/users/{roleType?}', 'UserController@allUserList');//client=General type User, admin='Admin type user(admin,superamin....)'
    Route::get('/user-by-id/{useId}', 'UserController@userInfoById');
    Route::put('/user-update/{useId}', 'UserController@userUpdateById');
    Route::put('/update-user-password/{useId}', 'UserController@userChangePassword');
    Route::delete('/delete-user/{useId}', 'UserController@destroy');

    Route::post('/register', 'UserController@adminRegister');
    Route::post('/logout', 'AuthController@logout');
    Route::get('/my-profile', 'ProfileController@profileInfo');
    Route::put('/my-profile-update', 'ProfileController@profileUpdate');
    Route::put('/my-password-change', 'ProfileController@changeMyPassword');
});



//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
