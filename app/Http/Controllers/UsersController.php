<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function logon(Request $request)
    {
        $data = $request->all();
        if(Auth::attempt([
            'email'=>$data['email'],
            'password'=>$data['password']
        ])){
            die('logon');
        }
        else{
            return response()->json(['error'=> 'Les données sont incorrectes!'],400);
        }
    }
}
