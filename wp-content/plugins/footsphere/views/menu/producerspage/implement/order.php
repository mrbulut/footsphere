<?php


require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/table.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/popupwindow.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/tablepage.php");

class order extends tablepage
{
    private $arrayHead, $inArray, $jscode;

    private $name, $array;

    private $dil,$lang;

    public function __construct()
    {
        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $this->lang = new languages(0);
        $this->dil = $this->lang->getDil();

        $js = null;
        $css = null;
        $new = new tablepage($js, $css);

        $database = new productDB();
        $producerDB = new producerDB();
        $component = new component();
        $bespokeDB = new bespokeDB();

        
        if (isset($_POST['submitButtonDelete'])) {
            $db = new productDB();
            $db->urunSilmek($_POST['hiddenValueDelete']);
        }

        if (isset($_POST['submitButtonEdit'])) {
            $db = new productDB();
            $db->urunGuncelleme(
                $_POST['hiddenValueEdit'],
                $_POST['1_rows'],
                $_POST['2_rows'],
                $_POST['3_rows']
            );
        }

        if (isset($_POST['durumChangeButton_' . $id])) {
            $database->setStatusUrun($id, $_POST['durumPopup_' . $id]);
        }



        $list = $database->getAll();
        $onayMessage = '';
        for ($i = 0; $i < count($list); $i++) {

            $userID = 1;

            if ($database->getStatusUrun($list[$i]['ID']) == 0) {
                $durumMesaj = $this->dil['kisamesajUretimde'];
                $durumImage = "onaylanmadi.png";
            } else if ($database->getStatusUrun($list[$i]['ID']) == 1) {
                $durumMesaj = $this->dil['kisamesajBeklemede'];
                $durumImage = "beklemede.png";
            } else if ($database->getStatusUrun($list[$i]['ID']) == 2) {
                $durumMesaj = $this->dil['kisamesajTeslimedildi'];
                $durumImage = "onaylandi.png";
            } else {
                $durumMesaj = $this->dil['kisamesajUretimde'];
                $durumImage = "onaylanmadi.png";

            }

            echo $this->dil['degistir'];

            $durum = $component->getImageElement("/wp-content/plugins/footsphere/assets/images/" . $durumImage, 30) . $durumMesaj;
            $popupmenu = $durum . $component->getProPopupMenu(
                "durumPopup_" . $list[$i]['ID'],
                "",
                array($this->dil['kisamesajUretimde'],$this->dil['kisamesajBeklemede'],$this->dil['kisamesajTeslimedildi']),
                "",
                true,
                $this->dil['degistir']
            );
            $component->setForm("", "", "POST", "", $popupmenu, "");
            $popupmenu = $component->getForm();

            $backgroundColor;
            $this->inArray[$i] = array(
                $list[$i]['ID'],
                "white",
                "order.png",
                $userID . $list[$i]['ID'],//Sipariş No
                "<a href='" . $database->getProductLink($list[$i]['ID']) . "' >" . $list[$i]['post_title'] . "</a>",
                '    <input class="button-primary" onclick="openClick(' . $userID . ',0)" type="submit"  value="'.$this->dil['incele'].'"  class="button button-primary" />',
                $this->lang->usdToLocal($database->getPrice($list[$i]['ID'])),
                $database->getSepetEksBilgi($list[$i]['ID']),
                $database->getKargoTarihBilgi($list[$i]['ID']),
                $popupmenu


            );
            $this->baslik =  $this->dil['siparisler'];

            $this->arrayHead = array(
                $this->dil['backend_comp_urunGorsel'], 
                $this->dil['backend_comp_siparisUrunNo'], 
                 $this->dil['urun'], 
                 $this->dil['backend_comp_siparisUrunKisiBilgi'], 
                 $this->dil['backend_comp_siparisUrunFiyat'], 
                 $this->dil['backend_comp_siparisUrunNot'], 
                 $this->dil['backend_comp_siparisUrunKargoTarih'], 
                  "<b>". $this->dil['backend_profil_profilDurumBaslik']."</b>", 
                  "");
        }

    }

    public function setupPage()
    {
        self::setBaslik($this->baslik);
        self::createTable($this->arrayHead, $this->inArray, $this->jscode, true, false, false, false, false, false);
      //  self::setPopupwindow($this->name, null);//null ise product gelir
        /* self::setPopupmenu(
            $this->id,
            $this->popupname,
            $this->desc,
            array("Üretim Aşamasında", "Kargoya Verildi", "Teslim Edildi."),
            $this->key,
            $this->value,
            $this->buttonEnabled = true,
            $this->bosYazi = '',
            "Değiştir"
        );

       

            $popupmenu = "<form method='POST'>
            " . $component->getImageElement($durumImage, "25", $durumMesaj) . " 
            " . $component->getProPopupMenu
            ("durumPopup_" . $list[$i]['ID'], 
            "",
             array("Üretim Aşamasında", "Kargoya Verildi", "Teslim Edildi."),
             "altyazi",false,""
             
             ) . $component->getButton("durumChangeButton_" . $list[$i]['ID'], "Değiştir","","") 
             . "
            
            </form>";
         */
    }
}








?>