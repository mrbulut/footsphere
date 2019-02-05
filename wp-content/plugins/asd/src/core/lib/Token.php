<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:03
 */

class Token
{
    public static function create()
    {
        return Session::create(Config::get('session/token'), md5(uniqid()));
    }

    public static function control($token)
    {
        $tokenName = Config::get('session/token');
        if (Session::isthere($tokenName) && $token == $tokenName) {
            Session::delete($tokenName);
            return true;
        }
        return false;
        // code...
    }

    public function FunctionName(Type $var = null)
    {
        # code...
    }
}