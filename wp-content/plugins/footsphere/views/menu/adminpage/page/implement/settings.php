<?php
//require_once (ABSPATH ."wp-content/plugins/footsphere/database/bespokeDB.php");

//$db = new bespokeDB();
//echo $db->getBoyu();
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/optionsDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/settingpage.php");

class settingspage
{
    private $component;
    private $user;
    private $array;
    private $stpage;
    private $result,$dil;
    public function __construct()
    {
        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();

        $id = "profilGuncelle";
        $name =  $this->dil['backend_profil_gonderButtonText'];
        $baslik = $this->dil['menu_editor_ayarlar'];
        $js = null;
        $css = null;
        $this->stpage = new settingpage($id, $name, $baslik, $js, $css);
   

        $settings = new optionsDB();

        if (isset($_POST['profilGuncelle'])) {
            $arrayValue = array(
                $_POST['komisyonArea'],
                $_POST['requestTimeArea'],
                $_POST['producerModelLimit'],
                $_POST['producerRequestLimit']
            );
            $settings->setAllSettings($arrayValue);
        }





        $array = array(
            array(
                "type" => "label",
                "id" => "profilBaslikLabel",
                "name" =>  $this->dil['menu_producer_profil'],
                "size" => 2
            ),
            array(
                "type" => "text",
                "id" => "komisyonArea",
                "name" =>  $this->dil['komisyonOraniBaslik'],
                "desc" =>  $this->dil['komisyonOraniAciklama'],
                "disabled" => false,
                "value" => $settings->getKomisyonArea(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "requestTimeArea",
                "name" => $this->dil['istekSuresiAyarBaslik'],
                "desc" =>  $this->dil['istekSuresiAyarAciklama'],
                "disabled" => false,
                "value" => $settings->getRequestTimeArea(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "producerModelLimit",
                "name" =>$this->dil['ureticiUrunLimitBaslik'],
                "desc" =>  $this->dil['ureticiUrunLimitAciklama'],
                "disabled" => false,
                "value" => $settings->getProducerModelLimit(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "producerRequestLimit",
                "name" =>$this->dil['ureticiTeklifSiniriBaslik'],
                "desc" =>  $this->dil['ureticiTeklifSiniriAciklama'],
                "disabled" => false,
                "value" => $settings->getProducerRequestLimit(),
                "arrayValue" => ""
            )
        );



        self::setArray($array);




    }

    public function setupPage()
    {
        $this->stpage->setRows($this->array);
    }

    /**
     * Get the value of array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * Set the value of array
     *
     * @return  self
     */
    public function setArray($array)
    {
        $this->array = $array;

        return $this;
    }

    /**
     * Get the value of result
     */
    public function getResult()
    {
        return $this->stpage->getResultPage();
    }

}






?>