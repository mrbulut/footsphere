<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:17
 */
include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";

class Producer extends User implements IEntity
{
    // WP PRODUCER //
    public $ID;
    public $UserId;
    public $CompanyName;
    public $PhoneNumber;
    public $PhoneNumber2;
    public $Address;
    public $PaymentInformantion;
    public $CargoInformantion;
    public $OfferLimit;

    /**
     * Producer constructor.
     * @param $CompanyName
     * @param $PhoneNumber
     * @param $PhoneNumber2
     * @param $Address
     * @param $PaymentInformantion
     * @param $CargoInformantion
     * @param $OfferLimit
     */
    public function __construct(){

    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->CompanyName;
    }

    /**
     * @param mixed $CompanyName
     */
    public function setCompanyName($CompanyName)
    {
        $this->CompanyName = $CompanyName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * @param mixed $PhoneNumber
     */
    public function setPhoneNumber($PhoneNumber)
    {
        $this->PhoneNumber = $PhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber2()
    {
        return $this->PhoneNumber2;
    }

    /**
     * @param mixed $PhoneNumber2
     */
    public function setPhoneNumber2($PhoneNumber2)
    {
        $this->PhoneNumber2 = $PhoneNumber2;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param mixed $Address
     */
    public function setAddress($Address)
    {
        $this->Address = $Address;
    }

    /**
     * @return mixed
     */
    public function getPaymentInformantion()
    {
        return $this->PaymentInformantion;
    }

    /**
     * @param mixed $PaymentInformantion
     */
    public function setPaymentInformantion($PaymentInformantion)
    {
        $this->PaymentInformantion = $PaymentInformantion;
    }

    /**
     * @return mixed
     */
    public function getCargoInformantion()
    {
        return $this->CargoInformantion;
    }

    /**
     * @param mixed $CargoInformantion
     */
    public function setCargoInformantion($CargoInformantion)
    {
        $this->CargoInformantion = $CargoInformantion;
    }

    /**
     * @return mixed
     */
    public function getOfferLimit()
    {
        return $this->OfferLimit;
    }

    /**
     * @param mixed $OfferLimit
     */
    public function setOfferLimit($OfferLimit)
    {
        $this->OfferLimit = $OfferLimit;
    }

}