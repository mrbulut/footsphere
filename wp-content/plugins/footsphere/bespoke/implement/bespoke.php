<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/footsphere/classes/component.php");

/*
if ($_POST['plist']) {
    //sleep(2000);
    $pList =$_POST['plist'];
    $pType =$_POST['ptype'];
    $count =$_POST['count'];
    $filtre =$_POST['filtre'];

    

    
    $component = new component();
    $component->setFiltreler();
   // echo $pList.$pType.$component->getFiltreler().$count;
  echo $component->setGenelProductAfterList($pList,$pType,$component->getFiltreler(),$count);
    
 //   $component->setLi("","","dsadasdas","","");

   // echo $component->getLi();
  //  echo $component->getBody();
  

}
*/

class bespoke
{
    private $smcomp;
    private $user;
    private $bespokeDB;
    private $wpusermetaDB;
    private $databaseProduct;
    private $component;

    private $result;
    private $status;
    private $footStatus;
    private $terlikStatus;

    private $profilEksik;
    private $istekdeBulun;
    private $urunBekleniyor;
    private $urunler;
    private $kullanilabilirUrunler;

    private $leftFilter;
    private $proField;
    private $ayakkabiDiv;
    private $terlikDiv;
    private $proShowResult;

    private $script;
    private $dil;


    function __construct()
    {

        require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/database/requestDB.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/database/wpusermetaDB.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/bespoke/implement/bespoke.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/classes/shopmeComponent.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
        require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
        require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/footsphere/languages/languages.php");
        $langg = new languages(0);
        $this->dil= $langg->getDil();

        wp_enqueue_script("bootstrap.min");
        wp_enqueue_style("bootstrap.min");
        wp_enqueue_script("productshow");
        wp_enqueue_style("productshow");

        self::setScript("bootstrap.min", "js");
        self::setScript("productshow", "js");
        //self::setScript("jquery-3.3.1.min","js");

        self::setScript("bootstrap.min", "css");
        self::setScript("productshow", "css");


        $this->smcomp = new smComponent();
        $this->component = new component();
        $this->user = new user();
        $this->bespokeDB = new bespokeDB();
        $this->wpusermetaDB = new usermetaDB();
        $this->databaseProduct = new productDB();
        $this->user->wp_bespoke_info(false);
        $this->status = $this->bespokeDB->getBespokeStatus($this->wpusermetaDB->userID());
        $this->footStatus = $this->bespokeDB->getStatusAyakkabi($this->wpusermetaDB->userID());
        $this->terlikStatus = $this->bespokeDB->getStatusTerlik($this->wpusermetaDB->userID());

        $this->component->setFiltreler();

        self::setLeftFilter($this->component->getProductAllFilter());

        self::setKullanilabilirUrunler(-1); // -1 giriş yapan kullanıcı idsi üzerinden 

        if (isset($_POST['ayakkabiistekButton']))

            $this->wpusermetaDB->createRequestUser($this->wpusermetaDB->userID(), "ayakkabi");
        if (isset($_POST['terlikistekButton']))
            $this->wpusermetaDB->createRequestUser($this->wpusermetaDB->userID(), "terlik");
        if (isset($_POST['satinAlmaButton']))
            $this->databaseProduct->setSepetEksBilgi($_POST['product_id'], $_POST['satinAlmaNot']);
    }

    public function addScript()
    {
        # code...
    }

