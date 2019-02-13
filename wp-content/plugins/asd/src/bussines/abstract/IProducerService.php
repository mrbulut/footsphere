<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 13.02.2019
 * Time: 13:52
 */



interface IProducerService
{
    function getProducerProducts();
    function addProduct($UserId,$array=array());
    function deleteProduct($UserId,$ProductNo);

    function getProducerByUserId($UserId);
    function getProducerAll();

    function updateProducerByUserId(Producer $producer,$UserId);
    function createProducer($Name,$Email,$Pass,$OfferLimit);
    function removeProducer($UserId);

}