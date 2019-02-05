<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/bespoke/implement/bespoke.php");



$bs = new bespoke();
$bs->setupPage();
echo $bs->getResult();
?>

