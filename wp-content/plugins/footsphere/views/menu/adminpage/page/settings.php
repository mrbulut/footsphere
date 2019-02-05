<?php
function settings()
{
    require_once(__DIR__ . '/implement/settings.php');
    $product = new settingspage();
    $product->setupPage();
    echo $product->getResult();

}
?>