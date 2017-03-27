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

    Route::get('get-page', 'PageController@getPage');
    Route::post('admin/save-option', array('uses' => 'Admin\OptionController@saveOption'))->name('save-option');
    Route::post('admin/login', array('uses' => 'Admin\LoginController@doLogin'))->name('admin-dologin');
    Route::get('get-page', 'PageController@getPage');
// });

