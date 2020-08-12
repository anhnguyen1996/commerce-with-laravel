<?php
namespace App\Http\Controllers\Admin\Modules\Cookie;

use Illuminate\Support\Facades\Cookie;

class JsonCookie
{
    public static function createJsonCookie($jsonCookieName, $cookieKey, $cookieValue, $time = 36000)
    {
        if (isset($_COOKIE[$jsonCookieName])) {

            $json = json_decode($_COOKIE[$jsonCookieName]);        
            $json->$cookieKey = $cookieValue;               
            Cookie::queue($jsonCookieName, json_encode($json), $time);       
        } else {

            $json = [$cookieKey => $cookieValue];
            Cookie::queue($jsonCookieName, json_encode($json), $time);
        }
    }

    public static function getValueInJsonCookie($jsonCookieName, $cookieKey)
    {
        if (isset($_COOKIE[$jsonCookieName])) {
            $jsonCookie = json_decode($_COOKIE[$jsonCookieName]);
            if (isset($jsonCookie->$cookieKey)) {
                return $jsonCookie->$cookieKey;
            }            
        }
        return null;
    }
}