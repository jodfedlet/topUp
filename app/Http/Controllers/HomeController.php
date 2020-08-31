<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
       $countries = Country::all();
       return view('welcome',compact('countries'));
    }

    public function checkout()
    {
       return view('checkout');
    }
}