    public function setupPage()
    {
        $in = '';

        if ($this->status == "eksik") {
             //kullanıcı verileri eksik
            self::setProfilEksik($this->dil['backend_bespoke_profilegitButton'], $this->dil['backend_bespoke_profilegitAciklama']);
            self::setProField(self::getProfilEksik());

        } else {



            if (isset($_POST['terlikTurSecButton'])) {
                if ($this->terlikStatus == "tamam") {

                    self::setIstekdeBulun(
                    "terlikistekButton", 
                    $this->dil['backend_bespoke_istekBulunTerlikButton'],
                    $this->dil['backend_bespoke_istekBulunTerlikAciklama'] );
                    self::setTerlikDiv(self::getIstekdeBulun());

            

                } else if ($this->terlikStatus == "closed") {
                    self::setUrunBekleniyor("terlik", $this->dil['backend_bespoke_istekBulunTerlikUrunBekleniyorAciklama']);
                    self::setTerlikDiv(self::getUrunBekleniyor());

                } else if ($this->terlikStatus == "actived") {
                    $this->component->setGenelProduct($this->kullanilabilirUrunler, "Terlik", $this->component->getFiltreler(), 0, 10);
                    self::setTerlikDiv($this->component->getGenelProduct());



                }
                self::setProField(self::getTerlikDiv());

            } else {
                if ($this->footStatus == "tamam") {
                    self::setIstekdeBulun("ayakkabiistekButton", $this->dil['backend_bespoke_istekBulunAyakkabiButton'], $this->dil['backend_bespoke_istekBulunAyakkabiAciklama']);
                    self::setAyakkabiDiv(self::getIstekdeBulun());
                } else if ($this->footStatus == "closed") {
                    self::setUrunBekleniyor("ayakkabi", $this->dil['backend_bespoke_istekBulunAyakkabiUrunBekleniyorAciklama']);
                    self::setAyakkabiDiv(self::getUrunBekleniyor());
                } else if ($this->footStatus == "actived") {
                    $this->component->setGenelProduct($this->kullanilabilirUrunler, "Ayakkabı", $this->component->getFiltreler(), 0, 10);
                    self::setAyakkabiDiv($this->component->getGenelProduct());

                }
                self::setProField(self::getAyakkabiDiv());

            }
        }





        $this->smcomp->IN("", self::getProShowResult());
        self::setResult($this->smcomp->getIn() . self::getScript());
    }
//settergetter
    /**
     * Get the value of result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set the value of result
     *
     * @return  self
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of terlikStatus
     */
    public function getTerlikStatus()
    {
        return $this->terlikStatus;
    }

    /**
     * Set the value of terlikStatus
     *
     * @return  self
     */
    public function setTerlikStatus($terlikStatus)
    {
        $this->terlikStatus = $terlikStatus;

        return $this;
    }

    /**
     * Get the value of footStatus
     */
    public function getFootStatus()
    {
        return $this->footStatus;
    }

    /**
     * Set the value of footStatus
     *
     * @return  self
     */
    public function setFootStatus($footStatus)
    {
        $this->footStatus = $footStatus;

        return $this;
    }


    /**
     * Get the value of profilEksik
     */
    public function getProfilEksik()
    {
        return $this->profilEksik;
    }

    /**
     * Set the value of profilEksik
     *
     * @return  self
     */
    public function setProfilEksik($buttonText, $aciklama)
    {
        $in =null;
        $this->smcomp->setH(4, "profilEksikYazisi", "", $aciklama, "");
        $yazi = $this->smcomp->getH();
        $this->smcomp->setSmHref("profilEksik", $buttonText, "footsphere_profil");
        $button = $this->smcomp->getSmHref();
        $in = $in . $yazi . "<br>" . $button;

        $this->profilEksik = $in;

        return $this;
    }

    /**
     * Get the value of istekdeBulun
     */
    public function getIstekdeBulun()
    {
        return $this->istekdeBulun;
    }

    /**
     * Set the value of istekdeBulun
     *
     * @return  self
     */
    public function setIstekdeBulun($buttonID, $buttonText, $Aciklama)
    {
        $this->smcomp->setH(4, "istekdeBulunYazisi_" . $buttonID, "", $Aciklama, "");
        $yazi = $this->smcomp->getH();
        $this->smcomp->setSmButton($buttonID, $buttonText, "footsphere_profil");
        $button = $this->smcomp->getSmButton();
        $this->smcomp->setForm("", "", "POST", "", $button, "");
        $form = $this->smcomp->getForm();
        $message =null;
        $message = $message . $yazi . "<br>" . $form;

        $this->istekdeBulun = $message;

        return $this;
    }

    /**
     * Get the value of urunBekleniyor
     */
    public function getUrunBekleniyor()
    {
        return $this->urunBekleniyor;
    }

