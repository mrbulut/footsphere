<?php



//$yukludosyalar = yukluDosyalariGetir($eksDosyalar);




if (isset($_POST['bespokeProfilButton'])) {
    guncelle(
        $_POST['userNameInput'],
        $_POST['userSurNameInput'],
        $_POST['oldInput'],
        $_POST['longInput'],
        $_POST['weightInput'],
        $_POST['olcuInput'],
        $_POST['ekstraInput_area']
    );
}





/*echo "<pre>                dsd dsadasdasdsadasd sa =";
echo  $db->userINFO()[0]  ; // userid
echo  $db->userINFO()[1]  ; //Email
echo  $db->userINFO()[2]  ; //Adi
echo  $db->userINFO()[3]  ; //Soyadi
echo  $db->userINFO()[4]  ; // KullaniciAdi

echo  $db->getAll()['boyu']  ;
echo  $db->getAll()['kilosu']  ;
echo  $db->getAll()['footsphereDosyaYolu']  ;
echo  $db->getAll()['ekstraDosyaYolu']  ;
"<b> Yüklenmiş dosyalar ; </b> <br> rapor.pdf <br> delil.pdf"
 */


function guncelle($name, $surname, $old, $long, $weight, $olcu, $bilgi)
{
    $db = new bespokeDB();
    $db->setFirstName($name);
    $db->setLastName($surname);
    $db->setBoyu($long);
    $db->setKilo($weight);
    $db->setYas($old);
    $db->setAyakOlcusu($olcu);
    $db->setEkstraBilgi($bilgi);
   // echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";



}


//echo ($db->$db->getAll()['boyu']) ?  $db->$db->getAll()['boyu'] :  '';

?>