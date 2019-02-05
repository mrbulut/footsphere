<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/table.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/MysqliDb.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/popupwindow.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/tablepage.php");


class producerpage extends tablepage
{

    private $array;
    private $dil;
    public function __construct($genel = false)
    {
        $js = null;
        $css = null;
        $new = new tablepage($js, $css);
        $database = new productDB();
        $producerDB = new producerDB();
        $component = new component();
        $user = new user();
    
        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();

        if (isset($_POST['submitButtonDelete'])) {
            $producerDB->ureticiSil($_POST['hiddenValueDelete']);
        }

        if (isset($_POST['submitButtonEdit'])) {
            $producerDB->ureticiGuncelle(
                $_POST['hiddenValueEdit'],
                $_POST['1_rows'],
                $_POST['2_rows'],
                $_POST['3_rows'],
                $_POST['4_rows'],
                $_POST['5_rows'],
                $_POST['6_rows'],
                $_POST['7_rows'],
                $_POST['8_rows'],
                $_POST['9_rows']
            );
        }

        if (isset($_POST['yeniUreticiEkle'])) {
            $kAdi = $_POST['kAdi'];
            $adi = $_POST['adi'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $teklifara = $_POST['minteklif'] . '-' . $_POST['maxteklif'];
            $myDB = new MysqliDb();
            $userID = $myDB->createProducer($kAdi, $password, $email, $adi);
            if ($userID) {
                $producerDB->ureticiEkle($userID, $adi, $email, $teklifara);
            }
            //$producerDB->ureticiEkle();
        }



        $list = $user->wp_producer_info(true);
        for ($i = 0; $i < count($list); $i++) {

            $this->inArray[$i] = array(
                $list[$i]['id'],
                "white",
                $producerDB->getUserName($list[$i]['id']),
                $list[$i]['ureticiAdi'],
                $list[$i]['SirketAdi'],
                $list[$i]['telefon'],
                $list[$i]['telefon2'],
                $list[$i]['email'],
                $list[$i]['adresi'],
                $list[$i]['odemeBilgi'],
                $list[$i]['kargoBilgi'],
                $list[$i]['MinMaxTeklif'],
                ""



            );

        }

        $this->arrayHead = array(
            $this->dil['kullaniciAdi'],$this->dil['ureticiAD'],$this->dil['sirketAdi'],$this->dil['tel'],$this->dil['tel']."-2",
            $this->dil['eposta'],$this->dil['adres'],$this->dil['odemeBilgi'],$this->dil['kargoBilgi'],$this->dil['maxminBaslik'],"",$this->dil['sil']."/".$this->dil['duzenle']
        );
        $this->name =  $this->dil['ureticiEkle'];
        $this->array = array(
            array(
                'type' => "inputtext",
                'id' => "kAdi",
                'name' => $this->dil['kullaniciAdi'],
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "inputtext",
                'id' => "adi",
                'name' =>  $this->dil['backend_profil_kAdiText'],
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "inputtext",
                'id' => "email",
                'name' =>  $this->dil['eposta'],
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "inputtext",
                'id' => "password",
                'name' =>  $this->dil['sifre'],
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "inputtext",
                'id' => "minteklif",
                'name' => $this->dil['minteklif'],
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "inputtext",
                'id' => "maxteklif",
                'name' => $this->dil['maxteklif'],
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "button",
                'id' => "yeniUreticiEkle",
                'name' =>$this->dil['backend_comp_UrunEklebuttonText'],
                'exs' => '',
                'key' => "",
                'value' => "",
                'button' => false,
            )

        );

        $this->baslik = $this->dil['ureticiler'];

        
    }

    public function setupPage()
    {
        self::setBaslik($this->baslik);
        self::createTable($this->arrayHead, $this->inArray, $this->jscode, false, true, false, true, true, false);
        self::setPopupwindow($this->name, $this->array);//null ise product gelir
        /*self::setPopupmenu(
            $this->id,
            $this->popupname,
            $this->desc,
            $this->listid,
            $this->key,
            $this->value,
            $this->buttonEnabled = true,
            $this->bosYazi = '',
            $this->buttonText
        );*/
    }

    public function getProducts($producerID)
    {
        $bsproductDB = new bsproductDB();
        $arrayValue = explode(",", $bsproductDB->getAllProducer($producerID));
        $component = new component();

        $urunler = '';

        for ($i = 0; $i < count($arrayValue) - 1; $i++) {
            $urunler = $urunler .

                $component->getHref(
                "link",
                $productDB->getProductLink($arrayValue[$i]),
                $productDB->getName($arrayValue[$i])
            ) . "<br>";

        }




        return $urunler;
    }



}







?>
