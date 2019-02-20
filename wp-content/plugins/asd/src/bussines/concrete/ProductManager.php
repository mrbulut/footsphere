<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 13.02.2019
 * Time: 16:41
 */

include_once ROOT_PATH . "/src/bussines/concrete/CustomerManager.php";
include_once ROOT_PATH . "/src/data/concrete/ProductDal.php";
include_once ROOT_PATH . "/src/data/concrete/OptionsDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/bussines/abstract/IProductService.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";


class ProductManager implements IProductService
{
    private $Logger;
    private $ProductDal;
    private $UserDal;
    private $CustomerManager;
    private $UserId;
    private $Product;
    private $ProductWhere;


    public function __construct()
    {

        $this->Product = new Product();
        $this->ProductWhere = new Product();
        $this->CustomerManager = new CustomerManager();
        $this->ProductDal = new ProductDal();
        $this->UserDal = new UserDal();
        $this->Logger = new Logger(new FileLogger());

        $this->UserId = $this->UserDal->getUser()->getID();
        //$this->ProductObjectData = self::getCustomerList($this->Customer);
    }

    function getAllProduct($Type = null)
    {
        // TODO: Implement getAllProduct() method.
        $this->ProductWhere->ResetObject();
        if ($Type) {
            $this->ProductWhere->setType($Type);
            return self::getProductList($this->ProductWhere);
        } else {
            return $this->ProductDal->select();
        }

    }

    function getAllProductByProducerNo($ProducerNo = null)
    {
        if ($ProducerNo) {
            $this->ProductWhere->ResetObject();
            $this->ProductWhere->setProducerNO($ProducerNo);
            return self::getProductList($this->ProductWhere);
        }
    }

    function getProductByIdArray($IdArray = array())
    {
        if ($IdArray) {
            $i = 0;
            $resultArray = array();
            foreach ($IdArray as $key => $value) {
                $this->ProductWhere->ResetObject();
                $this->ProductWhere->setID($value);
                $resultArray[$i] = self::getProductList($this->ProductWhere)[0];
                $i++;
            }

            return $resultArray;
        }
    }

    function getProductById($ID)
    {
        if ($ID) {

            $this->ProductWhere->ResetObject();
            $this->ProductWhere->setID($ID);
           return  self::getProductList($this->ProductWhere)[0];
        }
    }

    function getProductByObject(Product $product)
    {
        return self::getProductList($product);
    }

    public function setProductStatus($ID, $Status)
    {
        $this->Product->ResetObject();
        $this->Product->setStatus($Status);
        $this->ProductWhere->ResetObject();
        $this->ProductWhere->setID($ID);
        return self::updateProduct($this->Product, $this->ProductWhere);
    }

    function getProductStatus($ID)
    {
        $this->ProductWhere->ResetObject();
        $this->ProductWhere->setID($ID);
        return self::getProductList($this->ProductWhere)[0]['Status'];
    }

    function removeProduct($ID)
    {
        $this->ProductWhere->ResetObject();
        $this->ProductWhere->setID($ID);
        if (self::deleteProduct($this->ProductWhere)) {
            try {
                $this->ProductDal->deleteProductReal($ID);
            } catch (Exception $e) {
            }
        }
    }

    function upgradeProduct(Product $product, $ID)
    {
        $this->ProductWhere->ResetObject();
        $this->ProductWhere->setID($ID);
        if (self::updateProduct($product, $this->ProductWhere)) {
            try {
                $this->ProductDal->updateProductReal($product);

            } catch (Exception $e) {
            }

        }

    }

    function addProductForUser($ProductId, $UserId)
    {
        $array = self::getProductById($ProductId);
        $this->Product->ResetObject();
        $this->Product->setPName($array['PName']);
        $this->Product->setDescProduct($array['DescProduct']);
        $this->Product->setImage($array['Image']);
        $this->Product->setPrice($array['Price']);
        $this->Product->setProducerNO($array['ProducerNO']);
        $this->Product->setID($array['ID']);

        try {
            return $id = $this->ProductDal->addProductReal($this->Product, $UserId);
        } catch (Exception $exp) {
            return false;
        }


    }

    function getAllListForTheUser($UserId)
    {
        $result = array();
        $data = $this->CustomerManager->getProducts($UserId);
        $data = explode(",",$data);
        foreach ($data as $key => $value){

            $result[$key]=self::getProductById($value);
        }

        return $result;
    }

    function createProduct(Product $Product)
    {
        return $this->addProduct($Product);
    }

    function removeProductPermissionForUser($ProductId, $UserId)
    {
        return $this->ProductDal->removeProductForUser($ProductId, $UserId);
    }

    private function addProduct(Product $product)
    {
        $this->ProductDal->settingQuery($product);
        try {
            if ($product) {
                $result = $this->ProductDal->insertToObject();
                if ($result) {
                    $this->Logger->Log("Ürün Oluşturuldu.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Ürün Oluşturulamadı.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }

        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı." . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }

    }

    private function getProductList(Product $product)
    {

        $this->ProductDal->settingQuery(null, $product,"Product");
        try {

            if ($product) {

                $result = $this->ProductDal->getToObject();
                if ($result) {
                    $this->Logger->Log("Ürün verileri getirildi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Ürün verileri getiremedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function deleteProduct(Product $product)
    {
        $this->ProductDal->settingQuery(null, $product);
        try {
            if ($product) {
                $result = $this->ProductDal->deleteToObject();
                if ($result) {
                    $this->Logger->Log("Ürün Silindi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Ürün Silinemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function updateProduct(Product $product, Product $productWhere)
    {
        $this->ProductDal->settingQuery($product, $productWhere);
        try {
            if ($product) {
                $result = $this->ProductDal->updateToObject();
                if ($result) {
                    $this->Logger->Log("Ürün Güncellendi..".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Ürün Güncellenemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }


}