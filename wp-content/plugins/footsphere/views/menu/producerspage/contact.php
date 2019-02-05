<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/message.php");


function producer_contact()
{


  $message = new message();
  $contactDB = new contactDB();
  $userID = $contactDB->userID();
  $message->setINMESSAGE($contactDB->getAllMessageUserID($userID));
  $message->getAllMesage($userID, false);
  echo $message->getResult() . '';

  if (isset($_POST['gonderButton'])) {
    $contactDB = new contactDB();
    $contactDB->mesajYaz($_POST['messageBox_area'], $userID,true);

  }




}


?>