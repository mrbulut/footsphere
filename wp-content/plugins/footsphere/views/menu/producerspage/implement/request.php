<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/table.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/wpusermetaDB.php");

require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/popupwindow.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/tablepage.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/teklifpage.php");


class request extends tablepage
{

    private $requestDB, $usermetaDB, $productDB, $bespokeDB, $bsproductDB;
    private $component;
    private $table;
    private $popupmenu;
    private $result;
    private $kalansure;
    private $gecmisButton;
    private $saat;
    private $dakika;
    private $teklifsuresibitti;

    private $requestIcon;
    private $arrayHead = array();
    private $producerID, $dil;
    
    /*
    public function openTeklifPage($producerID,$buttonID,$userID,$change=false)
    {
        if(isset($_POST[$buttonID])){
            $userpage = new teklifpage($producerID,$userID);
            $userpage->setup($change);
            echo $userpage->getResultPage();
        }
    }
     */
    function __construct($lastRequest = false)
    {
        require_once(ABSPATH . "/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();

        $this->requestIcon = "request.png";
        $this->saat = $this->dil['saat'];
        $this->dakika = $this->dil['dakika'];
        $this->teklifsuresibitti = $this->dil['teklifSüresiBitti'];
        $this->baslik =  $this->dil['menu_producer_istek'];
        $this->producerDB = new producerDB();
        $this->bespokeDB = new bespokeDB();
        $this->usermetaDB = new usermetaDB();
        $this->productDB = new productDB();
        $this->bsproductDB = new bsproductDB();
        $this->component = new component();
        $js = null;
        $css = null;
        $new = new tablepage($js, $css);

        $this->producerID = $this->bespokeDB->userID();
        $this->requestDB = new requestDB();

        $list = $this->usermetaDB->getAllRequsetUser();

        $inArray = array();
        if ($lastRequest) {
            $this->arrayHead = array("", $this->dil['istekNumarasi'], $this->dil['istekTur'],$this->dil['kalansure'],
            $this->dil['incele'],
         "");

          //  $list = $this->requestDB->getProducerID($this->userID);
            for ($i = 0; $i < count($list); $i++) {
                $userID = $list[$i]['user_id'];
                $istekTuru = explode("request", $list[$i]['meta_key'])[1];
               // $status = $list[$i]['Status'];
                $sure = $this->usermetaDB->getTimeUserID($userID, $istekTuru);
                $reqID = $list[$i]['umeta_id'];
                $request = $this->requestDB->getRequestID($reqID);
                $status = $request['Status'];
                $type = $request['type'];

                if (0 < $sure) {
                    continue;
                }
                if ($status == 0 || $status == -1) {
                    $backgroundColor = "pink";
                } else if ($status == 1) {
                    $backgroundColor = "Lightgreen";
                } else {
                    continue;
                }
                $istekTuru = explode("request", $list[$i]['meta_key'])[1];

                //self::openTeklifPage($this->producerID,"inceleButton_".$userID,$userID,false);

                self::createForm("inceleButton", $this->dil['incele'], $this->producerID, $userID, $reqID, 0, $istekTuru);
                $form = self::getForm();
                $arrayRows = array(
                    $userID,
                    $backgroundColor,
                    $this->requestIcon,
                    $reqID,
                    $istekTuru,
                    $this->teklifsuresibitti,
                    $form
                );
                $this->inArray[$i] = $arrayRows;
            }
            self::setGecmisButton($this->component->getButton("bosButton", $this->dil['gerigel'], 'producer_request', ""));


        } else {
            $this->arrayHead = array("", $this->dil['istekNumarasi'],$this->dil['istekTur'],$this->dil['kalansure'], $this->dil['teklif'], "");



            for ($i = 0; $i < count($list); $i++) {
                $backgroundColor = "white";
                $istekTuru = explode("request", $list[$i]['meta_key'])[1];
                $userID = $list[$i]['user_id'];
                $gecmisTeklif = $this->requestDB->getRequest($userID, $this->producerID, $list[$i]['umeta_id'])[0]['urunler'];
                $sure = $this->usermetaDB->getTimeUserID($userID, $istekTuru);
                if (1 > $sure) {
                    continue;
                }
                if ($gecmisTeklif != "" || $gecmisTeklif != null) {
                    $backgroundColor = "Orange";
                    $teklifButtonText = $this->dil['backend_profil_gonderButtonText'];
                } else {
                    $teklifButtonText =$this->dil['teklifver'];
                }


                self::createForm("teklifver", $teklifButtonText, $this->producerID, $userID, $list[$i]['umeta_id'], 1, $istekTuru);
                $form = self::getForm();



                //self::openTeklifPage($this->producerID,"teklifver_".$userID,$userID,true);
                $arrayRows = array(
                    $list[$i]['user_id'],
                    $backgroundColor,
                    $this->requestIcon,
                    $list[$i]['umeta_id'],
                    $istekTuru,
                    $sure . $this->dil['teklifSüresibitecek'] ,//Sipariş No
                    $form

                );
                $this->inArray[$i] = $arrayRows;
            }
            self::setGecmisButton($this->component->getButton("bosButton", $this->dil['gecmisTeklifleriGor'], 'lastrequest', ""));

        }

        
           


    //    $this->component->setTable($this->arrayHead, $inArray, "", false, false, false, false, false);
    //    self::setResult($this->component->getTable());
    }

    public function setupPage()
    {
        self::setBaslik($this->baslik);
        self::setHeader($this->gecmisButton);
        self::createTable($this->arrayHead, $this->inArray, $this->jscode, false, false, false, false, false, false);
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
    

   
// SETTER 



/*


function teklfiEdilen($userID, $producerID, $requestID)
{
    $result = '';
    $requestDB = new requestDB();
    $bsproductDB = new bsproductDB();
    $component = new component();

    $productList = $bsproductDB->getProductAll($bsproductDB->getUserID());

    $urunler = explode(",", $requestDB->getRequest($userID, $producerID, $requestID)[0]['urunler']);

    for ($i = 0; $i < count($productList); $i++) {

        for ($j = 0; $j < count($urunler); $j++) {
            if ($productList[$i]['id'] == $urunler[$j]) {
                $result = $result . $component->getHref("link", "asd", $productList[$i]['baslik']);
            }
        }



    }

    return '
    <div id="oncekiTeklif" name="oncekiTeklfi" style="border-style: ridge; border-width: 1px; border-color: coral; background-color:"#f1f1f1";">
        ' . $result . '
        </div>
    ';
     */



    public function getGecmisButton()
    {
        return $this->gecmisButton;
    }
    public function setGecmisButton($gecmisButton)
    {
        $this->gecmisButton = $gecmisButton;

        return $this;
    }






}

?>
