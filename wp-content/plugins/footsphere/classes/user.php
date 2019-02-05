<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/MysqliDb.php");

class user 
{
     //wp_producer//

     private $sirketAdi;
     private $telefon;
     private $telefon2;
     private $adres;
     private $odemebilgi;
     private $urunleri;
     private $emaili;
     private $kargobilgi;
     private $ureticiadi;
     private $teklifLimit;

    // wp_bespoke//
     private $userID;
     private $boyu;
     private $kilosu;
     private $yas;
     private $AyakOlcusu;
     private $footsphereDosyaYolu;
     private $ekstraDosyaYolu;
     private $kullanilabilirUrunler;
     private $bespokeStatus;
     private $EkstraBilgi;
     private $ayakFotolari;
     
     
    // wp_users //
     private $ID;
     private $user_login;
     private $user_email;
     private $user_displayname;
     private $user_role;
     private $user_languages;

     private $database;
     private $producerDB;
     private $mysqliDB;
     


     function __construct($userID = 0)

     {
          $this->database = new bespokeDB();
          $this->producerDB = new producerDB();
          $this->mysqliDB = new MysqliDb();

          if ($userID == 0) {
               $this->userID = $this->database->userID();
          } else {

               $this->userID = $userID;
          }
          // wp_users //
          self::wp_user_info();


     }



     public function wp_user_info()
     {

          $getallListWpUser = $this->database->getAllWpUserID($this->userID);

          $this->ID = $getallListWpUser['ID'];
          $this->user_login = $getallListWpUser['user_login'];
          $this->user_email = $getallListWpUser['user_email'];
          $this->user_displayname = $getallListWpUser['display_name'];
          $this->user_role = $this->database->getRole($this->userID);
          $this->user_languages = $this->database->getLangueages($userID);
     }

     public function wp_bespoke_info($full = false)
     {
          if ($full) {
               $getAllList = $this->database->getTotalUser();
          } else {
               $getAllList = $this->database->getAllID($this->userID);
          }
          $this->userID = $getAllList['userID'];
          $this->boyu = $getAllList['boyu'];
          $this->kilosu = $getAllList['kilosu'];
          $this->yas = $getAllList['yas'];
          $this->AyakOlcusu = $getAllList['AyakOlcusu'];
          $this->footsphereDosyaYolu = $getAllList['footsphereDosyaYolu'];
          $this->ekstraDosyaYolu = $getAllList['ekstraDosyaYolu'];
          $this->kullanilabilirUrunler = explode(",", $getAllList['kullanilabilirUrunler']);
          $this->bespokeStatus = $getAllList['bespokeStatus'];
          $this->EkstraBilgi = $getAllList['EkstraBilgi'];
          $this->ayakFotolari = $getAllList['AyakFotolari'];

          
     }

     public function wp_producer_info($full = false)
     {
          if ($full) {
               $getAllList = $this->producerDB->getAll();
          } else {
               $getAllList = $this->producerDB->getAllID($this->userID);
          }
          $this->sirketAdi = $getAllList['SirketAdi'];
          $this->telefon = $getAllList['telefon'];
          $this->telefon2 = $getAllList['telefon2'];
          $this->adres = $getAllList['adresi'];
          $this->odemebilgi = $getAllList['odemeBilgi'];
          $this->urunleri = $getAllList['urunleri'];
          $this->emaili = $this->getUser_email();
          $this->kargobilgi = $getAllList['kargoBilgi'];
          $this->ureticiadi = $this->getUser_displayname();
          $this->teklifLimit = $getAllList['MinMaxTeklif'];

          return $getAllList;
     }

     public function wp_user_update($dp, $mail, $sifre = '')
     {
          if ($sifre != '') {
               $this->mysqliDB->updateUser($this->userID, $dp, $mail, $sifre);
          } else {
               $this->mysqliDB->updateUser($this->userID, $dp, $mail);
          }
     }

     public function wp_bespoke_update($dp, $mail, $sifre)
     {
          if ($sifre != '') {
               $this->mysqliDB->updateUser($this->userID, $dp, $mail, $sifre);
          } else {
               $this->mysqliDB->updateUser($this->userID, $dp, $mail);
          }
     }

