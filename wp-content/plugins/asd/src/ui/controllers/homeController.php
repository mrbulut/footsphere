<?php

class homeController
{
    public function index()
    {
        $UserModel = new RequestModel(11);
        echo $UserModel->getProducerStatistcs(11);
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
