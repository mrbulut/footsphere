<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/lib/message.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bsproductDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/popupwindow.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/tablepage.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");


class productpage extends tablepage
{
    private $arrayHead, $inArray, $jscode;

    private $name, $array;

    private $id, $popupname, $desc, $listid, $key, $value, $buttonEnabled, $bosYazi, $buttonText;

    private $baslik;

    private $component;
    private $dil;
    public function __construct($genel = false)
    { 

        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();
       
        $js = null;
        $css = null;
        $new = new tablepage($js, $css);
        $db = new bsproductDB();
        $database = new productDB();
        $bsproductDB = new bsproductDB();
        $this->component = new component();
        $producerDB = new producerDB();
        $user = new user();

        if (isset($_POST['submitButtonDelete'])) {
            $result = $db->deleteProduct($_POST['hiddenValueDelete']);
            shortMessage::success($this->dil['product_notificationSilindi']);
        }

        if (isset($_POST['submitButtonEdit'])) {
            $result = $db->updateProduct(
                $_POST['hiddenValueEdit'],
                $db->getUserID(),
                $_POST['1_rows'],
                $_POST['2_rows'],
                $_POST['3_rows'],
                $_POST['4_rows'],
                $_POST['5_rows'],
                $_POST['6_rows'],
                $_POST['7_rows'],
                $_POST['8_rows'],
                $_POST['9_rows'],
                $_POST['10_rows']
            );
            shortMessage::success($this->dil['product_notificationGuncellendi']);
        }

        if (isset($_POST['yeniUrunEkleClick'])) {

            $user->wp_producer_info();
            $toplamUrunSayiniz = count($bsproductDB->getProductAll($bsproductDB->getUserID()));
            $ureticiUrunSayiLimit = $database->getProducerProductLimit();


            if ($toplamUrunSayiniz > $ureticiUrunSayiLimit) {
                shortMessage::error($ureticiUrunSayiLimit .$this->dil['product_notificationFazlaUrunUyari']);

            } else {
        //$popupwindow->setRows("popupmenu", "ureticiSecAdd", "Üretiçi seç", $list, "id", "value", false);

                $userID = $user->getID();

                $filedesk = $this->component->getFiledest("uploadFile") .
                    $this->component->getFiledest("uploadFile2") .
                    $this->component->getFiledest("uploadFile3");

                $id = $db->addProduct(
                    $userID,
                    $_POST['urunadi'],
                    $_POST['urunAciklamasi_area'],
                    $_POST['turu'],
                    $_POST['tabanMalzeme'],
                    $_POST['kapanisTuru'],
                    $_POST['ustMalzeme'],
                    $_POST['astarMalzemesi'],
                    $_POST['Sezon'],
                    $_POST['icTabanturu'],
                    $_POST['icTabanMalzemesi'],
                    $filedesk
                );
                shortMessage::success($this->dil['product_notificationEklendi']);
            }

        }



        if ($genel) {

            if (isset($_POST['ureticiSec_btn'])) {
                if ($_POST['ureticiSec']) {
                    $list = $bsproductDB->getProductAll($_POST['ureticiSec']);

                } else {
                    $list = $bsproductDB->getAll();
                }

            } else {
                $list = $bsproductDB->getAll();
            }
            $onayMessage = '';
            for ($i = 0; $i < count($list); $i++) {

                $id = $list[$i]['id'];
                $producerNo = $list[$i]['producerNo'];
                $ad = $list[$i]['baslik'];
                $aciklama = $list[$i]['aciklama'];
                $image = explode("+-+", $list[$i]['image']);
                $status = $list[$i]['Status'];

                if ($status == -1) {
                    $onayMessage = $this->component->getImageElement("/wp-content/plugins/footsphere/assets/images/onaylanmadi.png", 30) . " ".$this->dil['onaylanmadi'].".<br> " . self::getOnaylaButton($id);
                } else if ($status == 0) {
                    $onayMessage = $this->component->getImageElement("/wp-content/plugins/footsphere/assets/images/beklemede.png", 30) . "  ".$this->dil['beklemede']."..<br> " . self::getOnaylaButton($id);
                } else {
                    $onayMessage = $this->component->getImageElement("/wp-content/plugins/footsphere/assets/images/onaylandi.png", 30) . "  ".$this->dil['onaylandi']."..<br> " . self::getOnaylaButton($id);

                }

                $backgroundColor;
                $this->inArray[$i] = array(
                    $id,
                    "white",
                    $image,
                    $ad,
                    $aciklama,
                    $list[$i]['turu'],
                    $list[$i]['tabanMalzeme'],
                    $list[$i]['kapanisTuru'],
                    $list[$i]['ustMalzeme'],
                    $list[$i]['astarMalzemesi'],
                    $list[$i]['Sezon'],
                    $list[$i]['icTabanturu'],
                    $list[$i]['icTabanMalzemesi'],
                    $producerDB->getName($list[$i]['producerNo']),
                    $onayMessage . '<input type="hidden" value="' . $list[$i]['producerNo'] . '" id="hiddenValueProducerNo" name="hiddenValueProducerNo">'
                );
            }
            $listProducer = $producerDB->getAll();
            $this->arrayHead = array(
                $this->dil['backend_comp_urunGorsel'],
                $this->dil['backend_comp_urunBasligiText'],
                $this->dil['backend_comp_urunAciklamasiText'],
                $this->dil['backend_comp_turuText'],
                $this->dil['backend_comp_tabanMalzemeText'],
                $this->dil['backend_comp_kapanisTuru'],
                $this->dil['backend_comp_ustMalzeme'],
                $this->dil['backend_comp_astarMalzemesi'],
                $this->dil['backend_comp_sezon'],
                $this->dil['backend_comp_icTabanturu'],
                $this->dil['backend_comp_icTabanMalzemesi'],
                $this->dil['üretici'],
                $this->dil['menu_producer_dashboard'],
                $this->dil['sil']."/" .$this->dil['duzenle']);
     
            $this->baslik =  $this->dil['menu_producer_urunler'];
            self::setPopupmenu(
                "ureticiSec",
                $this->dil['ureticiSec'],
                $this->dil['ureticiSecAciklama'],
                $listProducer,
                "id",
                 "ureticiAdi",
                 true,
                 "",
                 $this->dil['uygula']);

        } else {


            $list = $bsproductDB->getProductAll($bsproductDB->getUserID());
            $onayMessage = '';
            for ($i = 0; $i < count($list); $i++) {
                $id = $list[$i]['id'];
                $ad = $list[$i]['baslik'];
                $aciklama = $list[$i]['aciklama'];
                $image = explode("+-+", $list[$i]['image']);
                $status = $list[$i]['Status'];

                if ($status == -1) {
                    $onayMessage = $this->component->getImageElement("/wp-content/plugins/footsphere/assets/images/onaylanmadi.png", 30) . $this->dil['onaylanmadi'];
                } else if ($status == 0) {
                    $onayMessage = $this->component->getImageElement("/wp-content/plugins/footsphere/assets/images/beklemede.png", 30) . $this->dil['beklemede'];
                } else {
                    $onayMessage = $this->component->getImageElement("/wp-content/plugins/footsphere/assets/images/onaylandi.png", 30) .$this->dil['onaylandi'];

                }



                $this->inArray[$i] = array(
                    $id,
                    "white",
                    $image,
                    $ad,
                    $aciklama,
                    $list[$i]['turu'],
                    $list[$i]['tabanMalzeme'],
                    $list[$i]['kapanisTuru'],
                    $list[$i]['ustMalzeme'],
                    $list[$i]['astarMalzemesi'],
                    $list[$i]['Sezon'],
                    $list[$i]['icTabanturu'],
                    $list[$i]['icTabanMalzemesi'],
                    $onayMessage
                );
            }
            $this->baslik = "Ürünleriniz";
            $this->arrayHead = array(
                $this->dil['backend_comp_urunGorsel'],
                $this->dil['backend_comp_urunBasligiText'],
                $this->dil['backend_comp_urunAciklamasiText'],
                $this->dil['backend_comp_turuText'],
                $this->dil['backend_comp_tabanMalzemeText'],
                $this->dil['backend_comp_kapanisTuru'],
                $this->dil['backend_comp_ustMalzeme'],
                $this->dil['backend_comp_astarMalzemesi'],
                $this->dil['backend_comp_sezon'],
                $this->dil['backend_comp_icTabanturu'],
                $this->dil['backend_comp_icTabanMalzemesi'],
                $this->dil['menu_producer_dashboard'],
                $this->dil['sil']."/" .$this->dil['duzenle']);
        
        }

        $this->name = $this->dil['yeniUrunEkle'];

    }

