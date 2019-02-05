<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");

require_once(ABSPATH . "wp-content/plugins/footsphere/classes/message.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");

function message()
{
    $contactDB = new contactDB();

    $userID;
    $userID = $_POST['hiddenValueOpen'];
    if (isset($_POST['okuButton'])) {
        $message = new message();
        $user = new user();
        
       if($user->getUser_role()=="contributor") // Operasyon yöneticisi ise görüldü yapabilir.
        $message->setINMESSAGE($contactDB->getAllMessageUserID($userID,true));
        else
        $message->setINMESSAGE($contactDB->getAllMessageUserID($userID,false));

        $message->getAllMesage( $userID,true);

        echo $message->getResult().'' ;
    }


    if(!isset( $userID)){
       header("Location: admin.php?page=contact"); 
    }

    if (isset($_POST['gonderButton'])) {

        $contactDB->mesajYaz($_POST['messageBox_area'], $contactDB->userID(),false);
    
      }


    


}



?>