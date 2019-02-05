<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 12:09
 */
include_once ROOT_PATH . "/src/entities/concrete/ProductConcrete.php";
include_once ROOT_PATH."/src/entities/abstract/Container.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/abstract/IDatabaseTableDao.php";

class ProductDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private static $Rows;

    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Product()));
    }

    public function getProductToId($Id)
    {
        if ($Id) {
            return $this->select(
                array(
                    self::$Rows[0] => $Id
                )
            );
        } else
            return false;
    }

    public function getProductToProducerNo($ProducerNo, $type = null)
    {

        if ($type) {
            return $this->selectAll(
                array(
                    self::$Rows[6] => $ProducerNo,
                    self::$Rows[9] => $type
                )
            );
        } else {
            return $this->selectAll(
                array(
                    self::$Rows[6] => $ProducerNo,
                )
            );
        }

    }

    public function addProduct(Product $product)
    {
        if ($product) {
            $result = array();
            foreach ($product as $key => $value) {
                $result[$key] = $value;
            }
            return $this->insert(
                $result
            );
        } else
            return false;
    }

    public function updateProduct(Product $product)
    {
        if ($product) {
            $result = array();
            foreach ($product as $key => $value) {
                if ($value)
                    $result[$key] = $value;
            }
            return $this->update(
                $result,
                array(
                    $product->getID()
                )
            );
        } else
            return false;
    }

    public function deleteProduct($Id)
    {
        if ($Id) {
            return $this->delete(
                array(
                    self::$Rows[0] => $Id
                )
            );
        } else
            return false;
    }


}