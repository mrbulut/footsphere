<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 05.03.2019
 * Time: 11:09
 */


class helpController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function home($data = false)
    {
        Controller::$view->view($this->userRole."/help",$data);
    }

    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}