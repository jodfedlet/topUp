<?php

use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@index');

Route::get('/settings','SettingsController@index');
Route::post('/settings','SettingsController@save');
Route::get('/countries', 'CountryController@index');
Route::get('countries/{id}/operators/detect/{number}', 'OperatorController@detect');
Route::get('/checkout', 'HomeController@checkout');
Route::post('/checkout', 'PaymentController@stripePayment');

