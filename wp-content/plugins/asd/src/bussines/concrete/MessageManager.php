<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 12.02.2019
 * Time: 16:25
 */

include_once ROOT_PATH . "/src/bussines/abstract/IMessageService.php";
include_once ROOT_PATH . "/src/data/concrete/MessageDal.php";
include_once ROOT_PATH . "/src/data/concrete/OptionsDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/MessageConcrete.php";
include_once ROOT_PATH . "/src/bussines/abstract/IMessageService.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";

class MessageManager implements IMessageService
{
    private $Logger;
    private $MessageDal;
    private $UserDal;
    private $UserId;
    private $Message;
    private $MessageWhere;
    private $MessageObjectData;

    public function __construct($UserID = null)
    {
        $this->MessageDal = new MessageDal();
        $this->UserDal = new UserDal($UserID);
        $this->Logger = new Logger(new FileLogger());
        $this->UserId = $this->UserDal->getUser()->getID();
        $this->Message = new Message();
        $this->MessageWhere = new Message();
        $this->Message->setUserId($this->UserDal->getUserId());
        $this->MessageObjectData = self::getMessagesList($this->Message);
    }

    function getMessagesList(Message $message)
    {
        $this->MessageDal->settingQuery(null, $message);
        try {
            if ($message) {
                $result = $this->MessageDal->getToObject();
                if ($result) {
                    $this->Logger->Log("Mesajlar getirildi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Mesajlar getirilemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function addMessage(Message $message)
    {
        $this->MessageDal->settingQuery($message);
        try {
            if ($message) {
                $result = $this->MessageDal->insertToObject();
                if ($result) {
                    $this->Logger->Log("Mesaj Yazıldı.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Mesaj Yazılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }

        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function deleteMessage(Message $message)
    {
        $this->MessageDal->settingQuery(null, $message);
        try {
            if ($message) {
                $result = $this->MessageDal->deleteToObject();
                if ($result) {
                    $this->Logger->Log("Mesaj Silindi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Mesaj Silinemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function updateMessage(Message $message, Message $messageWhere)
    {
        $this->MessageDal->settingQuery($message, $messageWhere);
        try {
            if ($message) {
                $result = $this->MessageDal->updateToObject();
                if ($result) {
                    $this->Logger->Log("Mesaj Güncellendi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Mesaj Güncelennemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function getAllMessageForUser($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        $this->MessageWhere->ResetObject();
        $this->MessageWhere->setUserId($this->UserId);
        return self::getMessagesList($this->MessageWhere);
    }

    function isThereUnreadMessageForUser($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        $this->MessageWhere->ResetObject();
        $this->MessageWhere->setUserId($this->UserId);
        $this->MessageWhere->setStatus("Unread");
        return self::getMessagesList($this->MessageWhere);
    }

    function getAllMessage()
    {
        return $this->MessageDal->selectAll();
    }

    function getAllMessageLenght()
    {
        return count($this->MessageDal->selectAll());
    }

    function getAllUnDreadMessages()
    {
        $this->MessageWhere->ResetObject();
        $this->MessageWhere->setStatus("Unread");
        return self::getMessagesList($this->MessageWhere);
    }

    function setTheUserMessagesRead($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        $this->MessageWhere->ResetObject();
        $this->Message->ResetObject();

        $this->MessageWhere->setUserId($this->UserId);
        $this->Message->setStatus("Read");
        return self::updateMessage($this->Message, $this->MessageWhere);
    }

    function writeMessage($UserId, $Message, $Who)
    {
        if($Message!='' || $Message!=null){
            if ($UserId)
                $this->UserId = $UserId;
            $this->Message->ResetObject();

            if($Who=="Editor"){
                $this->Message->setStatus("Read");
            }else{
                $this->Message->setStatus("Unread");
            }
            $this->Message->setUserId($this->UserId);
            $this->Message->setMessage($Message);
            $this->Message->setDate(date("Y-m-d H:i:s"));
            $this->Message->setWhoIsMessage($Who);
            return self::addMessage($this->Message);
        }else{
            return "empty_message";
        }


    }
}