     public function wp_producer_update(
          $adi,
          $srktadi,
          $tel,
          $tel2,
          $email,
          $adres,
          $odeme,
          $kargo,
          $maxmin
     ) {

          $this->producerDB->ureticiGuncelle(
               $this->userID,
               $adi,
               $srktadi,
               $tel,
               $tel2,
               $email,
               $adres,
               $odeme,
               $kargo,
               $maxmin
          );
     }




     /**
      * Get the value of user_role
      */
     public function getUser_role()
     {
          return $this->user_role;
     }

     /**
      * Set the value of user_role
      *
      * @return  self
      */
     public function setUser_role($user_role)
     {
          $this->user_role = $user_role;

          return $this;
     }

     /**
      * Get the value of user_displayname
      */
     public function getUser_displayname()
     {
          return $this->user_displayname;
     }

     /**
      * Set the value of user_displayname
      *
      * @return  self
      */
     public function setUser_displayname($user_displayname)
     {
          $this->user_displayname = $user_displayname;

          return $this;
     }

     /**
      * Get the value of user_email
      */
     public function getUser_email()
     {
          return $this->user_email;
     }

     /**
      * Set the value of user_email
      *
      * @return  self
      */
     public function setUser_email($user_email)
     {
          $this->user_email = $user_email;

          return $this;
     }




     /**
      * Get the value of user_login
      */
     public function getUser_login()
     {
          return $this->user_login;
     }

     /**
      * Set the value of user_login
      *
      * @return  self
      */
     public function setUser_login($user_login)
     {
          $this->user_login = $user_login;

          return $this;
     }

     /**
      * Get the value of EkstraBilgi
      */
     public function getEkstraBilgi()
     {
          return $this->EkstraBilgi;
     }

     /**
      * Set the value of EkstraBilgi
      *
      * @return  self
      */
     public function setEkstraBilgi($EkstraBilgi)
     {
          $this->EkstraBilgi = $EkstraBilgi;

          return $this;
     }

     /**
      * Get the value of bespokeStatus
      */
     public function getBespokeStatus()
     {
          return $this->bespokeStatus;
     }

     /**
      * Set the value of bespokeStatus
      *
      * @return  self
      */
     public function setBespokeStatus($bespokeStatus)
     {
          $this->bespokeStatus = $bespokeStatus;

          return $this;
     }

     /**
      * Get the value of kullanilabilirUrunler
      */
     public function getKullanilabilirUrunler()
     {
          return $this->kullanilabilirUrunler;
     }

     /**
      * Set the value of kullanilabilirUrunler
      *
      * @return  self
      */
     public function setKullanilabilirUrunler($kullanilabilirUrunler)
     {
          $this->kullanilabilirUrunler = $kullanilabilirUrunler;

          return $this;
     }

     /**
      * Get the value of ekstraDosyaYolu
      */
     public function getEkstraDosyaYolu()
     {
          return $this->ekstraDosyaYolu;
     }

     /**
      * Set the value of ekstraDosyaYolu
      *
      * @return  self
      */
     public function setEkstraDosyaYolu($ekstraDosyaYolu)
     {
          $this->ekstraDosyaYolu = $ekstraDosyaYolu;

          return $this;
     }

     /**
      * Get the value of footsphereDosyaYolu
      */
     public function getFootsphereDosyaYolu()
     {
          return $this->footsphereDosyaYolu;
     }

     /**
      * Set the value of footsphereDosyaYolu
      *
      * @return  self
      */
     public function setFootsphereDosyaYolu($footsphereDosyaYolu)
     {
          $this->footsphereDosyaYolu = $footsphereDosyaYolu;

          return $this;
     }

     /**
      * Get the value of AyakOlcusu
      */
     public function getAyakOlcusu()
     {
          return $this->AyakOlcusu;
     }

     /**
      * Set the value of AyakOlcusu
      *
      * @return  self
      */
     public function setAyakOlcusu($AyakOlcusu)
     {
          $this->AyakOlcusu = $AyakOlcusu;

          return $this;
     }

     /**
      * Get the value of yas
      */
     public function getYas()
     {
          return $this->yas;
     }

     /**
      * Set the value of yas
      *
      * @return  self
      */
     public function setYas($yas)
     {
          $this->yas = $yas;

          return $this;
     }



     /**
      * Get the value of kilosu
      */
     public function getKilosu()
     {
          return $this->kilosu;
     }

     /**
      * Set the value of kilosu
      *
      * @return  self
      */
     public function setKilosu($kilosu)
     {
          $this->kilosu = $kilosu;

          return $this;
     }

