<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/settings','SettingsController@index');
Route::post('/settings','SettingsController@save');