    public function setupPage()
    {
        self::setBaslik($this->baslik);
        self::createTable($this->arrayHead, $this->inArray, $this->jscode,
            true, false, false,
            true, true, true);
        self::setPopupwindow($this->name, null);//null ise product gelir
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



    /**
     * Get the value of jscode
     */
    public function getJscode()
    {
        return $this->jscode;
    }

    /**
     * Set the value of jscode
     *
     * @return  self
     */
    public function setJscode($jscode)
    {
        $this->jscode = $jscode;

        return $this;
    }

    public function getOnaylaButton($urunID)
    {
        $component = new component();
    
        $bsproductDB = new bsproductDB();
        if (isset($_POST['onaylaButton'])) {
            $productID = $_POST['onayValue'];
            $bsproductDB->setProductStatus($productID, 1);
        }
        if (isset($_POST['onaylamaButton'])) {
            $productID = $_POST['onayValue'];
            $bsproductDB->setProductStatus($productID, -1);
        }
        return '
        <form method="POST">
        <input type="hidden" value="' . $urunID . '" name="onayValue" id="onayValue">
        ' . $component->getButton("onaylaButton", $this->dil['onayla'], "",$this->dil['onayla']) . $component->getButton("onaylamaButton", $this->dil['onaylama'], "", "")
            . '
        
        </form>
        ';
    }
}











?>
