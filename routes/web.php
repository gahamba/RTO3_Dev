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


    Route::get('home', 'HomeController@index')->name('home');
    Route::get('company', 'CompanyController@landing')->name('company');
    Route::get('report', 'ReportsController@landing')->name('report');
    Route::get('account', 'AccountController@landing')->name('account');
    Route::get('message', 'MessageController@landing')->name('message');

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
    Route::get('emailcheck/{email_value}', 'UserController@checkEmail')->name('emailcheck');
    Route::get('fetchCorrections/{device_id}', 'CorrectionController@fetchCorrections')->name('fetchCorrections');

    Route::get('newreport/{from}/{to}/{reportType}/{device}', 'ReportsController@getNewReports')->name('newreport');
    Route::get('exportreport/{from}/{to}/{reportType}/{device}/{interface}', 'ReportsController@exportReport')->name('exportreport');

    Route::group(['middleware' => 'superadmin'], function() {

        Route::post('system', 'SystemController@postCreateSystem')->name('system-post');
        Route::post('config', 'ConfigurationController@postCreateConfig')->name('config-post');
        Route::post('system_devices', 'SystemController@postUpdateSystemDevices')->name('system_devices-post');
        Route::post('update_system', 'SystemController@postUpdateSystem')->name('update_system-post');
        Route::post('delete_system', 'SystemController@postDeleteSystem')->name('delete_system-post');



        Route::get('system', 'SystemController@landing')->name('system');
        Route::get('device', 'DeviceController@landing')->name('device');
        Route::get('user', 'UserController@landing')->name('user');

    });




});

Route::group(['middleware' => 'auth'], function() {
    Route::get('unverified', 'HomeController@unverified')->name('unverified');
    Route::get('noaccess', 'HomeController@noaccess')->name('noaccess');

});





Route::get('/', function () {
    return view('welcome');
});


Route::get('logout', 'HomeController@logout')->name('logout');

Auth::routes(['verify' => true]);


