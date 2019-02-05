<?php




if (isset($_POST['contactSubmitButton'])) {
    $databaseProduct = new contactDB();
    $databaseProduct->mesajYaz($_POST['messageTextArea']);
}

function getResult()
{
    require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/footsphere/languages/languages.php");
    $langg = new languages();
    $dil= $langg->getValue(0);

    $databaseProduct = new contactDB();
    $resultHTML = $databaseProduct->getAllMessage();
    $array = array(
        'profil' => 'Profil',
        'bespoke' => 'Bespoke',
        'contact' => 'İletişim',
        'return' => 'İade'
    );

    $smcomp = new smComponent();
    $smcomp->SMheader($array);
    $smcomp->setScrollbar("messageBaslik", "messageIN", $resultHTML);
    $scBar = $smcomp->getScrollbar();
    $smcomp->setTextareaEx("messageTextArea","","","Mesajiniz",false,"","");
    $txarea = $smcomp->getTextareaEx();
    $smcomp->setButtonEx("contactSubmitButton","","submit","gönder","");
    $button = $smcomp->getButtonEx();
    $smcomp->setForm("","","POST","",$txarea.$button,"");
    $form = $smcomp->getForm();

    $smcomp->IN($scBar.$form,"");
    $res = $smcomp->getIn();
    return $res;
}









?>



