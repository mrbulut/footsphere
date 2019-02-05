<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/classes/message.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");

function model()
{
    $userID;
    if (isset($_POST['okuButton'])) {
        $userID = $_POST['hiddenValueOpen'];
        $message = new message();
        $contactDB = new contactDB();

        $message->setINMESSAGE($contactDB->getAllMessageUserID($_POST['hiddenValueOpen']));

        $message->getAllMesage($_POST['hiddenValueOpen'],true);

        echo $message->getResult().'' ;
    }


    if(!isset($_POST['hiddenValueOpen'])){
       header("Location: admin.php?page=contact"); 
    }

    if (isset($_POST['gonderButton'])) {
        $contactDB = new contactDB();
        $contactDB->mesajYaz($_POST['messageBox'], $_POST['hiddenValueUser']);
    
      }


    


}



?>