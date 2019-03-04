<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 15:18
 */


class pageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function home($data = false)
    {

      Controller::$view->view("page",$data);

    }

    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}