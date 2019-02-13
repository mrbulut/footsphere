<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 13.02.2019
 * Time: 11:48
 */



include_once ROOT_PATH . "/src/bussines/abstract/IOptionsService.php";
include_once ROOT_PATH . "/src/data/concrete/OptionsDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/OptionsConcrete.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";

class OptionsManager implements IOptionsService
{
    private $Logger;
    private $OptionsDal;
    private $UserDal;
    private $UserId;


    public function __construct($UserID = null)
    {
        $this->OptionsDal = new OptionsDal();
        $this->UserDal = new UserDal($UserID);
        $this->Logger = new Logger(new FileLogger());
        $this->UserId = $this->UserDal->getUser()->getID();
        self::denineDefaultSettings();

    }


    function addOption($option_name, $option_value)
    {
        $this->OptionsDal->addOption($option_name,$option_value);
    }

    function updateOptionById($option_id, $option_value)
    {
        $this->OptionsDal->updateOptionToID($option_id,$option_value);
    }

    function updateOptionByName($option_name, $option_value)
    {
        $this->OptionsDal->updateOptionToOptionName($option_name,$option_value);
    }

    function denineDefaultSettings()
    {
        $this->OptionsDal->defineSettings();
    }

    function getLangueages($UserId=null)
    {
        if($UserId)
            $this->UserId = $UserId;
        $this->OptionsDal->getLangueages($this->UserId);
    }

    function setLangueages($UserId, $langueages)
    {
        if($UserId)
            $this->UserId = $UserId;
        $this->OptionsDal->setLangueages($this->UserId,$langueages);
    }

    function getRequest($userID=null)
    {
        if($userID)
            $this->UserId = $userID;
        $this->OptionsDal->getRequest($this->UserId);
    }

    function setRequest($userID, $request)
    {
        if($userID)
            $this->UserId = $userID;
        $this->OptionsDal->setRequest($this->UserId,$request);
    }

    function getProducerRequestLimit()
    {
        return $this->OptionsDal->getProducerModelLimit();
    }

    function setProducerRequestLimit($producerRequestLimit)
    {
        return $this->OptionsDal->setProducerRequestLimit($producerRequestLimit);
    }

    function getProducerModelLimit()
    {
        return  $this->OptionsDal->getProducerModelLimit();
    }

    function setProducerModelLimit($producerModelLimit)
    {
        return  $this->OptionsDal->setProducerModelLimit($producerModelLimit);
    }

    function getRequestTimeArea()
    {
        return   $this->OptionsDal->getRequestTimeArea();
    }

    function setRequestTimeArea($requestTimeArea)
    {
        return  $this->OptionsDal->setRequestTimeArea($requestTimeArea);
    }

    function getCommissionArea()
    {
        return   $this->OptionsDal->getCommissionArea();
    }

    function setCommissionArea($commissionArea)
    {
        return  $this->OptionsDal->setCommissionArea($commissionArea);
    }
}