<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//HospitalWiseTestPrice
/*
 ----------Admin Without-Authentication  -------
*/
Route::group(['prefix' => 'login','as' => 'login.'],function () {
     Route::get('admin',  [\App\Http\Controllers\LoginController::class,'showAdminLoginForm'])->name('admin');
    Route::post('/admin', 'App\Http\Controllers\LoginController@adminLogin');
});
//Route::get('/login/admin',  [\App\Http\Controllers\LoginController::class,'showAdminLoginForm'])->name('login.admin');



Route::group(['middleware' => ['auth','admin'],'prefix' => 'admin','as' => 'admin.'], function() {

    Route::resource('test-orders',\App\Http\Controllers\Admin\TestOrderController::class );
    Route::get('load-hospital-wise-test-details/{hospitalId}','App\Http\Controllers\Admin\TestOrderController@createTestOrderDetails' );
    Route::resource('hospital-wise-doctor-schedule',\App\Http\Controllers\Admin\HospitalWiseDoctorScheduleController::class );
    Route::resource('set-test-price',\App\Http\Controllers\Admin\HospitalWiseTestPriceController::class );

    Route::resource('doctors',\App\Http\Controllers\Admin\DoctorController::class );
    Route::resource('hospitals',\App\Http\Controllers\Admin\HospitalController::class );
    Route::resource('tests',\App\Http\Controllers\Admin\TestController::class );
    // ----------- For Categories, SubCategories ThirdSubCategory----------
    Route::resource('categories',\App\Http\Controllers\Admin\CategoryController::class );
    Route::resource('sub-categories',\App\Http\Controllers\Admin\SubCategoryController::class );
    Route::resource('third-sub-categories',\App\Http\Controllers\Admin\ThirdSubCategoryController::class );

    // ----------- On Change load -----------------
    Route::get('/load-sub-cat-by-cat/{categoryId}', '\App\CustomFacades\DataLoadController@loadSubCatsByCat');
    Route::get('/load-third-sub-cat-by-sub-cat/{subCategoryId}', '\App\CustomFacades\DataLoadController@loadThirdSubCatsByCat');

    // ----------- For admin & developer ----------
    Route::get('/profile', 'ProfileController@myProfile');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class,'dashboard'] );
    Route::get('/edit-my-profile', [\App\Http\Controllers\Admin\ProfileController::class,'editMyProfile']);
    Route::put('/update-my-profile', [\App\Http\Controllers\Admin\ProfileController::class,'updateMyProfile'])->name('update-my-profile');

    Route::get('/change-my-password', [\App\Http\Controllers\Admin\ProfileController::class,'changeMyPassword'] );
    Route::put('/update-my-password', [\App\Http\Controllers\Admin\ProfileController::class,'updateMyPassword'] )->name('update-my-password');

    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class );
    Route::resource('/quizzes', \App\Http\Controllers\Admin\QuizController::class );
});


Route::get('/', function (){
    return redirect('/login');
});

