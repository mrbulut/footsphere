<?php

/**
Plugin Name: DENEMEPLGUSİB
Plugin URI: techsy.worksd
Description: XSXSs
Author: ^'+!'¡2£#>233
Version: 11.0
Author URI: ---
License: MIT
 **/
//SETUP MUST //
define('ABSPATH',dirname(__FILE__)."/../../../");

define('ROOT_PATH',__DIR__);

include_once ROOT_PATH."/src/bussines/concrete/CustomerManager.php";
$CustomerManager = new CustomerManager(1);
$Customer = new Customer();
$Customer->setAge(555);
$CustomerWhere = new Customer();
$CustomerWhere->setID(1);
echo "burda..." .$CustomerManager->setCustomerStatus(1,"fix");
//foreach ($data as $key => $value){
   // echo "asddasdasd. " . $key.$value . "<br>";
//}
//echo "dsadasdasdasd";
/*
    $CustomerManager->getCustomerList(); //return array
    $CustomerManager->addCustomer(); // return id
    $CustomerManager->updateCustomer(); //return boolean
    $CustomerManager->deleteCustomer(); // return boolean

    $CustomerManager->getRole();

    $CustomerManager->getExtraFile();
    $CustomerManager->updateExtraFile($filePath);
    $CustomerManager->deleteExtraFile($filePath);

    $CustomerManager->getProducts();
    $CustomerManager->updateProduct($array = array());
    $CustomerManager->deleteProduct($productNo);

    $CustomerManager->getLanguages();
    $CustomerManager->setLanguages($lang);

    $CustomerManager->getProductWaitingCustomers();
    $CustomerManager->getProductNoCompoleteCustomers();
    $CustomerManager->getProductCompoleteCustomers();
    $CustomerManager->getProductFixCustomers();

    $CustomerManager->setCustomerStatus($UserId,"Fix");
    */

//SETUP



/*
$rates = new ExchangeRateConverter(120); // 10 minutes cache
echo "ddddddddd.".$rates->convert('TRY','USD',25);
*/
?>





