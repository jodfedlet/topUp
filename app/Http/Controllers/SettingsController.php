<?php


namespace App\Http\Controllers;


use App\Country;
use App\System;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    public function index(Request $request)
    {
       /* if(Auth::guest()){
            $countries = Country::all();
            return view('welcome',compact('countries'));
        }*/
        return view('system');
    }

    public function save(Request $request)
    {
            $apiData = $request->all();
            $system = System::getData();
            if ($system == null) {
                $system = new System();
            }
            $system['api_key'] = $apiData['client_id'];
            $system['api_secret'] = $apiData['client_secret'];
            $system['api_mode'] = $apiData['api_mode'];

            $token = $system->getToken();

            if ($token === null) {
                return response()->json(['errors' => ['Error' => 'Api Auth Failed. Please Check Key/Secret and try again.']], 422);
            }
            $system->api_token = $token;

            try {
                $system->save();
                $response = response()->json(['message' => 'Settings Saved. Operator Sync Started!']);
                Artisan::call('schedule:run');
            } catch (QueryException $e) {
                $response = response()->json(['errors' => ['Error' => $e->getMessage()]], 422);;
            } finally {
                return $response;
            }

    }
}