    /**
     * Set the value of urunBekleniyor
     *
     * @return  self
     */
    public function setUrunBekleniyor($urunTur, $aciklama)
    {
        $sure = $this->wpusermetaDB->getTimeUserID($this->wpusermetaDB->userID(), $urunTur);
        $message = $sure . " ".$aciklama;
        $this->urunBekleniyor = $message;

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
    public function setKullanilabilirUrunler($userID)
    {
        $result = $this->bespokeDB->getKullanilabilirUrunler($userID); // -1 giriş yapan kullanıcı idsi üzerinden 
        $this->kullanilabilirUrunler = explode(",", $result);
        return $this;
    }

    /**
     * Get the value of leftFilter
     */
    public function getLeftFilter()
    {
        return $this->leftFilter;
    }

    /**
     * Set the value of leftFilter
     *
     * @return  self
     */
    public function setLeftFilter($leftFilter)
    {
        $this->component->setDiv("leftFilterDiv", "col-sm-3", $leftFilter, "padding-left:2%;background-color:white ;", "");
        $leftFilter = $this->component->getDiv();
        $this->leftFilter = $leftFilter;
        return $this;
    }

    /**
     * Get the value of proField
     */
    public function getProField()
    {
        return $this->proField;
    }

    /**
     * Set the value of proField
     *
     * @return  self
     */
    public function setProField($proField)
    {
        $this->component->setDiv("productFieldDiv", "col-sm-12", $proField, "padding-left:2%", "");
        $proField = $this->component->getDiv();
        $this->proField = $proField;

        return $this;
    }

    /**
     * Get the value of ayakkabiDiv
     */
    public function getAyakkabiDiv()
    {
        return $this->ayakkabiDiv;
    }

    /**
     * Set the value of ayakkabiDiv
     *
     * @return  self
     */
    public function setAyakkabiDiv($ayakkabiDiv)
    {
        $this->component->setDiv("ayakkabiDiv", "", $ayakkabiDiv, "", "");
        $ayakkabiDiv = $this->component->getDiv();
        $this->ayakkabiDiv = $ayakkabiDiv;

        return $this;
    }

    /**
     * Get the value of terlikDiv
     */
    public function getTerlikDiv()
    {
        return $this->terlikDiv;
    }

    /**
     * Set the value of terlikDiv
     *
     * @return  self
     */
    public function setTerlikDiv($terlikDiv)
    {
        $this->component->setDiv("terlikDiv", "", $terlikDiv, "", "");
        $terlikDiv = $this->component->getDiv();
        $this->terlikDiv = $terlikDiv;

        return $this;
    }

    /**
     * Get the value of proShowResult
     */
    public function getProShowResult()
    {
        $this->component->setDiv("bosDiv", "col-sm-0", "", "", "");

        $this->component->setDiv(
            "",
            "col-sm-12",

            self::getLeftFilter() .   // sm 3 

            $this->component->getDiv() .          // sm 0

            self::getProField() . // sm 8

            $this->component->getDiv(),        // sm 1 ,
            "width: 100%; display: flex; flex-direction: row;",
            ""
        );

        $this->proShowResult = $this->component->getDiv();
        return $this->proShowResult;
    }

    /**
     * Set the value of proShowResult
     *
     * @return  self
     */
    public function setProShowResult($proShowResult)
    {
        //$this->component->setDiv("","col-sm-12",$proShowResult,"width: 100%; display: flex; flex-direction: row;","");
        $proShowResult = $this->component->getDiv();
        $this->proShowResult = $proShowResult;
        return $this;
    }
//settergetter    

   

    /**
     * Get the value of script
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Set the value of script
     *
     * @return  self
     */
    public function setScript($script, $kind)
    {
        $sn = $_SERVER['SERVER_NAME'];
        if ($kind == "js") {
            $script =
                '
            <script type="text/javascript" 
            src="http://' . $sn . '/wp-content/plugins/footsphere/assets/js/' . $script . '.js' . '"></script>
            ';;
        } else {
            $script =
                '
            
            <link rel="stylesheet" id=' . $script . '
            href="http://' . $sn . '/wp-content/plugins/footsphere/assets/css/' . $script . '.css' . '"

            type="text/css" media="all">
            ';;
        }
        $this->script = $this->script . $script;

        return $this;
    }
}






?>



