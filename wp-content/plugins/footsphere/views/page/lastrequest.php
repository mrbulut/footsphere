<?php
require_once ABSPATH . "wp-content/plugins/footsphere/views/menu/producerspage/implement/request.php";

function lastrequest()
{

    $product =  new request(true);
    $product->setupPage();
    echo $product->getResultPage();

}






?>