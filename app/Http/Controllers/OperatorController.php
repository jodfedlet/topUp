<?php

namespace App\Http\Controllers;

use App\Country;
use App\Operator;
use App\System;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function get($id){
        return response()->json(Operator::find($id));
    }

    public function getByCountry($id)
    {
        return response()->json(Operator::getColumn('country_id',$id));
    }

    public function detect($iso,$number){
        return System::getData()->autoDetectOperator($number,$iso,-1);
    }
}
