<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 22.02.2019
 * Time: 14:26
 */


include_once 'IModel.php';
include_once ROOT_PATH . '/src/entities/concrete/ProductConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/CustomerConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/UserConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/ProducerConcrete.php';
include_once ROOT_PATH . '/src/bussines/concrete/UserManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/CustomerManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/ProducerManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/ProductManager.php';

class ProductModel implements IModel
{
    private $UserManager;
    private $CustomerManager;
    private $ProducerManager;
    private $ProductManager;

    private $User, $Customer, $CustomerWhere, $Producer,
        $ProducerWhere,$Product,
        $ProductWhere;
    private $UserId;
    public function __construct($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        else {
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $this->UserId = $current_user->ID;
            }
        }

        $this->Customer = new Customer();
        $this->CustomerWhere = new Customer();
        $this->User = new User();
        $this->Producer = new Producer();
        $this->ProducerWhere = new Producer();
        $this->Product = new Product();
        $this->ProductWhere = new Product();
    }

    public function createProduct($array=array()){
        self::productSetup();
        $this->Product->ResetObject();
        foreach ($array as $key => $value){
            if($value){
                if($key == 'PName'){
                    $this->Product->setPName($array['PName']);
                }else if($key =='DescProduct'){
                    $this->Product->setDescProduct($array['DescProduct']);
                }else if($key =='Price'){
                    $this->Product->setPrice($array['Price']);
                }else if($key =='Image'){
                    $this->Product->setImage($array['Image']);
                }else if($key =='Image2'){
                    $this->Product->setImage2($array['Image2']);
                }else if($key =='Image3'){
                    $this->Product->setImage3($array['Image3']);
                }else if($key =='ProducerNO'){
                    $this->Product->setProducerNO($array['ProducerNO']);
                }else if($key =='BSNO'){
                    $this->Product->setBSNO($array['BSNO']);
                }else if($key =='Features'){
                    $this->Product->setFeatures($array['Features']);
                }else if($key =='Type'){
                    $this->Product->setType($array['Type']);
                }else if($key =='Status'){
                    $this->Product->setStatus($array['Status']);
                }else if($key =='BaseMaterial'){
                    $this->Product->setBaseMaterial($array['BaseMaterial']);
                }else if($key =='ClosureType'){
                    $this->Product->setClosureType($array['ClosureType']);
                }else if($key =='TopMeterial'){
                    $this->Product->setTopMeterial($array['TopMeterial']);
                }else if($key =='liningMeterial'){
                    $this->Product->setLiningMeterial($array['liningMeterial']);
                }else if($key =='Season'){
                    $this->Product->setSeason($array['Season']);
                }else if($key =='InsideBaseType'){
                    $this->Product->setInsideBaseType($array['InsideBaseType']);
                }else if($key =='InsideBaseMeterial'){
                    $this->Product->setInsideBaseMeterial($array['InsideBaseMeterial']);
                }else if($key =='ProductWp_PostsId'){
                    $this->Product->setProductWpPostsId($array['ProductWp_PostsId']);
                }
            }


        }

        return $this->ProductManager->createProduct($this->Product);
    }

    public function updateProduct($array=array(),$ID=null){

        self::productSetup();
        $this->Product->ResetObject();
        foreach ($array as $key => $value){
            if($key == 'PName'){
                $this->Product->setPName($array['PName']);
            }else if($key =='DescProduct'){
                $this->Product->setDescProduct($array['DescProduct']);
            }else if($key =='Price'){
                $this->Product->setPrice($array['Price']);
            }else if($key =='Image'){
                $this->Product->setImage($array['Image']);
            }else if($key =='Image2'){
                $this->Product->setImage2($array['Image2']);
            }else if($key =='Image3'){
                $this->Product->setImage3($array['Image3']);
            }else if($key =='ProducerNO'){
                $this->Product->setProducerNO($array['ProducerNO']);
            }else if($key =='BSNO'){
                $this->Product->setBSNO($array['BSNO']);
            }else if($key =='Features'){
                $this->Product->setFeatures($array['Features']);
            }else if($key =='Type'){
                $this->Product->setType($array['Type']);
            }else if($key =='Status'){
                $this->Product->setStatus($array['Status']);
            }else if($key =='BaseMaterial'){
                $this->Product->setBaseMaterial($array['BaseMaterial']);
            }else if($key =='ClosureType'){
                $this->Product->setClosureType($array['ClosureType']);
            }else if($key =='TopMeterial'){
                $this->Product->setTopMeterial($array['TopMeterial']);
            }else if($key =='liningMeterial'){
                $this->Product->setLiningMeterial($array['liningMeterial']);
            }else if($key =='Season'){
                $this->Product->setSeason($array['Season']);
            }else if($key =='InsideBaseType'){
                $this->Product->setInsideBaseType($array['InsideBaseType']);
            }else if($key =='InsideBaseMeterial'){
                $this->Product->setInsideBaseMeterial($array['InsideBaseMeterial']);
            }else if($key =='ProductWp_PostsId'){
                $this->Product->setProductWpPostsId($array['ProductWp_PostsId']);
            }

        }

        return $this->ProductManager->upgradeProduct($this->Product,$ID);
    }

    public function getAllProduct($array=array()){
        self::productSetup();

        if($array['ProducerNo']){
            return $this->ProductManager->getAllProductByProducerNo($array['ProducerNo']);
        }else if($array['Type']) {
            return $this->ProductManager->getAllProduct($array['Type']);
        }else if($array['IdArray']){
            return $this->ProductManager->getProductByIdArray($array['IdArray']);
        }else if($array==null){
            return $this->ProductManager->getAllProduct();
        }
    }

    public function getIdOfRealProduct($Id){

        self::productSetup();

        return $this->ProductManager->getIdOfRealProductById($Id);
    }

    public function getProduct($ID){
        self::productSetup();
        return $this->ProductManager->getProductById($ID);
    }

    public function setProductStatus($ID,$Status){
        self::productSetup();
        return $this->ProductManager->setProductStatus($ID,$Status);
    }
    public function getProductStatus($ID){
        self::productSetup();
        return $this->ProductManager->getProductStatus($ID);
    }

    public function removeProduct($ID){
        self::productSetup();
        return $this->ProductManager->removeProduct($ID);
    }

    public function addProductForUser($ProductId){
        self::customerSetup();
        self::productSetup();
        $id =  $this->ProductManager->addProductForUser($ProductId,$this->UserId);
        if($id){
            return $this->CustomerManager->updateProduct(array($ProductId));
        }
    }

    public function getPriceById($PostId){
        return $this->ProductManager->getPrice($PostId);
    }
    public function removeProductForUser($ProductId){
        self::customerSetup();
        self::productSetup();
        $return = $this->ProductManager->removeProductPermissionForUser($this->UserId,$ProductId);
        if ($return){
            return $this->CustomerManager->deleteProduct(array($ProductId));
        }
    }

    public function getAllListForTheUser(){
        self::customerSetup();
        return explode(",",$this->CustomerManager->getProducts($this->UserId));
    }

    private function customerSetup()
    {
        $this->CustomerManager = new CustomerManager($this->UserId);
        $this->UserManager = new UserManager();
    }

    private function producerSetup()
    {
        $this->ProducerManager = new ProducerManager($this->UserId);
        $this->UserManager = new UserManager();

    }

    private function userSetup()
    {
        $this->UserManager = new UserManager();

    }

    private function productSetup(){
        $this->ProductManager = new ProductManager($this->UserId);
        $this->UserManager = new UserManager();
    }
}