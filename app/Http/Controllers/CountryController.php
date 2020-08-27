<?php


namespace App\Http\Controllers;


use App\Country;

class CountryController extends Controller
{
    public static function getAll(){
        return response()->json(Country::get());
    }
}
