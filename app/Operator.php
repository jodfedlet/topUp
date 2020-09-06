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
}
