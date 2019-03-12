<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:27
 */
include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";

class Message implements IEntity
{
    public $ID;
    public $UserId;
    public $WhoIsMessage;
    public $Message;
    public $Date;
    public $Status;

    /**
     * Message constructor.
     * @param $Id
     * @param $UserId
     * @param $WhoIsMessage
     * @param $Message
     * @param $Date
     * @param $Status
     */
    public function __construct()
    {

    }
    function ResetObject() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->ID;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->ID = $Id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param mixed $UserId
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
    }

    /**
     * @return mixed
     */
    public function getWhoIsMessage()
    {
        return $this->WhoIsMessage;
    }

    /**
     * @param mixed $WhoIsMessage
     */
    public function setWhoIsMessage($WhoIsMessage)
    {
        $this->WhoIsMessage = $WhoIsMessage;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->Message;
    }

    /**
     * @param mixed $Message
     */
    public function setMessage($Message)
    {
        $this->Message = $Message;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param mixed $Date
     */
    public function setDate($Date)
    {
        $this->Date = $Date;
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


}