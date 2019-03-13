<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 06.03.2019
 * Time: 16:49
 */


include_once 'generalpage.php';
class userpage extends generalpage
{
    private static $producerId;
    private static $roleArray = array("editor","con");
    private static $teklifVerilebilir=false;

    public function __construct($userId=null,$producer=null)
    {

    }

}