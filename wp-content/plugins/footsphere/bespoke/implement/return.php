<?php
$result = "kurllar vs <br>iade için operatörle iletişime geçiniz.";

require_once (ABSPATH ."wp-content/plugins/footsphere/database/productDB.php");
require_once (ABSPATH ."wp-content/plugins/footsphere/database/bespokeDB.php");
require_once (ABSPATH ."wp-content/plugins/footsphere/database/contactDB.php");
//require_once (ABSPATH ."wp-content/plugins/footsphere/database/returnDB.php");
if(isset($_POST['hiddenValueThisPageLink'])) {
    echo $_POST['hiddenValueThisPageLink'];
   echo "<script>window.location='".$_POST['hiddenValueThisPageLink']."';

</script>";
}
/*

$databaseProduct = new returnDB();

$result = $databaseProduct->mesajYaz("birinci mesaj geliyor!!!");

*/

/*
$result = $databaseProduct->getAllMessage();

if (isset($_POST['contactSubmitButton'])){
	echo "messageTextArea = = = = " . $_POST['messageTextArea'];
    $databaseProduct->mesajYaz($_POST['messageTextArea']);
}
*/


//$databaseProduct->urunEklemek("Son sürüm ürün eklemek denemesi.","bu sürümün kısa açıklaması","http://localhost/wp-content/uploads/2018/11/grid-AI-324x324.jpg","grid-AI-324x324","500",2);









?>



