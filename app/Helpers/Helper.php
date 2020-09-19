<?php


namespace App\Helpers;


class Helper
{
    public static function decryptedData($data)
    {
        return json_decode(base64_decode($data));
    }
}
