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
}