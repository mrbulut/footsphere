<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/page.php");


class userpage extends page
{
    private $user;
    private $result;

    private $bilgi;
    private $ayakFoto;
    private $fsBilgi;
    private $dil;
    private $yas, $userText, $boy, $kilo, $ayakolcu, $eksbilgi, $eksDosya, $eksDosyaYok;

    function __construct($userID = 0)
    {


        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();
        $this->yas = $this->dil ['backend_profil_yasText'];
        $this->boy = $this->dil ['backend_profil_boyText'];
        $this->kilo = $this->dil ['backend_profil_kiloText'];
        $this->ayakolcu = $this->dil ['backend_profil_aOlcuText'];
        $this->eksbilgi = $this->dil ['backend_profil_exBilgiText'];
        $this->eksDosya = $this->dil ['backend_profil_ekstraDosyaBaslik'];
        $this->eksDosyaYok = $this->dil ['smcomp_yuklenmisDosyalarYok'];
        $this->userText = $this->dil ['kullanici'];

        self::addjscode('bootstrap.min');
        self::addcsscode('bootstrap.min');
        self::addjscode('openPhoto');
        self::addcsscode('openPhoto');
        $this->user = new user($userID);
        $this->user->wp_bespoke_info(false);
        $this->user->wp_user_info();
    }

    public function setup($gizlilik = false,$acilirpencere='')
    {
        self::setBilgi();
        self::setAyakFoto();
        self::setFsBilgi();
        self::setPage($gizlilik,$acilirpencere);
    }

    public function setPage($gizlilik)
    {
        if ($gizlilik) {
            self::setBaslik($this->userText);
        } else {
            self::setBaslik($this->user->getUser_displayname());
        }
        self::setDiv("userBilgiDiv", "col-sm-3", self::getBilgi(), "", "");
        $div3_1 = self::getDiv();
        self::setDiv("userAyakFotoDiv", "col-sm-3", "<br>" . self::getAyakFoto(), "", "");
        $div3_2 = self::getDiv();
        self::setDiv("fsBilgiDiv", "col-sm-6", "<br>" . self::getFsBilgi(), "", "");
        $div6_1 = self::getDiv();
        self::setDiv("anaDiv", "col-sm-12", $div3_1 . $div3_2 . $div6_1, "", "");
        $anaDiv = self::getDiv();


        self::setResult($anaDiv);
    }

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
        //self::setRows($result);
        $this->result = $result;

        return $this;
    }

    /**
     * Get the value of fsBilgi
     */
    public function getFsBilgi()
    {
        return $this->fsBilgi;
    }

    /**
     * Set the value of fsBilgi
     *
     * @return  self
     */
    public function setFsBilgi()
    {
        $result = '';
        $link = $this->user->getFootsphereDosyaYolu();
        self::setDiv("", "", self::getImageElement("http://" . $_SERVER['SERVER_NAME'] . $link, 800, ""), "", "");
        $result = $result . self::getDiv();
        $this->fsBilgi = $result;

        return $this;
    }

    /**
     * Get the value of ayakFoto
     */
    public function getAyakFoto()
    {
        return $this->ayakFoto;
    }

    /**
     * Set the value of ayakFoto
     *
     * @return  self
     */
    public function setAyakFoto()
    {

        $result;

        $array = explode("+-+", $this->user->getAyakFotolari());
        if (count($array) > 0) {
            for ($i = 1; $i < count($array); $i++) {
                $name = explode("/", $array[$i])[5];
                $link = "http://" . $_SERVER['SERVER_NAME'] . $array[$i];
                self::setDiv("", "demo-image", self::getImageElement($link, 300, ""), "", 'data-image="' . $link . '"');
                $result = $result . self::getDiv();
            }
        }

        $result = $result . '
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        ';
        $this->ayakFoto = $result . "<script> window.onload = function() {
            var elements = document.querySelectorAll( '.demo-image' );
            Intense( elements );
            }</script>
            
            ";


        return $this;
    }

    /**
     * Get the value of bilgi
     */
    public function getBilgi()
    {
        return $this->bilgi;
    }

    /**
     * Set the value of bilgi
     *
     * @return  self
     */
    public function setBilgi()
    {
        $result = '';

        self::setLabelEx("oldLabel", "", $this->yas, "");
        $label = self::getLabelEx();
        $result = $result . $label . self::getInputtext("oldInput", "", $this->user->getYas(), true);

        self::setLabelEx("longLabel", "", $this->boy, "");
        $label = self::getLabelEx();
        $result = $result . $label . self::getInputtext("longInput", "", $this->user->getBoyu(), true);

        self::setLabelEx("weightLabel", "", $this->kilo, "");
        $label = self::getLabelEx();
        $result = $result . $label . self::getInputtext("weightInput", "", $this->user->getKilosu(), true);

        self::setLabelEx("olcuLabel", "", $this->ayakolcu, "");
        $label = self::getLabelEx();
        $result = $result . $label . self::getInputtext("olcuInput", "", $this->user->getAyakOlcusu(), true);

        self::setLabelEx("ekstraBilgi", "", $this->eksbilgi, "");
        $label = self::getLabelEx();
        $result = $result . $label . self::getTextarea("ekstraBilgiArea", $this->user->getEkstraBilgi(), 40, true);

        // Ekstra dosyalar
        $array = explode("+-+", $this->user->getEkstraDosyaYolu());
        $eksDosyalar;
        if (count($array) > 0) {
            for ($i = 1; $i < count($array); $i++) {
                $name = explode("/", $array[$i])[5];
                $link = $_SERVER['SERVER_NAME'] . $array[$i];
                self::setA("", $link, "", $name . "<br>", "");
                $eksDosyalar = $eksDosyalar . self::getA();
            }
        } else {
            self::setA("", "", "", $this->eksDosyaYok . "<br>", "");
            $eksDosyalar = self::getA();

        }

        self::setLabelEx("ekstraDosya", "", $this->eksDosya, "");
        $label = self::getLabelEx();
        $result = $result . $label . $eksDosyalar;
        // Ekstra Dosyalar

        $this->bilgi = $result;

        return $this;
    }
}

?>