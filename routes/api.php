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

Route::post('createtoken', 'TestController@createToken');

Route::post('get-page', 'PageController@getPage');

Route::get('get-page', 'PageController@getPage');



Route::post('admin/save-option', array('uses' => 'Admin\OptionController@saveOption'))->name('save-option');
Route::post('admin/login', array('uses' => 'Admin\LoginController@doLogin'))->name('admin-dologin');
