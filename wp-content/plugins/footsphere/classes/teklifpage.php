<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/userpage.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bsproductDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/requestDB.php");

class teklifpage extends page
{
    private $result;
    private $producerID;
    private $user;
    private $userID;

    private $userpage;

    private $gecmisTeklifler;
    private $urunler;
    private $yeniTeklif;
    private $arrayHead;
    private $teklifEdilenUrunler;

    private $urunleri;

    private $bsproductDB;
    private $requestDB;

    private $requestID;
    private $type;

    private $aktif;
    private $dil,$lang;
    function __construct($producerID = 0, $userID, $requestID = 0, $type)
    {
        $this->producerID = $producerID;
        $this->userID = $userID;
        $this->aktif = $aktif;
        $this->requestID = $requestID;
        $this->type = $type;


        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $this->lang = new languages(0);
        $this->dil = $this->lang->getDil();


        self::addjscode("teklifpage");
        self::addcsscode("teklifpage");
        self::addjscode('bootstrap.min');
        self::addcsscode('bootstrap.min');

        $this->user = new userpage($userID);
        $this->bsproductDB = new bsproductDB();
        $this->requestDB = new requestDB();
        if (isset($_POST['TeklifiOnaylaButton'])) {
            echo "<script>alert(".$_POST['hiddenRequestID'].")</script>";
            self::teklifSUC($_POST['hiddenRequestID']);
            header("Location: admin.php?page=request_adminpage");
    
        }
        if (isset($_POST['TeklifiOnaylamaButton'])) {
            self::teklifRED($_POST['hiddenRequestID']);
            header("Location: admin.php?page=request_adminpage");
        }
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
            $this->dil['backend_comp_urunFiyat']." ".($this->lang->getLocalParaBirimiSimgesi()),
             "", "");

