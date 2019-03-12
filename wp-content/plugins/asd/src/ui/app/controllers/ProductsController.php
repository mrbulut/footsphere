<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 11:59
 */


include_once ROOT_PATH.'/src/ui/app/models/ProductModel.php';

class productsController extends Controller
{

    private static $sendData=array();

    private $productModel ;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        parent::__construct();
    }

    public function home($data = false)
    {
        if($data){
            Controller::$view->view("product", $this->sendData);
        }else{
            Controller::$view->view("productlist", $this->sendData);
        }
    }

    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


    public function createProduct($array){
        $this->productModel->createProduct($array);
    }


}