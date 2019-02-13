<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 13.02.2019
 * Time: 11:48
 */



interface IOptionsService
{
    function addOption($option_name,$option_value);
    function updateOptionById($option_id,$option_value);
    function updateOptionByName($option_name,$option_value);

    function denineDefaultSettings();
    function getLangueages($UserId);
    function setLangueages($UserId, $langueages);
    function getRequest($UserId);
    function setRequest($UserId, $request);

    function getProducerRequestLimit();
    function setProducerRequestLimit($producerRequestLimit);

    function getProducerModelLimit();
    function setProducerModelLimit($producerModelLimit);

    function getRequestTimeArea();
    function setRequestTimeArea($requestTimeArea);

    function getCommissionArea();
    function setCommissionArea($commissionArea);



}