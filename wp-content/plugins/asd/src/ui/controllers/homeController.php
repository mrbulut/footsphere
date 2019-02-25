<?php

class homeController
{
    public function index()
    {
$UserModel = new UserModel(11);
 $UserModel->updateProducer(
    array(
        "email" => "NewtestEmail@testsite.com",
        "password"  =>"passwords",
        "OfferLimit" =>"50-250",
        'display_name' => "New",
        'CompanyName' => "New",
        'PhoneNumber' => "New",
        'PhoneNumber2' => "New",
        'Address' => "New",
        'PaymentInformantion' => "New",
        'CargoInformantion' => "New",

    )
);


   die();
    }
}
