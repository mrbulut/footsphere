<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/settingpage.php");

class profilpage
{
    private $component;
    private $user;

    private $array;

    private $stpage;

    private $result;
    private $dil;
    public function __construct()
    {
        require_once(ABSPATH . "/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();
        $id = "profilGuncelle";
        $name = $this->dil['backend_profil_gonderButtonText'];
        $baslik = $this->dil['menu_editor_ayarlar'];
        $js = null;
        $css = null;
        $this->stpage = new settingpage($id, $name, $baslik, $js, $css);
        $this->user = new user();
        $this->user->wp_bespoke_info();
        $this->user->wp_producer_info();


        if (isset($_POST['profilGuncelle'])) {
            $this->user->wp_user_update(
                $_POST['displayName'],
                $_POST['userEmail'],
                $_POST['userPassword']
            );

            $this->user->wp_producer_update(
                $_POST['displayName'],
                $_POST['sirketAdi'],
                $_POST['telefon'],
                $_POST['telefon2'],
                $_POST['userEmail'],
                $_POST['adresi'],
                $_POST['odemeBilgi'],
                $_POST['kargoBilgi'],
                $_POST['maxmin']
            );
        }

        $array = array(
            array(
                "type" => "label",
                "id" => "profilBaslikLabel",
                "name" => $this->dil['menu_producer_profil'],
                "size" => 2
            ),
            array(
                "type" => "text",
                "id" => "kullaniciAdi",
                "name" => $this->dil['kullaniciAdi'],
                "desc" => $this->dil['kullaniciAdiDegismezYazisi'],
                "disabled" => true,
                "value" => $this->user->getUser_login(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "displayName",
                "name" => $this->dil['backend_profil_kAdiText'],
                "desc" => "",
                "disabled" => false,
                "value" => $this->user->getUser_displayname(),
                "arrayValue" => ""
            ),
            array(
                "type" => "email",
                "id" => "userEmail",
                "name" => $this->dil['eposta'],
                "desc" => "",
                "disabled" => false,
                "value" => $this->user->getUser_email(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "userPassword",
                "name" => $this->dil['yenisifre'],
                "desc" => $this->dil['yenisifreAciklama'],
                "disabled" => false,
                "value" => "",
                "arrayValue" => ""
            ),
            array(
                "type" => "label",
                "id" => "bilgilerBaslikLabel",
                "name" => $this->dil['bilgiler'],
                "size" => 2
            ),
            array(
                "type" => "text",
                "id" => "maxmin",
                "name" => $this->dil['maxminBaslik'],
                "desc" => "",
                "disabled" => true,
                "value" => $this->user->getTeklifLimit(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "sirketAdi",
                "name" => $this->dil['sirketAdi'],
                "desc" => "",
                "disabled" => false,
                "value" => $this->user->getSirketAdi(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "telefon",
                "name" => $this->dil['tel'],
                "desc" => "",
                "disabled" => false,
                "value" => $this->user->getTelefon(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "telefon2",
                "name" => $this->dil['tel']."2",
                "desc" => "",
                "disabled" => false,
                "value" => $this->user->getTelefon2(),
                "arrayValue" => ""
            ),
            array(
                "type" => "text",
                "id" => "adresi",
                "name" => $this->dil['adres'],
                "desc" => "",
                "disabled" => false,
                "value" => $this->user->getAdres(),
                "arrayValue" => ""
            ),
            array(
                "type" => "textarea",
                "id" => "odemeBilgi",
                "name" => $this->dil['odemeBilgi'],
                "desc" => $this->dil['odemeBilgiAciklama'],
                "disabled" => false,
                "value" => $this->user->getOdemebilgi(),
                "arrayValue" => ""
            ),
            array(
                "type" => "textarea",
                "id" => "kargoBilgi",
                "name" => $this->dil['kargoBilgi'],
                "desc" =>$this->dil['kargoBilgiAciklama'],
                "disabled" => false,
                "value" => $this->user->getKargobilgi(),
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