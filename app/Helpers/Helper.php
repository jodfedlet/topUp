<?php


namespace App\Helpers;

use App\Topup;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function decryptedData($data)
    {
        return json_decode(base64_decode($data));
    }

    public static function rangePassword($size = 8, $upper = true, $lower = true, $number = true, $symb = true)
    {
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ";
        $mi = "abcdefghijklmnopqrstuvyxwz";
        $nu = "0123456789";
        $si = "!@#$%¨&*()_+=";

        $password = '';
        if ($upper){
            $password .= str_shuffle($ma);
        }

        if ($lower){
            $password .= str_shuffle($mi);
        }

        if ($number){
            $password .= str_shuffle($nu);
        }

        if ($symb){
            $password .= str_shuffle($si);
        }
        return substr(str_shuffle($password),0,$size);
    }

    public static function sendEmail($data)
    {
        $mailer = new Mailer();
        return $mailer->add(
            $data['subject'],
            $data['body'],
            $data['name'],
            $data['email']
        )->send();
    }

    public static function ipDetails()
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://ipinfo.io");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    /**
     * @param Topup $topup
     */
    public static function topupBenefit($topup)
    {
        if (json_decode(\App\User::find($topup->user_id))->level != 1){
            if ($topup->taxes > 0.00){
                if (Auth::id() == 1) $benefice = $topup->taxes * .65;
                else $benefice = $topup->taxes * .35;
            }
            else{
                if (Auth::id() == 1) $benefice = $topup->total * .15;
                else $benefice = $topup->total * .1;
            }
        }
        else{
            $benefice = ($topup->taxes > 0.00) ? $topup->sentAmount * .25: $topup->total * .25;
        }
        return $benefice;
    }
}
