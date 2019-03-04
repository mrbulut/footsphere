<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 15:16
 */


class Controller
{
    public static $view;
    public function __construct()
    {
        self::$view = new Viewer();
    }

}