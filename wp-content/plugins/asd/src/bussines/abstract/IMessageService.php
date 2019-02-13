<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 12.02.2019
 * Time: 09:54
 */


interface IMessageService
{

    function getMessagesList(Message $message);
    function addMessage(Message $message);
    function deleteMessage(Message $message);
    function updateMessage(Message $message,Message $messageWhere);

    function getAllMessageForUser($UserId);
    function isThereUnreadMessageForUser($UserId);
    function getAllMessage();
    function getAllMessageLenght();
    function getAllUnDreadMessages();
    function setTheUserMessagesRead($UserId);
    function writeMessage($UserId,$Message,$Who);


}