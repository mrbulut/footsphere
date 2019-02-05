<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/bespoke/implement/profil.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/shopmeComponent.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/footsphere/languages/languages.php");
$langg = new languages(0);
$dil= $langg->getDil();
unset($_POST['yukle']);
unset($_POST['kullanici_dosyasi']);
$db = new bespokeDB();
$smcomp = new smComponent();
/// Kullanıcının ayak fotoları resim yükleme ve geri çekme "uphoto "
//  "extra" kullanıcının yüklediği dosyalar.
$eksDosyalar = $db->getEksUploadedFile("extra");
$smcomp->setExtUploadFile($eksDosyalar,"extra");
if (isset($_POST['yukle'])) {
 
  $db->setEksDosyaYolu($smcomp->getFiledest("kullanici_dosyasi"),"extra");

  add_action('template_redirect', function(){
    if(isset($_POST['subscriptio'])){// make this condition such that it only matches when a registraiotn form get submitted
    /**
     * do your stuff here
     */
    wp_redirect("asdasdsa.php");//....
    }
    });
}

/// Resim yükleme ve geri çekme
$yukludosyalar = $smcomp->getExtUploadFile();


$db->userINFO()[2];
$dball = $db->getAll();
$adi = $db->userINFO()[2];
$soyadi = $db->userINFO()[3];
$yas = $dball['yas'];
$boyu = $dball['boyu'];
$kilosu = $dball['kilosu'];
$AyakOlcusu = $dball['AyakOlcusu'];
$EkstraBilgi = $dball['EkstraBilgi'];
$durum = $dball['bespokeStatus'];



// sm-6 1
$smcomp->setLabelEx("userNameLabel","",$dil['backend_profil_kAdiText'],"");$label = $smcomp->getLabelEx();
$adiLabelInput = $label.$smcomp->getInputtext("userNameInput","",$adi);

$smcomp->setLabelEx("userSurNameLabel","",$dil['backend_profil_sAdiText'],"");$label = $smcomp->getLabelEx();
$adiLabelInput = $adiLabelInput .$label.$smcomp->getInputtext("userSurNameInput","",$soyadi);

$smcomp->setLabelEx("oldLabel","",$dil['backend_profil_yasText'],"");$label = $smcomp->getLabelEx();
$adiLabelInput = $adiLabelInput .$label.$smcomp->getInputtext("oldInput","",$yas);

$smcomp->setLabelEx("longLabel","",$dil['backend_profil_boyText'],"");$label = $smcomp->getLabelEx();
$adiLabelInput = $adiLabelInput .$label.$smcomp->getInputtext("longInput","",$boyu);

$smcomp->setLabelEx("weightLabel","",$dil['backend_profil_kiloText'],"");$label = $smcomp->getLabelEx();
$adiLabelInput = $adiLabelInput .$label.$smcomp->getInputtext("weightInput","",$kilosu);

$smcomp->setLabelEx("olcuLabel","",$dil['backend_profil_aOlcuText'],"");$label = $smcomp->getLabelEx();
$adiLabelInput = $adiLabelInput .$label.$smcomp->getInputtext("olcuInput","",$AyakOlcusu);
$adiLabelInput = $adiLabelInput .$smcomp->getTextarea("ekstraInput",$dil['backend_profil_exBilgiText'],45,false,$EkstraBilgi);

$smcomp->setButtonEx("bespokeProfilButton","","submit",$dil['backend_profil_gonderButtonText'],"");
$button = $smcomp->getButtonEx();

$smcomp->setForm("","","POST","",$adiLabelInput.$button,"");
$form = $smcomp->getForm();

$smcomp->setDiv("","col-sm-6",$form,"","");
$div1_6= $smcomp->getDiv();

// sm-6 1

// sm-6 2



$file = $smcomp->getFile("kullanici_dosyasi",$dil['backend_profil_ekstraDosyaAciklama']);
$smcomp->setButtonEx("yukle","","submit",$dil['backend_profil_ekstraDosyaYukleButton'],"");
$button = $smcomp->getButtonEx();

$smcomp->setForm("","","POST","http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],$file.$button ,'enctype="multipart/form-data"');
$form = $smcomp->getForm();
$label =$smcomp->getLabel("eksDosyaBas",$dil['backend_profil_ekstraDosyaBaslik'],3);$smcomp->setFieldset("","",$form,"");
$fieldset = $smcomp->getFieldset();

$smcomp->setForm("","","POST","",$yukludosyalar,'');
$form = $smcomp->getForm();
$smcomp->setDiv("yuklenenDosyalar","",$form,"","");
$div= $label.$fieldset.$smcomp->getDiv();
$smcomp->setDiv("","col-sm-6",$div,"","");
$div2_6= $smcomp->getDiv();

//* */ sm-6 2

// sm-6 3 
$label = $smcomp->getLabel("footsphereFotoBilgiLabel",$dil['backend_profil_footsphereBilgiBaslik']);
$img = $smcomp->getImageElement("https://static.turbosquid.com/Preview/2014/07/09__10_23_50/foot_01.jpg8e96359f-ccb1-4d29-a2f5-0d4ba2b1315aOriginal.jpg?auto=compress&amp;cs=tinysrgb&amp;h=350",50,"");
$smcomp->setDiv("","col-sm-6",$label.$img,"","");
$div3_6= $smcomp->getDiv();
//** */ sm-6 3

// sm-6 4
$label = $smcomp->getLabel("footsphereFotoBilgiLabel",$dil['backend_profil_ayakFotolariBaslik']);
$img = $smcomp->getImageElement("https://static.turbosquid.com/Preview/2014/07/09__10_23_50/foot_01.jpg8e96359f-ccb1-4d29-a2f5-0d4ba2b1315aOriginal.jpg?auto=compress&amp;cs=tinysrgb&amp;h=350",50,"");
$img2 = $smcomp->getImageElement("https://static.turbosquid.com/Preview/2014/07/09__10_23_50/foot_01.jpg8e96359f-ccb1-4d29-a2f5-0d4ba2b1315aOriginal.jpg?auto=compress&amp;cs=tinysrgb&amp;h=350",50,"");
$smcomp->setDiv("","col-sm-6",$label.$img.$img2,"","");
$div4_6= $smcomp->getDiv();

//** */ sm-6 4


/// first 
// profil türü
if($durum=="eksik"){
  $durumText = $smcomp->setLabelEx("tamamlandiYazisi","",$dil['backend_profil_profilTamamlanmadi'],"color:red;");
}else{
  $durumText = $smcomp->setLabelEx("tamamlandiYazisi","",$dil['backend_profil_profilTamamlandi'],"color:green;");
}
$durumText = $smcomp->getLabelEx();
// profil türü
$label = $smcomp->getLabel("kullaniciDurumBas", $dil['backend_profil_profilDurumBaslik'], 3) . 
$smcomp->getLabel("kullaniciDurum",$durumText, 5);
/// first

// <SM-12></SM-12>
$smcomp->setDiv("","col-sm-12",$div1_6.$div2_6,"","");
$div1_12= $smcomp->getDiv();
$smcomp->setDiv("","col-sm-12",$div3_6.$div4_6,"","");
$div2_12= $smcomp->getDiv();

$smcomp->IN($label . "<br>", $div1_12."<br>".$div2_12);
$res = $smcomp->getIn();

echo $res;
?>
