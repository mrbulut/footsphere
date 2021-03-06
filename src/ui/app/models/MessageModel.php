<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 22.02.2019
 * Time: 14:25
 */

include_once 'IModel.php';

include_once ROOT_PATH . '/src/entities/concrete/MessageConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/UserConcrete.php';
include_once ROOT_PATH . '/src/business/concrete/CustomerManager.php';
include_once ROOT_PATH . '/src/business/concrete/MessageManager.php';

class MessageModel implements IModel
{

    private $MessageManager;
    private $UserId;

    public function __construct($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        else {
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $this->UserId = $current_user->ID[0];
            }
        }
    }

    public function getAllMessage()
    {
        $this->messageSetup();
        return $this->MessageManager->getAllMessage();
    }

    public function getAllMessageLenght()
    {
        return count(self::getAllMessage());
    }

    public function getAllUnreadMessages()
    {
        self::messageSetup();
        return $this->MessageManager->getAllUnreadMessages();
    }

    public function getAllMessageForUser()
    {
        self::messageSetup();
        return $this->MessageManager->getAllMessageForUser($this->UserId);
    }


    public function writeMessage($Message)
    {
        self::messageSetup();
        return $this->MessageManager->writeMessage($this->UserId, $Message,
            self::getRole(true));
    }

    public function setTheUserMessagesRead($UserId)
    {
        $this->messageSetup();
        return $this->MessageManager->setTheUserMessagesRead($UserId);
    }

    public function isThereUnreadMessageForUser()
    {
        $this->messageSetup();
        return $this->MessageManager->isThereUnreadMessageForUser($this->UserId);
    }

    private function getRole($girisyapankullanici=false)
    {
        if($girisyapankullanici)
        $user = new CustomerManager();
        else
            $user= new CustomerManager($this->UserId);
        return $user->getRole();
    }

    private function messageSetup()
    {
        $this->MessageManager = new MessageManager($this->UserId);

    }


}