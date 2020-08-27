<?php

use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@index');

Route::get('/settings','SettingsController@index');
Route::post('/settings','SettingsController@save');
