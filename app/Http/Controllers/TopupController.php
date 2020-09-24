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

        if (Auth::id() == 1){
            $topups = Topup::all();
        }
        return view('adm.transactions.read',compact('topups'));
    }

    public function admSendTopup(Request $request)
    {
        $data = $request->all();
        $User = User::find(Auth::id());
        $user = json_decode($User);

        $userBalance = $user->balance;
        if ($userBalance < $data['value_to_pay']){
            return response()->json([
                'message'=>'Votre solde est insuffisant! Veuillez entrer en contact avec l\'administrateur',
            ],500);
        }
        $porcentagemCli = $data['value_to_pay'] * 0.10;

        $res = json_decode($this->sendTopup($data));

        if(isset($res->errorCode)) {
            return response()->json([
                'message'=>$res->message,
            ],500);
        }
        else{
            $User->balance -= $data['value_to_pay'] - $porcentagemCli;
            $User->update();

            $data =[
              'transactionId'=>$res->transactionId,
              'sentAmount'=>$data['value_to_pay'],
              'recipientPhone'=>$res->recipientPhone,
              'operatorName'=>$res->operatorName,
              'deliveredAmount'=>$res->deliveredAmount,
            ];

            return response()->json([
                'message'=>'La recharge est effectuée avec succès!',
                'data'=>$data
            ],200);
        }
    }

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

        $user = json_decode(User::find(Auth::id()));

        $total = $data['value_to_pay'] - $data['value_to_pay'] * 0.25;

        if($data['fixed'] == '1'){
            $total = $data['sent_amount'];
        }

        $request = [
            'recipientPhone' => [
                'countryCode' => $data['country_code'],
                'number' => $data['phone_number']
            ],
            'operatorId' => $data['operator_id'],
            'amount' => $total
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
        Topup::create( [
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
        ]);
       return $response;
    }

}
