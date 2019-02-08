<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:03
 */

class Session
{
    public static function create($name,$valu){
        return $_SESSION[$name] = $valu ;
    }
    public static function isthere($name)
    {
        return isset($_SESSION[$name]) ? true : false;
    }
    public static function get($name){
        return $_SESSION[$name];
    }
    public static function delete($name){
        if(self::isthere($name)){
            unset($_SESSION[$name]);
        }
    }

}