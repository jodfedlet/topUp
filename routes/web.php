<?php

use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@index')->name('welcome');


Route::get('/countries', 'CountryController@index');
Route::get('countries/{id}/operators/detect/{number}', 'OperatorController@detect');
Route::get('countries/{id}/operators', 'OperatorController@getByCountry');
Route::get('/operator/{id}', 'OperatorController@get');
Route::post('/operator/fxRate', 'OperatorController@getFxRate');

Route::get('/login', 'UsersController@index')->name('login');
Route::post('/resetEmail', 'UsersController@resetEmail');
Route::get('/reset/{forgot}','UsersController@resetEmailView');
Route::post('/reset/confirm','UsersController@confirmReset');

Route::post('/login','UsersController@logon');
Route::post('/users/create','UsersController@create');
Route::get('/topup-data', 'HomeController@topupData');

Route::group(['middleware'=> ['auth']], function (){
    Route::get('/adm','AdmController@index')->name('admin');
    Route::get('/adm/topup','TopupController@index');
    Route::post('/adm/topup','TopupController@admSendTopup');

    Route::post('/checkout', 'PaymentController@stripePayment');
    Route::get('/logout','UsersController@logout');
    Route::get('/adm/transaction','TopupController@transaction');
    Route::get('/checkout', 'HomeController@checkout');

    //system permissions
    Route::group(['middleware'=> ['system']], function (){
        Route::get('/adm/settings','SettingsController@index');
        Route::post('/adm/settings','SettingsController@save');
        Route::get('/adm/reseller','UsersController@showReseller');
        Route::post('/get-reseller-data','UsersController@getResellerData');
        Route::post('/reseller-balance','UsersController@resellerBalance');
    });
});







