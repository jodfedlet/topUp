<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;

class UsersController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return view('login');
        }
        $countries = Country::all();
        return view('welcome',compact('countries'));

    }
    public function logon(Request $request)
    {
        $data = $request->all();
        if(Auth::attempt([
            'email'=>$data['email'],
            'password'=>$data['password']
        ])){
            $response = response()->json(['redirect'=>'/'], 200);
        }
        else{
            $response = response()->json(['error'=>'Incorrect user and/or password'], 500);
        }
        return $response;
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $user                 = new User();
        if(User::checkColumn('email', $data['email']) > 0){
            $response = response()->json(['error'=>'Il existe déjà un utilisateur avec ces informations, veuillez vous connecter!'], 500);
        }else{
            try{
                $user->name           = $data['name'];
                $user->email          = $data['email'];
                $user->password       = bcrypt($data['password']);
                $user->save();
                $response = response()->json(['redirect'=>'/'], 200);;
            }catch (QueryException $e){
                $response = response()->json(['error'=>$e->getMessage()], 500);
            }
        }
        return $response;
    }

    public function logout()
    {
        Auth()->logout();
        $countries = Country::all();
        return view('welcome',compact('countries'));
    }
}
