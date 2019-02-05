<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.02.2019
 * Time: 11:08
 */

abstract class EntitiyContainer
{
    private static $_instance;

    public static function getInstance(IEntity $IEntity)
    {
        if (isset(self::$_instance)) {
            return self::$_instance;
        } else {
            self::$_instance = new $IEntity;
            return self::$_instance;
        }
    }

}