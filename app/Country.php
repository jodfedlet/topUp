<?php

namespace App;

use App\Helpers\Helper;
use App\Traits\SystemTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    use SystemTrait;
    protected $guarded = ['id'];
    protected $casts = [ 'calling_codes' => 'array' ];
    protected $hidden = ['created_at', 'updated_at', 'calling_codes'];

    public static function getColumn($column,$dbColumn, $searchColum)
    {
        return DB::table('countries')->select($dbColumn)
            ->where($column, '=',$searchColum)
            ->get();
    }

    public function sameCountryAndCurrency(string $countryIso)
    {
        if($countryIso == Helper::ipDetails()->country){
            $ccCurrencyCode = json_decode(Country::getColumn('iso','currency_code',$countryIso));
            $systemCurrencyCode = System::getData()['currency'];
            if($systemCurrencyCode == $ccCurrencyCode[0]->currency_code) return true;
        }
        return false;
    }
}
