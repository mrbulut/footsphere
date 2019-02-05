<?php


 // require_once(__DIR__ . '/implement/products.php');
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/table.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/message.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/lib/Cookie.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bsproductDB.php");

require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/requestDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/wpusermetaDB.php");



class adminrequest extends tablepage
{
    private $dil;
    public function __construct()
    {
       self::zamaniBiteniOnayla();
        $js = null;
        $css = null;
        $new = new tablepage($js, $css);
        $database = new productDB();
        $bespokeDB = new bespokeDB();
        $producerDB = new producerDB();
        $component = new component();
        $contactDB = new contactDB();
        $requestDB = new requestDB();
        $wpusermetaDB = new usermetaDB();
        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();

        $list = $requestDB->getRequestALL();
        for ($i = 0; $i < count($list); $i++) {
            $toplamTeklifSayisi = count($requestDB->getProducerRequestLenghtToplam($list[$i]['producerNo'], -2));
            $onaylanmisTeklifSayisi = count($requestDB->getProducerRequestLenghtOnaylanmis($list[$i]['producerNo'], 1));
            $redTeklifSayisi = count($requestDB->getProducerRequestLenghtRed($list[$i]['producerNo'], -1));

            $durum = $_POST['durumSec'];
            $status = $list[$i]['Status'];
            if ($durum == "" || $durum == null) {
                if ($status == -1) {
                    $backgroundColor = "pink";
                    continue;
                } else if ($status == 1 || $status == 2) {
                    $backgroundColor = "LightGreen";
                    continue;
                } else if ($status == 0) {
                    $backgroundColor = "White";
                }
            } else {
                if ($status == -1) {
                    $backgroundColor = "pink";
                } else if ($status == 1 || $status == 2) {
                    $backgroundColor = "LightGreen";
                } else if ($status == 0) {
                    $backgroundColor = "White";
                }

            }
            $istekTuru = $list[$i]['type'];
            $sure = $wpusermetaDB->getTimeUserID($list[$i]['userID'], $istekTuru);
            if ($sure <= 0) {
                $sure = $this->dil['zamandoldu'];
                $gizlilik = 0;
            } else {
                $sure = $sure . $this->dil['teklifSüresibitecek'];
                $gizlilik = -1;
            }

            self::createForm("inceleButton", $this->dil['teklifincele'], $list[$i]['producerNo'], $list[$i]['userID'], $list[$i]['requestNo'],   $gizlilik , $list[$i]['type']);
            $form = self::getForm();
            $this->inArray[$i] = array(
                $list[$i]['userID'],
                $backgroundColor,
                $form,
                self::getKullaniciForEditor($list[$i]['producerNo']),
                $sure,
                $toplamTeklifSayisi . "/" . $onaylanmisTeklifSayisi . "/" . $redTeklifSayisi,
                ""

            );

        }


        $this->arrayHead = array(
            $this->dil['teklif'],
            $this->dil['teklifverenuretici'],
            $this->dil['kalansure'],
            $this->dil['toplamteklifsayisi']."<br>".$this->dil['onaylanmisteklifsayisi']."<br>".$this->dil['redteklifsayisi']."<br>",
  
             "", "");
        $this->baslik = $this->dil['menu_producer_istek'];


    }

    public function setupPage()
    {
        self::setBaslik($this->baslik);
        self::createTable($this->arrayHead, $this->inArray, $this->jscode, false, true, false, false, false, false);
        $arrayValue = array(
            array(
                'id' => 0,
                'value' =>  $this->dil['tumu'],
                'name' =>  $this->dil['tumu']

            )
        );
        self::setPopupmenu(
            "durumSec",
            $this->dil['durumsec'],
            "",
            $arrayValue,
            "id",
            "deger",
            true,
            $this->dil['onaylanmamisTeklifler'],
            $this->dil['durumsec']
        );

    }

    public function zamaniBiteniOnayla()
    {
        $requestDB = new requestDB();
        $usermetaDB = new usermetaDB();
        $bsproductDB = new bsproductDB();
        $database = new productDB();
        $bespokeDB = new bespokeDB();

        $list = $requestDB->getRequestALL();
        for ($i = 0; $i < count($list); $i++) {
            $producerNo = $list[$i]['producerNo'];
            $userID = $list[$i]['userID'];
            $requestID = $list[$i]['requestNo'];
            $status = $list[$i]['Status'];
            $teklifID = $list[$i]['id'];
            $type = $list[$i]['type'];
            $urunler = explode(",", $list[$i]['urunler']);
           // echo "burda".$usermetaDB->getTimeUserID($userID, $type);
           
         
      
            if ($usermetaDB->getTimeUserID($userID, $type) <= 0 && ($status == 0 || $status==1)) {
               // self::teklif($requestID, $userID, $producerID, true);
               // $requestDB->setRequestStatus($teklifID, 1);
               

               $requestDB->setRequestStatus($teklifID, 2);
               if ($type == "terlik") {
                   $bespokeDB->setStatusTerlik($userID, "actived");
               } else {
                   $bespokeDB->setStatusAyakkabi($userID, "actived");
               }

             
                for ($j = 0; $j < count($urunler) - 1; $j++) {

                    $urun = explode(":", $urunler[$j]);
                    $urunid = $urun[0];
                    $urunfiyat = $urun[1];

                    $uruntablo = $bsproductDB->getAllOnlyID($urunid);


                    if ($urunfiyat != '' || $urunfiyat != null) {
                        $database->urukEkle(
                            $uruntablo['baslik'],
                            $uruntablo['aciklama'],
                            $uruntablo['image'], // image yerine userıd geliyor benzersizlik için
                            "image",
                            $urunfiyat,
                            $userID,
                            $urunid
                        );
                    }



                }


               

              
               

            }
        }
    }

    public function getKullaniciForEditor($userID)
    {
        $user = new user($userID);
        return "<b>" . $user->getUser_displayname() . "</b><br>" . $user->getUser_login();
    }
    















/*
function getRequestAll()
{
    $table = new table("click.png", "delete.png", "change.png", false, false, false);
    $table->setHead($arrayHead);

    
    //$silmeJSCODE = '<input type="hidden" value="" id="hiddenValueDelete" name="hiddenValueDelete">';


}



function getKullaniciForEditor($userID)
{
    $user = new user($userID);
    return "<b>" . $user->getUser_displayname() . "</b><br>" . $user->getUser_login();
}

function getUrunlerForEditor($arrayVaule, $proID)
{
    $result = '';
    $database = new productDB();
    $component = new component();

    $productList = $database->getAllPROID($proID);

    $array = explode(",", $arrayVaule);

    for ($i = 0; $i < count($productList); $i++) {
        for ($j = 0; $j < count($array); $j++) {
            if ($productList[$i]['ID'] == $array[$j]) {
                $result = $result . $component->getHref("link", $productList[$i]['guid'], $productList[$i]['post_title']) . ",";
            }
        }

    }

    return '
    <div id="oncekiTeklif" name="oncekiTeklfi" style="border-style: ridge; border-width: 1px; border-color: coral; background-color:"#f1f1f1";">
    ' . $result . '
    </div>
    ';
}

function teklif($requestID, $userID, $producerID, $onay)
{
    $requestDB = new requestDB();
    $productDB = new productDB();
    $products = explode(",", $requestDB->getRequestID($requestID)['urunler']);


    for ($i = 0; $i < count($products); $i++) {
        if ($onay) {
            $productDB->urunuKullaniciyaEkleme($products[$i], $userID);

        } else {
            $productDB->urunuKullancidanCikarma($products[$i], $userID);

        }
    }
     */


}





?>