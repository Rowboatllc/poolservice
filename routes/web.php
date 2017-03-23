<?php

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

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('/user-regis-service', array('uses' => 'RegisServiceController@index'))->name('user-regis-service');
Route::post('/user-regis-service', array('uses' => 'RegisServiceController@addNewPoolService'))->name('user-regis-service');
Route::post('/check-email-exists', array('uses' => 'RegisServiceController@check_email_exists'))->name('check-email-exists');

Route::get('test', 'TestController@index');
Route::get('test/abc', 'TestController@abc');
Route::post('test/abc', 'TestController@saveAbc');

Route::get('/admin', array('uses' => 'ManagerController@index'))->name('admin-manager');

Route::get('/admin/manager', array('uses' => 'ManagerController@index'))->name('admin-manager');
Route::post('/admin/manager/contact', array('uses' => 'ManagerController@contact'))->name('admin-manager-contact');

Route::get('/admin/page', array('uses' => 'PageController@index'))->name('admin-page');
Route::post('/admin/page', array('uses' => 'PageController@store'))->name('admin-page');