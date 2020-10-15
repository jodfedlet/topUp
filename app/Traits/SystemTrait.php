<?php


namespace App\Traits;
use App\Log;
use App\Operator;
use Illuminate\Support\Facades\Auth;

trait SystemTrait{

    public function getApiUrlAttribute(){
        return $this['api_mode']=='LIVE'?'https://topups.reloadly.com':'https://topups-sandbox.reloadly.com';
    }

    public function getToken(){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://auth.reloadly.com/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:application/json"]);

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode([
            'client_id' => $this['api_key'],
            'client_secret' => $this['api_secret'],
            'grant_type' => 'client_credentials',
            'audience' => $this['api_url']
        ]));

        $response = curl_exec($ch);
        curl_close($ch);
        $this->createLog('GET_TOKEN', $response);
        $response = json_decode($response);

        return isset($response->access_token)?$response->access_token:null;
    }

    public function getCountries(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['api_url']."/countries");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['api_token']
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $this->createLog('GET_COUNTRIES', $response);
        return json_decode($response);
    }

    public function getOperators($page=1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['api_url']."/operators?page=$page");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['api_token']
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $this->createLog('GET_OPERATORS', $response);
        return json_decode($response);
    }

    public function getBalance(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this['api_url']."/accounts/balance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['api_token']
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        if (isset($response->currencyCode))
        {
            $this['currency'] = $response->currencyCode;
            $this->save();
        }
        return isset($response->balance)&&isset($response->currencyCode)?$response->balance.' '.$response->currencyCode:'---';
    }

    public function autoDetectOperator($phone,$iso,$fileId){

        $ch = curl_init();

        $endPoint = "/operators/auto-detect/phone/$phone/country-code/$iso?&includeBundles=true";
       // $endPoint = "/operators/auto-detect/phone/$phone/country-code/$iso?&suggestedAmountsMap=true&includeBundles=true";
        curl_setopt($ch, CURLOPT_URL, $this['api_url'].$endPoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['api_token']
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $this->createLog('AUTO_DETECT', $response,'FILE:'.$fileId);
        $response = json_decode($response);
        return isset($response->operatorId) ? Operator::where('rid',$response->operatorId)->first(): null;
    }

    public function getPromotions($page=1){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this['api_url']."/promotions?page=$page");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$this['api_token']
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $this->createLog('GET_PROMOTIONS', $response);
        return json_decode($response);
    }

    public function getUserCountry()
    {
         $ch = curl_init();
         curl_setopt($ch,CURLOPT_URL, "http://api.hostip.info/country.php");
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         $cc = curl_exec($ch);
         curl_close($ch);

        if ($cc == 'XX'){
            return $this->getUserCountry();
        }
        return $cc;
    }

    public function createLog($task,$response, $params = '')
    {
        Log::create([
            'task' => $task,
            'params' => $params,
            'response' => $response
        ]);
    }
}
