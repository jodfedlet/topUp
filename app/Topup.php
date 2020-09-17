<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'phoneNumber',
        'total',
        'sentAmount',
        'receivedAmount',
        'countryCode',
        'operatorId',
        'senderCurrency',
        'destinationCurrency',
    ];

}
