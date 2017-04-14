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


Route::get('/contact', array('uses' => 'ContactController@index'))->name('contact');
Route::get('/page-not-found', array('uses' => 'HomeController@pageNotFound'))->name('page-not-found');

Auth::routes();
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', array('uses' => 'HomeController@index'))->name('home');
    Route::get('/home', array('uses' => 'HomeController@index'))->name('home');

    Route::group(['prefix' => 'register'], function () {
        Route::get('/pool-owner-register', array('uses' => 'RegisServiceController@poolOwnerIndex'))->name('pool-owner-register');
        Route::post('/pool-owner-register', array('uses' => 'RegisServiceController@addNewPoolOwner'))->name('pool-owner-register');

        Route::get('/pool-service-register', array('uses' => 'RegisServiceController@poolServiceIndex'))->name('pool-service-register');
        Route::post('/pool-service-register', array('uses' => 'RegisServiceController@addNewPoolService'))->name('pool-service-register');

        Route::post('/check-email-exists', array('uses' => 'RegisServiceController@check_email_exists'))->name('check-email-exists');
        Route::post('/check-zipcode-exists', array('uses' => 'RegisServiceController@check_zipcode_exists'))->name('check-zipcode-exists');
        Route::post('/add-email-notify', array('uses' => 'RegisServiceController@addEmailNotify'))->name('add-email-notify');

        Route::get('/user-confirm-service/{token}/{email}', array('uses' => 'RegisServiceController@userConfirmService'))->name('user-confirm-service');
        Route::post('/user-confirm-service', array('uses' => 'RegisServiceController@doUserConfirmService'))->name('user-confirm-service');
    });
});


Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/started', array('uses' => 'PoolOwner\PoolOwnerController@started'))->name('started');
    Route::group(['prefix' => 'poolowner'], function () {
        Route::get('', array('uses' => 'PoolOwner\PoolOwnerController@index'))->name('poolowner');
        Route::get('select_company/{company_id}', array('uses' => 'PoolOwner\PoolOwnerController@selectCompany'))->name('select_company');
        Route::get('select_new_company', array('uses' => 'PoolOwner\PoolOwnerController@selectNewCompany'))->name('select_new_company');
        Route::post('rating_company', array('uses' => 'PoolOwner\PoolOwnerController@ratingCompany'))->name('rating_company');
    });

    Route::group(['middleware' => ['permission']], function () {
        
        Route::group(['prefix' => 'admin'], function () {
            
            Route::get('', array('uses' => 'Admin\DashboardController@index'))->name('admin-administrator');
            Route::get('poolowner', 'Admin\PoolOwnerController@index')->name('admin-poolowner');
            Route::get('poolservice', 'Admin\PoolServiceController@index')->name('admin-poolservice');
            Route::get('teachnican', 'Admin\TechnicianController@index')->name('admin-technician');
            Route::get('admin', 'Admin\AdministratorController@index')->name('admin-administrator');

            Route::post('option/contact', array('uses' => 'Admin\DashboardController@contact'))->name('admin-option-contact');

            Route::get('/page', array('uses' => 'PageController@index'))->name('admin-page');
            Route::post('/page', array('uses' => 'PageController@store'))->name('admin-page');

            // Token
            Route::get('deletetoken/{id}', 'TestController@deleteToken');
            Route::get('revoketoken/{id}/{revoke?}', 'TestController@revokeToken');
            
            //Option
            Route::get('option', array('uses' => 'Admin\OptionController@index'))->name('admin-option');
            
            //Profile
            Route::post('ajax-upload-file', 'PoolOwner\PoolOwnerController@uploadResizeAvatar')->name('ajax-upload-file');
            
        });
    });
});


