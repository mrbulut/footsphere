<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 12.02.2019
 * Time: 09:54
 */







interface ICustomerService
{
    function getCustomerList(Customer $customer);
    function addCustomer(Customer $customer);
    function updateCustomer(Customer $customer, Customer $customerWhere);
    function deleteCustomer(Customer $customer);

    function getRole();

    function getExtraFile();
    function updateExtraFile($filePath);
    function deleteExtraFile($filePath);

    function getProducts();
    function updateProduct($array = array());
    function deleteProduct($productNo);

    function getLanguages();
    function setLanguages($lang);

    function getProductWaitingCustomers();
    function getProductNoCompoleteCustomers();
    function getProductCompoleteCustomers();
    function getProductFixCustomers();


}