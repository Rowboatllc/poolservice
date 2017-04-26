<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Token
Route::post('createtoken', 'TestController@createToken');
Route::post('refreshtoken', 'TestController@refreshNewToken');
Route::post('checktoken', 'TestController@checkToken');

// Route::group(['middleware' => ['auth']], function () {
// Route::post('admin/save-option', array('uses' => 'Admin\OptionController@saveOption'))->name('save-option');
//Route::post('admin/login', array('uses' => 'Admin\LoginController@doLogin'))->name('admin-dologin');
Route::get('get-page', 'PageController@getPage');
Route::post('get-page', 'PageController@getPage');
// });

Route::group(['prefix' => 'admin/option'], function () {
    Route::post('removeoption', array('uses' => 'Admin\OptionController@removeoption'))->name('remove-option');
    Route::post('save-option', array('uses' => 'Admin\OptionController@saveOption'))->name('save-option');
    Route::post('save-group', array('uses' => 'Admin\OptionController@saveGroup'))->name('save-groupoption');    
});

Route::group(['prefix' => 'poolowner', 'middleware' => ['api.token']], function () {
    // Route::post('update-billing-info', array('uses' => 'PoolOwner\ApiPoolOwnerController@updateBillingInfo'))->name('update-billing-info');
    Route::post('save-email', 'PoolOwner\ApiPoolOwnerController@saveNewEmail')->name('dashboard-poolowner-save-email');
    Route::post('save-password', 'PoolOwner\ApiPoolOwnerController@saveNewPassword')->name('dashboard-poolowner-save-password');
    Route::post('save-poolowner-profile', 'PoolOwner\ApiPoolOwnerController@saveProfile')->name('dashboard-poolowner-save-profile');
    Route::post('save-poolowner-poolinfo', 'PoolOwner\ApiPoolOwnerController@savePoolInfo')->name('dashboard-poolowner-save-poolinfo');
});  
            
Route::group(['prefix' => 'company', 'middleware' => ['api.token']], function () {
    //Route::post('accept-offer/{id}', 'Company\ApiCompanyController@acceptOffer')->name('dashboard-company-accept-offer');
    //Route::post('deny-offer/{id}', 'Company\ApiCompanyController@denyOffer')->name('dashboard-company-deny-offer');
    Route::post('change-status-offer', 'Company\ApiCompanyController@changeOfferStatus')->name('dashboard-company-update-offer');
});

Route::group(['prefix' => 'technician', 'middleware' => ['api.token']], function () {
    Route::post('save-technician', 'Company\ApiCompanyController@saveTechnician')->name('dashboard-company-save-technician');
    Route::post('remove-technician', 'Company\ApiCompanyController@removeTechnician')->name('dashboard-company-remove-technician');
});