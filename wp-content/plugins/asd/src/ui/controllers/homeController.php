<?php

class homeController
{
    public function index()
    {
        $ProductModel = new ProductModel(8);
       $data = $ProductModel->addProductForUser(5);


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
