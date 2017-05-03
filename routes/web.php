<?php

Route::get('/contact', array('uses' => 'ContactController@index'))->name('contact');
Route::get('/page-not-found', array('uses' => 'HomeController@pageNotFound'))->name('page-not-found');

Auth::routes();
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', array('uses' => 'HomeController@index'))->name('home');
    Route::get('/home', array('uses' => 'HomeController@index'))->name('home');
    Route::get('login/{token?}/{email?}', array('uses' => 'UserController@showLogin'))->name('login');
    Route::post('login', array('uses' => 'Auth\LoginController@login'))->name('login');
    Route::group(['prefix' => 'register'], function () {
        Route::get('/pool-owner-register', array('uses' => 'RegisServiceController@poolOwnerIndex'))->name('pool-owner-register');
        Route::post('/pool-owner-register', array('uses' => 'RegisServiceController@addNewPoolOwner'))->name('pool-owner-register');

        Route::get('/pool-service-register', array('uses' => 'RegisServiceController@poolServiceIndex'))->name('pool-service-register');
        Route::post('/pool-service-register', array('uses' => 'RegisServiceController@addNewPoolService'))->name('pool-service-register');

        Route::post('/check-email-exists', array('uses' => 'RegisServiceController@check_email_exists'))->name('check-email-exists');
        Route::post('/check-zipcode-exists', array('uses' => 'RegisServiceController@check_zipcode_exists'))->name('check-zipcode-exists');
        Route::post('/add-email-notify', array('uses' => 'RegisServiceController@addEmailNotify'))->name('add-email-notify');
    });
    Route::group(['prefix' => 'technician'], function () {
        Route::get('verify/{confirmCode}', array('uses' => 'Auth\LoginController@verify'))->name('technician-verify');
        Route::post('verify', array('uses' => 'Auth\LoginController@confirm'))->name('technician-confirm');
    });
});

Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/started', array('uses' => 'PoolOwner\PoolOwnerController@started'))->name('started');
    
    //Route::group(['middleware' => ['permission']], function () {

        Route::group(['prefix' => 'poolowner'], function () {
            Route::get('', array('uses' => 'PoolOwner\PoolOwnerController@index'))->name('pool-owner');
            Route::post('update-billing-info', array('uses' => 'PoolOwner\PoolOwnerController@updateBillingInfo'))->name('update-billing-info');
            Route::get('select-company/{company_id}', array('uses' => 'PoolOwner\PoolOwnerController@selectCompany'))->name('select-company');
            Route::get('select-new-company/{company_id}', array('uses' => 'PoolOwner\PoolOwnerController@selectNewCompany'))->name('select-new-company');
            Route::post('rating-company', array('uses' => 'PoolOwner\PoolOwnerController@ratingCompany'))->name('rating-company');
            Route::get('get-point-rating-company/{company_id}', array('uses' => 'PoolOwner\PoolOwnerController@getPointRatingCompany'))->name('get-point-rating-company');
        });
        
        Route::group(['prefix' => 'company'], function () {
            //Route::post('accept-offer/{id}', 'Company\ApiCompanyController@acceptOffer')->name('dashboard-company-accept-offer');
            //Route::post('deny-offer/{id}', 'Company\ApiCompanyController@denyOffer')->name('dashboard-company-deny-offer');
            //Route::post('change-status-offer', 'Company\ApiCompanyController@changeOfferStatus')->name('dashboard-company-update-offer');
            Route::post('change-services-offer', 'Company\ApiCompanyController@changeServiceOffer')->name('dashboard-company-change-services-offer');
        });

        Route::post('/upload-company-profile', array('uses' => 'Company\CompanyController@addCompanyProfile'))->name('upload-company-profile');
        Route::group(['prefix' => 'service-company'], function () {
            Route::get('', array('uses' => 'Company\CompanyController@index'))->name('service-company');
        });
        Route::group(['prefix' => 'technician'], function () {
            Route::get('', array('uses' => 'TechnicianController@index'))->name('technician');
            Route::get('enroute/{chedule_id}', array('uses' => 'TechnicianController@enroute'))->name('technician-enroute');
            Route::post('complete-steps', array('uses' => 'TechnicianController@completeSteps'))->name('technician-complete-steps');
            Route::post('unable-steps', array('uses' => 'TechnicianController@unableSteps'))->name('technician-unable-steps');
            
            Route::post('list-technician', 'Company\ApiCompanyController@listTechnician')->name('dashboard-company-list-technician');
            Route::post('save-technician', 'Company\ApiCompanyController@saveTechnician')->name('dashboard-company-save-technician');
            Route::post('remove-technician', 'Company\ApiCompanyController@removeTechnician')->name('dashboard-company-remove-technician');
        });
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
            Route::post('ajax-upload-file', 'PoolOwner\ApiPoolOwnerController@uploadResizeAvatar')->name('ajax-upload-file');
            Route::post('ajax-upload-image/{folder}', 'ApiController@uploadImage')->name('ajax-upload-image');
        });
    //});
});
