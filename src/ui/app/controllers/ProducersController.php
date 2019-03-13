<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 05.03.2019
 * Time: 11:10
 */


class producersController extends Controller
{



    public function __construct()
    {
        parent::__construct();
    }

    public function home($data = false)
    {
        Controller::$view->view($this->userRole."/producers",$data);
    }

    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}