<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 15:16
 */

include_once ROOT_PATH.'/src/core/res/values/GeneralCons.php';
class Controller
{
    public static $view;
    public static $userRole;
    public static $userLang;
    public static $get;
    public function __construct()
    {
        $this->userRole = $_SESSION['role'];
        $this->userLang = $_SESSION['lang'];
        $this->get = new GeneralCons($this->userLang);
        self::$view = new Viewer();
    }

}