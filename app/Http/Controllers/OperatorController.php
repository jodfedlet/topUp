<?php

namespace App\Http\Controllers;

use App\Country;
use App\Operator;
use App\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function get($id){
        $operator = Operator::find($id);
        $operator->userId = Auth::guest() ? 0 : Auth::id();
        return response()->json($operator);
    }

    public function getByCountry($id)
    {
        return response()->json(Operator::getColumn('country_id',$id));
    }

    public function detect($iso,$number){
        return System::getData()->autoDetectOperator($number,$iso,-1);
    }

    public function getFxRate(Request $request)
    {
        $data = $request->all();
        return Operator::getFxForAmount($data);
    }
}
