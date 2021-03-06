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




Route::group(['middleware' => ['auth', 'verified', 'ISLverified']], function(){

    Route::get('test', function () { $user = \Auth::user(); dd($user); });


    Route::group(['middleware' => 'initial_superadmin'], function() {
        Route::get('home', 'HomeController@index')->name('home');
        Route::get('report', 'ReportsController@landing')->name('report');
        Route::get('account', 'AccountController@landing')->name('account');
        Route::get('message', 'MessageController@landing')->name('message');




        Route::group(['middleware' => 'superadmin'], function() {

            Route::post('system', 'SystemController@postCreateSystem')->name('system-post');
            Route::post('correctiveaction', 'ActionController@postCreateCorrectiveAction')->name('correctiveaction-post');
            Route::post('config', 'ConfigurationController@postCreateConfig')->name('config-post');
            Route::post('system_devices', 'SystemController@postUpdateSystemDevices')->name('system_devices-post');
            Route::post('update_system', 'SystemController@postUpdateSystem')->name('update_system-post');
            Route::post('delete_system', 'SystemController@postDeleteSystem')->name('delete_system-post');
            Route::post('update_correctiveaction', 'ActionController@postUpdateCorrectiveAction')->name('update_correctiveaction-post');
            Route::post('delete_correctiveaction', 'ActionController@postDeleteCorrectiveAction')->name('delete_correctiveaction-post');



            Route::get('alarmdelay/{id}/{delay}/{minutes}', 'DeviceController@editAlarmDelay')->name('alarmdelay');
            Route::get('system', 'SystemController@landing')->name('system');
            Route::get('correctiveaction', 'ActionController@landing')->name('correctiveaction');
            Route::get('device', 'DeviceController@landing')->name('device');
            Route::get('user', 'UserController@landing')->name('user');




        });
    });

    Route::group(['middleware' => 'ISLsuperadmin'], function() {

        Route::get('companyselect/{company_id}', 'CompanyController@selectCompany')->name('companyselect');
        Route::get('company', 'CompanyController@landing')->name('company');
    });

//APIs
    Route::resource('companies', 'CompanyController');
    Route::resource('reports', 'ReportsController');
    Route::resource('devices', 'DeviceController');
    Route::resource('messages', 'MessageController');
    Route::resource('users', 'UserController');
    Route::resource('corrections', 'CorrectionController');
    Route::resource('userdevicemap', 'UserDeviceMapController');
    Route::get('devicefromuniqueid/{unique_id}', 'DeviceController@deviceByUniqueId')->name('devicefromuniqueid');
    Route::get('devicecounts', 'DeviceController@countDevices')->name('devicecounts');
    Route::get('devicestats', 'DeviceController@deviceStatus')->name('devicestats');

    Route::get('sensorExists/{sensor_id}', 'DeviceController@sensorIDExists')->name('sensorExists');
    Route::get('sensorRecentReadings/{sensor_id}/{datapoint}', 'DeviceController@sensorRecentReadings')->name('sensorRecentReadings');
    Route::get('fetchAssoc/{user_id}', 'UserDeviceMapController@fetchAssoc')->name('fetchAssoc');
    Route::get('deleteMap/{device_id}/{user_id}', 'UserDeviceMapController@deleteMap')->name('deleteMap');
    Route::get('fetchSystemAssoc/{user_id}', 'UserDeviceMapController@fetchSystemAssoc')->name('fetchSystemAssoc');
    Route::get('deleteSystemMap/{system_id}/{user_id}', 'UserDeviceMapController@deleteSystemMap')->name('deleteSystemMap');
    Route::get('emailcheck/{email_value}', 'UserController@checkEmail')->name('emailcheck');
    Route::get('fetchCorrections/{device_id}', 'CorrectionController@fetchCorrections')->name('fetchCorrections');


    Route::get('newreport/{from}/{to}/{reportType}/{device}', 'ReportsController@getNewReports')->name('newreport');
    Route::get('exportreport/{from}/{to}/{reportType}/{device}', 'ReportsController@exportReport')->name('exportreport');



    Route::post('acknowledge', 'CorrectionController@postAcknowledgement')->name('acknowledge-post');
    Route::post('companyname', 'CompanyController@editCompanyName')->name('companyname-post');
    Route::post('profile', 'UserController@postProfile')->name('profile-post');
    Route::post('password', 'UserController@postPassword')->name('password-post');


    Route::get('acknowledge/{device_id}/{reading}/{min_threshold}/{max_threshold}', 'CorrectionController@doAcknowledgement')->name('acknowledge');
    Route::get('profile', 'UserController@getProfile')->name('profile');



});

Route::group(['middleware' => 'auth'], function() {
    Route::get('unverified', 'HomeController@unverified')->name('unverified');
    Route::get('resendemail', 'HomeController@resendEmail')->name('resendemail');
    Route::get('noaccess', 'HomeController@noaccess')->name('noaccess');

    /*Route::post('system', 'SystemController@postCreateSystem')->name('system-post');
    Route::post('update_system', 'SystemController@postUpdateSystem')->name('update_system-post');
    Route::post('delete_system', 'SystemController@postDeleteSystem')->name('delete_system-post');*/



    Route::get('initial_system', 'SystemController@initial_landing')->name('initial_system');
    Route::get('initial_device', 'DeviceController@initial_landing')->name('initial_device');
    Route::get('initial_user', 'UserController@initial_landing')->name('initial_user');
    Route::get('initial_setup', 'HomeController@initial_setup')->name('initial_setup');
    Route::get('complete_setup', 'HomeController@complete_setup')->name('complete_setup');

});








Route::get('/', function () {

    $visits = Redis::incr('visits');
    return view('welcome')
            ->with('visits', $visits);
});


Route::get('logout', 'HomeController@logout')->name('logout');

Auth::routes(['verify' => true]);


