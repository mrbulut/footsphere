<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 11:59
 */



class dashboardController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function home($data = false)
    {
        Controller::$view->view("dashboard/product",$data);
    }

    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}