<?php

use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@index');


Route::get('/countries', 'CountryController@index');
Route::get('countries/{id}/operators/detect/{number}', 'OperatorController@detect');
Route::get('countries/{id}/operators', 'OperatorController@getByCountry');
Route::get('/operator/{id}', 'OperatorController@get');

Route::get('/login', 'UsersController@index');

    Route::post('/users','UsersController@logon');
    Route::post('/users/create','UsersController@create');
    Route::get('/logout','UsersController@logout');
    Route::get('/checkout', 'HomeController@checkout');
    Route::post('/checkout', 'PaymentController@stripePayment');
    Route::get('/settings','SettingsController@index');
    Route::post('/settings','SettingsController@save');




