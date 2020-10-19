<?php

namespace App\Http\Controllers;

use App\Country;
use App\System;
use App\Topup;
use App\Traits\SystemTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    use SystemTrait;

    public function index()
    {
        $countries = Country::all();
        return view('adm.topup.create', compact('countries'));
    }

    public function transaction()
    {
        $topups = DB::table('topups')
            ->where('user_id', Auth::id())
            ->where('status', 'SUCCESS')
            ->orderByDesc('id')
            ->get();

        $user = json_decode(User::find(Auth::id()));

        if ($user->level == 1){
            $topups = DB::table('topups')
                ->where('status', 'SUCCESS')
                ->orderByDesc('id')
                ->get();
        }
        return view('adm.transactions.read',compact('topups'));
    }

    public function admSendTopup(Request $request)
    {
        $data = $request->all();
        $User = User::find(Auth::id());
        $user = json_decode($User);

        $userBalance = $user->balance;

        if ($userBalance < $data['value_to_pay'] && $user->id != 1){
            return response()->json([
                'message'=>'Votre solde est insuffisant! Veuillez entrer en contact avec l\'administrateur',
            ],500);
        }

        $taxes = ($data['fixed'] == '1') ? $data['sent_amount'] * 0.25 : 0;

        $res = json_decode($this->sendTopup($data, $taxes));

        if(isset($res->errorCode)) {
            return response()->json([
                'message'=>$res->message,
            ],500);
        }
        else{
            if ($user->level == 3){
                $User->balance -= $data['value_to_pay'] - (($data['fixed'] == '1') ? $data['value_to_pay'] * 0.075: $data['value_to_pay'] * 0.1);
                $User->update();
            }

            $data =[
              'transactionId'=>$res->transactionId,
              'sentAmount'=>$data['value_to_pay'],
              'recipientPhone'=>$res->recipientPhone,
              'operatorName'=>$res->operatorName,
              'deliveredAmount'=>$res->deliveredAmount,
              'taxes'=>$taxes
            ];

            return response()->json([
                'message'=>'La recharge est effectuée avec succès!',
                'data'=>$data
            ],200);
        }
    }

    public function sendTopup(array $data, float $taxes = 0){

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

        $user = json_decode(User::find(Auth::id()));

        $total = $data['value_to_pay'] - $data['value_to_pay'] * 0.25;

        if($data['fixed'] == '1'){
            $total = (float)$data['sent_amount'];
        }

        if (($data['operator_id'] == 173) && ($data['value_to_pay'] <= 25)){
            $total = 6.4;
        }

        $request = [
            'recipientPhone' => [
                'countryCode' => $data['country_code'],
                'number' => $data['phone_number']
            ],
            'operatorId' => $data['operator_id'],
            'amount' =>$total
        ];

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($request));

        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);

        if(!empty($res->errorCode)){
            $status = 'FAIL';
            $receivedAmount = 0;
            $senderCurrency = '';
            $destinationCurrency = '';
        }
        else{
            $status = 'SUCCESS';
            $receivedAmount = $res->deliveredAmount;
            $senderCurrency = $res->requestedAmountCurrencyCode;
            $destinationCurrency = $res->deliveredAmountCurrencyCode;
        }
        $topups = [
            'user_id'=>$user->id,
            'status'=>$status,
            'phoneNumber'=>$data['phone_number'],
            'total'=>$data['value_to_pay'],
            'sentAmount'=>$total,
            'receivedAmount'=>$receivedAmount,
            'countryCode'=>$data['country_code'],
            'operatorId'=>$data['operator_id'],
            'senderCurrency'=>$senderCurrency,
            'destinationCurrency'=>$destinationCurrency,
            'taxes'=>number_format($taxes,2)
        ];

        Topup::create($topups);
       return $response;
    }

}