        $this->user->setup();
        $this->userpage = $this->user->getResult();


       

        

    }

    public function setup($gizlilik = 0)
    {


        self::setUrunler();
        self::setGecmisTeklifler($this->producerID, $this->userID,$this->requestID);
        self::setYeniTeklif(        $this->dil['backend_teklifpage_teklifverButton']
    );
        self::setPage($gizlilik);

    }


    public function setPage($gizlilik)
    {
        
        self::setHeader($this->userpage);
        self::setRows(self::getYeniTeklif());
        if($gizlilik==1){
            $button1 = self::getButton("onaylaButton", $this->dil['backend_teklifpage_teklifverButton'], "", "");
            $button2 = self::getButton("goruntuKapat", $this->dil['kapatYazisi'], "", "");
        }else if($gizlilik==-1){
            wp_dequeue_script("teklifpage");
            $button1 = self::getButton("TeklifiOnaylaButton", $this->dil['onayla'], "", "");
            $button2 = self::getButton("TeklifiOnaylamaButton", $this->dil['onaylama'], "", "");
            $button3 = self::getButton("reddetButton", $this->dil['reddet'], "", "");
        }
        
        else{
            wp_dequeue_script("teklifpage");
            $button2 = self::getButton("goruntuKapat", $this->dil['kapatYazisi'],  "", "");
        }
        
//
        self::setDiv("footerDiv", "", '<form method="POST">
        <input type="hidden" id="hiddenTeklifArray" name="hiddenTeklifArray" value="' . self::getGecmisTeklifler() . '">
        <input type="hidden" id="hiddenuserID" name="hiddenuserID" value="' . $this->userID . '">
        <input type="hidden" id="hiddenProId" name="hiddenProId" value="' . $this->producerID . '">
        <input type="hidden" id="hiddenRequestID" name="hiddenRequestID" value="' . $this->requestID . '">
        <input type="hidden" id="hiddenType" name="hiddenType" value="' . $this->type . '">

        ' . $button1 . $button2 .$button3. "</form>", "", "", "");
        $div = self::getDiv();

        self::setFooter($div);


    }

    public function teklifSUC($reqID){
        $this->requestDB->setRequestStatus($reqID, 1);
    }

    public function teklifRED($reqID){
        $this->requestDB->setRequestStatus($reqID, -1);
    }

    public function teklifiOnayla($uId,$proID,$reqID,$hiArray,$hiType)
    {
        $this->requestDB->setRequest(
            $uId,
           $proID,
           $reqID,
           $hiArray,
           $hiType
        );

        header("Location: admin.php?page=producer_request");
    }


    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $this->result . $result;
       // self::footer($this->gecmisTeklifler);

        return $this;
    }

    /**
     * Get the value of gecmisTeklifler
     */
    public function getGecmisTeklifler()
    {

        return $this->gecmisTeklifler;
    }

    /**
     * Set the value of gecmisTeklifler
     *
     * @return  self
     */
    public function setGecmisTeklifler($pro,$user,$reqID)
    {
        $gecmisTeklifler = $this->requestDB->getRequest($user,$pro,$reqID)[0]['urunler'];
        
        $this->gecmisTeklifler = $gecmisTeklifler;
        return $this;
    }

    /**
     * Get the value of urunler
     */
    public function getUrunler()
    {
        return $this->urunler;
    }

    /**
     * Set the value of urunler
     *
     * @return  self
     */
    public function setUrunler()
    {
        if($this->type=="ayakkabi"){
            $type = "Ayakkabı";
        }else{
            $type = $this->type;
        }
        $urunler = $this->bsproductDB->getProductAll($this->producerID,$type);
        $this->urunler = $urunler;
        return $this;
    }

    /**
     * Get the value of userpage
     */
    public function getUserpage()
    {
        return $this->userpage;
    }

    /**
     * Set the value of userpage
     *
     * @return  self
     */
    public function setUserpage($userpage)
    {
        $this->userpage = $userpage;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of yeniTeklif
     */
    public function getYeniTeklif()
    {
        return $this->yeniTeklif;
    }

    /**
     * Set the value of yeniTeklif
     *
     * @return  self
     */
    public function setYeniTeklif($yeniTeklif, $change = true)
    {
        $result = '';
        $arrayRows;
        $list = self::getUrunler();
        $gecmisTeklifler = explode(",", self::getGecmisTeklifler());

        for ($i = 0; $i < count($list); $i++) {
            $status = $list[$i]['Status'];
            if ($status != 1) {
                continue;
            }
            


            $background = "white";
            $fiyat = null;

            for ($j = 0; $j < count($gecmisTeklifler); $j++) {
                $teklif = explode(":", $gecmisTeklifler[$j]);
                $urunid = $teklif[0];
                if ($urunid == $list[$i]['id']) {
                    $background = "LightGreen";
                    $fiyat = $teklif[1];
                }
            }

            $image = explode("+-+", $list[$i]['image']);


            $fiyat = $this->lang->usdToLocalSembolsuz($fiyat);

            $fiyatText = self::getInputtext($list[$i]['id'] . "_input", "", $fiyat, $change);

            $arrayRows[$i] = array(
                $list[$i]['id'],
                $background,
                $image,
                $list[$i]['baslik'],
                $list[$i]['aciklama'],
                $list[$i]['turu'],
                $list[$i]['tabanMalzeme'],
                $list[$i]['kapanisTuru'],
                $list[$i]['ustMalzeme'],
                $list[$i]['astarMalzemesi'],
                $list[$i]['Sezon'],
                $list[$i]['icTabanturu'],
                $list[$i]['icTabanMalzemesi'],
                $fiyatText,
                ""
            );
        }




        self::setH(2, "teklifBaşlığı", "", $yeniTeklif, "", "");
        $baslik = self::getH();
        self::setTable($this->arrayHead, $arrayRows, "", true, false, false, false, false, false);
        $result = self::getTable();
        $this->yeniTeklif = "<br>" . $baslik . $result;
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
     * Get the value of teklifEdilenUrunler
     */
    public function getTeklifEdilenUrunler()
    {
        return $this->teklifEdilenUrunler;
    }

    /**
     * Set the value of teklifEdilenUrunler
     *
     * @return  self
     */
    public function setTeklifEdilenUrunler($teklifEdilenUrunler)
    {
        $this->teklifEdilenUrunler = $teklifEdilenUrunler;

        return $this;
    }
}


?>