<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 14.02.2019
 * Time: 16:55
 */


interface IRequestService
{
    function getAllRequest();

    function getRequestByProducerNo($ProducerNo);

    function getRequestById($Id);

    function getRequestByUserId($UserId);

    function getRequestByUserIdAndProducerNo($UserId, $ProducerNo);

    function setRequestByUserId($UserId, $Status);

    function createRequest($UserId, $ProducerNo, $RequestID, $Products, $Type,$Status);

    function removeRequest($RequestID);

    function getRequestStatus($ID);

    function setRequestStatusByID($ID, $Status);

    function getRequestStatusByRequestNo($RequestNo);

    function setRequestStatusByRequestNo($RequestNo, $Status);

    function getProducerStatistics($ProducerNo);


}