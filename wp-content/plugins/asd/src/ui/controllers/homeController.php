<?php

class homeController
{
    public function index()
    {
        $ProductModel = new OptionsModel(8);
        echo $ProductModel->getTheRequestTime("Shoes")[0];


        /*
        $UserModel->createRequest(array(
            "ProducerNo"  => "1",
            "RequestID"  => "1",
            "Type"  => "1",
            "Products"  => "1:222;12:444"
        ));

        */
        die();
    }
}
