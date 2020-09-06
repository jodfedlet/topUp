<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TopupController;
use Illuminate\Http\Request;

use App\Helpers\Stripe;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * @var TopupController
     */
    private $TopupController;

    public function __construct()
    {
        $this->TopupController = new TopupController();
    }

    public function stripePayment(Request $request)
    {
        $data = $request->all();
        $audience = false;
        if($audience){
            $apiKey = 'sk_live_VmYMAamaVWay4CCLDOfVD35M00JLZgf6zU';
        }else{
            $apiKey = 'sk_test_RoYbEZHsBi6Ds5lLGacsTJL600COwcR1og';
        }

        $stripe = new Stripe($apiKey);
        $customer = (array)$stripe->api('customers',[
            'source'=>$data['stripeToken'],
            'name'=>$data['username'],
            'email'=>Auth::user()->email,
        ]);

        $brand = $customer['sources']->data[0]->brand;

        $paymentIntents = $stripe->api('payment_intents',[
            'amount'=>trim(str_replace('.','',str_replace(',','',$data['value_to_pay'] * 100))),
            'currency'=>$data['sender_currency'],
            'customer'=>$customer['id'],
        ]);

        try {
            if(isset($paymentIntents->id) && isset($brand)){
                $response = $this->TopupController->sendTopup($data);
                $errorResponse = json_decode($response);
                if(isset($errorResponse->errorCode)){
                    $stripe->api('payment_intents/'.$paymentIntents->id.'/cancel',[]);
                    throw new \Exception($errorResponse->message);
                }
                $stripe->api('payment_intents/'.$paymentIntents->id.'/confirm',[
                        'payment_method' => strtolower('pm_card_'.$brand)
                    ]
                );
                print_r($response);
            }
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }
}
