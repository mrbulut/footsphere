<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 22.02.2019
 * Time: 14:25
 */
include_once 'IModel.php';

include_once ROOT_PATH . '/src/entities/concrete/OptionsConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/UserConcrete.php';
include_once ROOT_PATH . '/src/bussines/concrete/CustomerManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/OptionsManager.php';


class OptionsModel implements IModel
{
    private $OptionsManager;
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
    }


    public function getAllRequest(){
        self::optionsSetup();
        return $this->OptionsManager->getAllRequest();
    }

    public function getLangueages(){
        self::optionsSetup();
        return $this->OptionsManager->getLangueages($this->UserId);
    }
    public function setLangueages($langueages){
        self::optionsSetup();
        return $this->OptionsManager->setLangueages($this->UserId,$langueages);
    }
    public function getProducerRequestLimit()
    {
        self::optionsSetup();
        return $this->OptionsManager->getProducerRequestLimit();
    }

    public function getProducerModelLimit()
    {
        self::optionsSetup();
        return $this->OptionsManager->getProducerModelLimit();
    }

    public function getRequestTimeArea()
    {
        self::optionsSetup();
        return $this->OptionsManager->getRequestTimeArea();
    }

    public function getCommissionArea()
    {
        self::optionsSetup();
        return $this->OptionsManager->getCommissionArea();
    }

    public function setCommissionArea($value)
    {
        self::optionsSetup();
        return $this->OptionsManager->setCommissionArea($value);
    }

    public function setRequestTimeArea($value)
    {
        self::optionsSetup();
        return $this->OptionsManager->setRequestTimeArea($value);
    }

    public function setProducerModelLimit($value)
    {
        self::optionsSetup();
        return $this->OptionsManager->setProducerModelLimit($value);
    }

    public function setProducerRequestLimit($value)
    {
        self::optionsSetup();
        return $this->OptionsManager->setProducerRequestLimit($value);
    }

    public function createRequestForUser($RequestType)
    {
        $this->optionsSetup();
        return $this->OptionsManager->createRequestForUser($this->UserId, $RequestType);
    }

    public function createRequest($RequestType,$UserId)
    {
        $this->optionsSetup();
        return $this->OptionsManager->createRequestForUser($UserId, $RequestType);
    }


    public function getTheRequestTime($RequestType)
    {
        $this->optionsSetup();
        return $this->OptionsManager->getTheRequestTime($this->UserId, $RequestType);
    }

    private function optionsSetup()
    {
        $this->OptionsManager = new OptionsManager();
    }


}