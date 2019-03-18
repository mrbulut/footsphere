<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 22.02.2019
 * Time: 14:26
 */

include_once 'IModel.php';
include_once ROOT_PATH . '/src/entities/concrete/RequestConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/UserConcrete.php';
include_once ROOT_PATH . '/src/bussines/concrete/UserManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/RequestManager.php';



class RequestModel implements IModel
{

    private $RequestManager;
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


    public function createRequest($array = array())
    {

        self::requestSetup();
        return $this->RequestManager->createRequest(
            $this->UserId,
            $array['ProducerNo'],
            $array['RequestID'],
            $array['Products'],
            $array['Type']
        );
    }

    public function getAllRequest()
    {
        self::requestSetup();
        return $this->RequestManager->getAllRequest();
    }

    public function getRequest($array = array())
    {
        self::requestSetup();
        if ($array['RequestNo']) {
            return $this->RequestManager->getRequestByRequestNoAndProducerNo($array['RequestNo'],$array['ProducerNo']);
        } else if ($array['ProducerNo'] && $array['UserId']) {
            return $this->RequestManager->getRequestByUserIdAndProducerNo($array['ProducerNo'], $array['UserId']);
        } else if ($array['ID']) {
         return $this->RequestManager->getRequestById($array['ID']);
        } else if ($array['ProducerNo']) {
            return $this->RequestManager->getRequestById($array['ProducerNo']);
        } else if ($array['UserId']) {
            return $this->RequestManager->getRequestByUserId($array['UserId']);
        }
    }

    public function setStatus($Status, $RequestID = null)
    {
        self::requestSetup();
        if ($RequestID) {
            return $this->RequestManager->setRequestStatusByID($RequestID, $Status);

        } else {
            return $this->RequestManager->setRequestByUserId($this->UserId, $Status);

        }
    }

    public function removeRequest($RequestID)
    {
        self::requestSetup();
        return $this->RequestManager->removeRequest($RequestID);
    }

    public function getProducerStatistcs($ProducerNo)
    {
        self::requestSetup();
        // $this->RequestManager->getProducerStatistics($ProducerNo);
    }

    private function requestSetup()
    {
        $this->RequestManager = new RequestManager($this->UserId);

    }


}