<?php


namespace App\Http\Controllers;


use App\Country;

class CountryController extends Controller
{
    public function index(){
        return [
            'countries' => Country::all()
        ];
    }
    public static function getAll(){
        return response()->json(Country::get());
    }

    public static function getACountry($id)
    {
       return Country::find($id);
    }
}
