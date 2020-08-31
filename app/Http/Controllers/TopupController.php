<?php

namespace App\Http\Controllers;

use App\System;
use App\Traits\SystemTrait;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    use SystemTrait;
    public function sendTopup(array $data){

        $system = System::getData();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $system['api_url']."/topups");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$system['api_token']
        ));

        $request = [
            'recipientPhone' => [
                'countryCode' => $data['country_code'],
                'number' => $data['phone_number']
            ],
            'operatorId' => $data['operator_id'],
            'amount' => $data['amountSend']
        ];
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($request));

        $response = curl_exec($ch);
        curl_close($ch);
        //$this->createLog('SEND_TOPUP', 'TOPUP_ID:'.$this['id'].' PHONE:'.$this['number'].' TOPUP:'.$this['topup'], $response);

       return $response;
    }

}