     /**
      * Get the value of boyu
      */
     public function getBoyu()
     {
          return $this->boyu;
     }

     /**
      * Set the value of boyu
      *
      * @return  self
      */
     public function setBoyu($boyu)
     {
          $this->boyu = $boyu;

          return $this;
     }

     /**
      * Get the value of user_languages
      */
     public function getUser_languages()
     {
          return $this->user_languages;
     }

     /**
      * Set the value of user_languages
      *
      * @return  self
      */
     public function setUser_languages($user_languages)
     {
          $this->user_languages = $user_languages;

          return $this;
     }


     /**
      * Get the value of sirketAdi
      */
     public function getSirketAdi()
     {
          return $this->sirketAdi;
     }

     /**
      * Set the value of sirketAdi
      *
      * @return  self
      */
     public function setSirketAdi($sirketAdi)
     {
          $this->sirketAdi = $sirketAdi;

          return $this;
     }

     /**
      * Get the value of telefon
      */
     public function getTelefon()
     {
          return $this->telefon;
     }

     /**
      * Set the value of telefon
      *
      * @return  self
      */
     public function setTelefon($telefon)
     {
          $this->telefon = $telefon;

          return $this;
     }

     /**
      * Get the value of telefon2
      */
     public function getTelefon2()
     {
          return $this->telefon2;
     }

     /**
      * Set the value of telefon2
      *
      * @return  self
      */
     public function setTelefon2($telefon2)
     {
          $this->telefon2 = $telefon2;

          return $this;
     }

     /**
      * Get the value of adres
      */
     public function getAdres()
     {
          return $this->adres;
     }

     /**
      * Set the value of adres
      *
      * @return  self
      */
     public function setAdres($adres)
     {
          $this->adres = $adres;

          return $this;
     }

     /**
      * Get the value of odemebilgi
      */
     public function getOdemebilgi()
     {
          return $this->odemebilgi;
     }

     /**
      * Set the value of odemebilgi
      *
      * @return  self
      */
     public function setOdemebilgi($odemebilgi)
     {
          $this->odemebilgi = $odemebilgi;

          return $this;
     }

     /**
      * Get the value of urunleri
      */
     public function getUrunleri()
     {
          return $this->urunleri;
     }

     /**
      * Set the value of urunleri
      *
      * @return  self
      */
     public function setUrunleri($urunleri)
     {
          $this->urunleri = $urunleri;

          return $this;
     }



     /**
      * Get the value of emaili
      */
     public function getEmaili()
     {
          return $this->emaili;
     }

     /**
      * Set the value of emaili
      *
      * @return  self
      */
     public function setEmaili($emaili)
     {
          $this->emaili = $emaili;

          return $this;
     }

     /**
      * Get the value of kargobilgi
      */
     public function getKargobilgi()
     {
          return $this->kargobilgi;
     }

     /**
      * Set the value of kargobilgi
      *
      * @return  self
      */
     public function setKargobilgi($kargobilgi)
     {
          $this->kargobilgi = $kargobilgi;

          return $this;
     }

     /**
      * Get the value of ureticiadi
      */
     public function getUreticiadi()
     {
          return $this->ureticiadi;
     }

     /**
      * Set the value of ureticiadi
      *
      * @return  self
      */
     public function setUreticiadi($ureticiadi)
     {
          $this->ureticiadi = $ureticiadi;

          return $this;
     }

     /**
      * Get the value of teklifLimit
      */
     public function getTeklifLimit()
     {
          return $this->teklifLimit;
     }

     /**
      * Set the value of teklifLimit
      *
      * @return  self
      */
     public function setTeklifLimit($teklifLimit)
     {
          $this->teklifLimit = $teklifLimit;

          return $this;
     }

     /**
      * Get the value of ID
      */
     public function getID()
     {
          return $this->ID;
     }

     /**
      * Set the value of ID
      *
      * @return  self
      */
     public function setID($ID)
     {
          $this->ID = $ID;

          return $this;
     }

     /**
      * Get the value of ayakFotolari
      */
     public function getAyakFotolari()
     {
          return $this->ayakFotolari;
     }

     /**
      * Set the value of ayakFotolari
      *
      * @return  self
      */
     public function setAyakFotolari($ayakFotolari)
     {
          $this->ayakFotolari = $ayakFotolari;

          return $this;
     }
}


?>