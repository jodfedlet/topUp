<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Operator extends Model
{
    protected $guarded = [ ];
    protected $casts = [
        'logo_urls' => 'array',
        'fixed_amounts' => 'array',
        'suggested_amounts' => 'array',
        'suggested_amounts_map' => 'array',
        'local_fixed_amounts' => 'array'
    ];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public static function getColumn($column, $searchColum)
    {
        return DB::table('operators')->select('*')
            ->where($column, '=',$searchColum)
            ->get();
    }

    public static function getFxForAmount($data){
        $system = System::getData();
        $ch = curl_init();

        $amount = $data['amount'] - $data['amount']*0.25;
        if(isset($data['type']) && $data['type'] == 'fixed'){
            $amount = $data['amount'];
        }

        curl_setopt($ch, CURLOPT_URL, $system['api_url']."/operators/fx-rate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "Authorization: Bearer ".$system['api_token']
        ));

        $data = [
            'operatorId' => $data['id'],
            'currencyCode' => $system['currency'],
            'amount' => $amount
        ];

        $data['currencyCode'] = 'BRL';

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return isset($response->fxRate)?$response->fxRate:-1;
    }
}
