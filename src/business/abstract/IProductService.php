<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 13.02.2019
 * Time: 16:41
 */


interface IProductService
{
    function getAllProduct($Type);

    function getAllProductByProducerNo($ProducerNo);

    function getProductByIdArray($ID);

    function getProductById($ID);

    function getProductByObject(Product $product);

    function setProductStatus($ID, $Status);

    function getProductStatus($ID);

    function removeProduct($ID);

    function upgradeProduct(Product $product, $ID);

    function addProductForUser($ProductId, $UserId);

    function createProduct(Product $product);

    function getAllListForTheUser($UserId);

    function removeProductPermissionForUser($UserId, $ProductId);


}