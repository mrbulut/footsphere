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

    /*
    flashMessage() Kullanimi
    #tek seferlik, #silinmeli mesaj, #yönlendirme
    örneğin;
    üyelik tamamlandı ise
    header('location index.php');
    Session::flash('valu','Başarı ile üye oldunuz.');

    if(Session::isthere('valu'))
    echo Session::flashMessage('valu');

    */
    public static function flashMessage($name,$string = null){
        if (self::isthere($name)){
            $session = self::get($name);
            self::delete($name);
            return $session;
        }else{
            self::create($name);
        }
    }
}