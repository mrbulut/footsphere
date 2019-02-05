<?php

function teklifver()
{
    require_once(ABSPATH . "wp-content/plugins/footsphere/classes/teklifpage.php");
    require_once(ABSPATH . "wp-content/plugins/footsphere/database/requestDB.php");

    $userpage = new teklifpage($_POST['hiddenProducerNo'], $_POST['hiddenUserID'], $_POST['requestID'], $_POST['hiddenType']);
    $userpage->setup($_POST['hiddenChange']);
    $requestDB = new requestDB();
    echo $userpage->getResultPage();

   /* if (!isset($_POST['hiddenProducerNo']) || !isset($_POST ['hiddenUserID'])) {
        if($_POST['hiddenType']!=-1){
            header("Location: admin.php?page=producer_request");
        } 
    }*/





    if (isset($_POST['TeklifiOnaylaButton'])) {
        $requestDB->setRequestIDStatus($_POST['hiddenRequestID'], 1);

    }

    if (isset($_POST['TeklifiOnaylamaButton'])) {
        $requestDB->setRequestIDStatus($_POST['hiddenRequestID'], -1);
    }

    if (isset($_POST['reddetButton'])) {
        header("Location: admin.php?page=request_adminpage");
    }




    if (isset($_POST['onaylaButton'])) {
        // KUR FARKI
        $teklifler= explode(",",$_POST['hiddenTeklifArray']);
        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);

        $result='';
        for ($i=0; $i < count($teklifler); $i++) { 
            $urunid = explode(":", $teklifler[$i])[0];
            $fiyat = explode(":", $teklifler[$i])[1];
            $fiyat = $lang->localToUsd($fiyat);
            $result = $result . $urunid . ":". $fiyat .",";
        }
    

        // KUR FARKI
        
        $userpage->teklifiOnayla(
            $_POST['hiddenuserID'],
            $_POST['hiddenProId'],
            $_POST['hiddenRequestID'],
            $result,
            $_POST['hiddenType']
        );
    }

    if (isset($_POST['goruntuKapat'])) {
        header("Location: admin.php?page=producer_request");
    }

    if (isset($_POST['reddetButton'])) {
        header("Location: admin.php?page=request_adminpage");
    }


}
?>