<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:02
 */

class Hash
{
    public static function create($string,$salt='')
    {
        return hash('sha256',$string.$salt);
    }

    public static function salt($long='')
    {
        return mcrypt_create_iv($long);
    }

    public static function unique()
    {
        return self::create(uniqid());
    }
}