<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:23
 */
include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";

class Request implements IEntity
{

    public $ID;
    public $UserID;
    public $ProducerNo;
    public $RequestNo;
    public $ProductsAndPrices;
    public $Status;
    public $Type;


    public function __construct(){

    }
    function ResetObject() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->UserID;
    }

    /**
     * @param mixed $UserID
     */
    public function setUserID($UserID)
    {
        $this->UserID = $UserID;
    }

    /**
     * @return mixed
     */
    public function getProducerNo()
    {
        return $this->ProducerNo;
    }

    /**
     * @param mixed $ProducerNo
     */
    public function setProducerNo($ProducerNo)
    {
        $this->ProducerNo = $ProducerNo;
    }

    /**
     * @return mixed
     */
    public function getRequestNo()
    {
        return $this->RequestNo;
    }

    /**
     * @param mixed $RequestNo
     */
    public function setRequestNo($RequestNo)
    {
        $this->RequestNo = $RequestNo;
    }

    /**
     * @return mixed
     */
    public function getProductsAndPrices()
    {
        return $this->ProductsAndPrices;
    }

    /**
     * @param mixed $ProductsAndPrices
     */
    public function setProductsAndPrices($ProductsAndPrices)
    {
        $this->ProductsAndPrices = $ProductsAndPrices;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param mixed $Status
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type)
    {
        $this->Type = $Type;
    }

    /**
     * Request constructor.
     * @param $ID
     * @param $UserID
     * @param $ProducerNo
     * @param $RequestNo
     * @param $ProductsAndPrices
     * @param $Status
     * @param $Type
     */


}