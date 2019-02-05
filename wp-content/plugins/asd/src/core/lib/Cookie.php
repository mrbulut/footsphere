<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:01
 */

class Cookie
{
    function __construct()
    {
        session_start();
    }
    public static function isthere($name)
    {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    public static function create($name,$valu,$time)
    {
        if(setcookie($name,$valu,time() + $time,'/')){
            return true;
        }else{
            return false;
        }
    }

    public static function delete($name)
    {
        self::create($name,'',time()-1);
    }
}