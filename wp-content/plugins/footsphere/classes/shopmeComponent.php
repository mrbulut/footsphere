<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");

class smComponent extends component
{
    private $SMheader;
    private $in;
    private $scrollbar;
    private $textarea;
    private $extUploadFile;

    private $smButton;
    private $smHref;
    private $dil;

    function __construct()
    {

        require_once(ABSPATH . "/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();

        $array = array(
            'profil' => $this->dil['frontend_profil'],
            'bespoke' => $this->dil['frontend_bespoke'],
            'contact' => $this->dil['frontend_contact'],
            'return' => $this->dil['frontend_return']
        );
        self::SMheader($array);
    }

    public function getSMheader()
    {
        return $this->SMheader;
    }


    public function SMheader($arrayValue)
    {
        $result = '';
        $sn = explode("/", $_SERVER['REQUEST_URI']);

        foreach ($arrayValue as $key => $value) {


            if ($sn[1] == "footsphere_" . $key) {
                self::setA("navlink_" . $key, $_SERVER['SERVER_NAME'] . "/footsphere_" . $key, "btn btn-warning btn-lg", $value, "");

            } else {
                self::setA("navlink_" . $key, $_SERVER['SERVER_NAME'] . "/footsphere_" . $key, "btn btn-secondary btn-lg", $value, "");

            }
            $a = self::getA();
            //self::setLi("", "", $a, "", "");
            // $li = self::getLi();
            $result = $result . $a;
        }
        self::setUl("", "btn-group btn-group-lg", $result, "");
        $ul = self::getUl();
        self::setNav("", "", $ul, "");
        $nav = self::getNav();
        $this->SMheader = $nav . "<br>";
        return $this;
    }


    public function IN($first, $second)
    {
        self::setDiv("", "container", $first, "", "");
        $div = self::getDiv();
        self::setDiv("", "col-sm-12", $div, "", "");
        $div = self::getDiv();


        self::setDiv("", "", $second, "", "");
        $div2 = self::getDiv();
        self::setDiv("", "", $div2, "", "");
        $div2 = self::getDiv();
        self::setDiv("", "", $div2, "", "");
        $div2 = self::getDiv();

        self::setDiv("", "", $div . $div2, "", "");
        $div = self::getDiv();
        self::setDiv("", "", $div, "", "");
        $div = self::getDiv();

        self::setSection("", "", self::getSMheader() . $div, "");
        $section = self::getSection();
        self::setDiv("", "", $section, "", 'data-spy="scrool" data-target="#navigation"');
        $div = self::getDiv();
        self::setIn($div);


    }

    /**
     * Get the value of in
     */
    public function getIn()
    {
        return $this->in;
    }

    /**
     * Set the value of in
     *
     * @return  self
     */
    public function setIn($in)
    {
        $this->in = $in;

        return $this;
    }

    /**
     * Get the value of scrollbar
     */
    public function getScrollbar()
    {
        return $this->scrollbar;
    }

    /**
     * Set the value of scrollbar
     *
     * @return  self
     */
    public function setScrollbar($id, $inid, $in)
    {
        self::setDiv($inid, "", $in, "position: absolute; bottom:0; overflow: auto; max-height: 450px; width: 100%;", "");
        $div = self::getDiv();
        self::setDiv("", "", $div, "overflow: none; width: 100%;  height: 450px; position: relative;", "");
        $div = self::getDiv();
        self::setDiv("", "wpb_wrapper", $div . '<script>
$(document).ready(function(){
            var objDiv = document.getElementById(' . $indi . '); 
    objDiv.scrollTop = objDiv.scrollHeight;
    });
    
    </script>', "", "");
        $div = self::getDiv();
        self::setDiv("", "vc_column-inner", $div, "", "");
        $div = self::getDiv();

        self::setDiv("", "wpb_column vc_column_container vc_col-sm-12", $div, "", "");
        $div = self::getDiv();

        // self::setDiv($id, "vc_row wpb_row vc_row-fluid", $div, "", "");
        //$div = self::getDiv();
        $this->scrollbar = $div;
        return $this;
    }

    /**
     * Get the value of extUploadFile
     */
    public function getExtUploadFile()
    {
        return $this->extUploadFile;
    }

    /**
     * Set the value of extUploadFile
     *
     * @return  self
     */
    public function setExtUploadFile($array)
    {
        $result = null ;
        self::setH(3, "yukluDosyalarBaaslik", "", $this->dil['smcomp_yuklenmisDosyalarBaslik'], "");
        $result = $result . self::getH();
        if (count($array) > 0) {
            foreach ($array as $name => $link) {
                if ($link != "" || $link != null) {
                    $id = preg_replace('/[^a-zA-Z0-9]/s', '', $name);
                    self::deleteEksFile($id, $link);
                    self::setButtonEx($id, "", "submit", self::getImageElement("/wp-content/plugins/footsphere/assets/images/delete.png", 24, ""), "");
                    $button = self::getButtonEx();
                    self::setDiv("", "", $name . $button, "display: block; padding:10px;", "");
                    $div = self::getDiv() . "<br>";
                    $result = $result . $div;
                }
            }
        } else {
            self::setH(2, "yuklenmemisYazisi", "", $this->dil['smcomp_yuklenmisDosyalarYok'], "");
            $result = $result . self::getH();
        }

        $this->extUploadFile = $result;

        return $this;
    }

    public function deleteEksFile($id, $value)
    {
        if (isset($_POST[$id])) {
            $db = new bespokeDB();
            $db->dosyaSil($value);
            wp_delete_attachment($id);
        }

    }

    public function getSmHref()
    {
        return $this->smHref;
    }

    public function setSmHref($id, $name, $href)
    {
        self::setA($id, $href, "", $name, "");
        $this->smHref = self::getA();
        return $this;
    }

    public function getSmButton()
    {
        return $this->smButton;
    }

    public function setSmButton($id, $name)
    {
        self::setButtonEx($id, "", "submit", $name, "", "");
        $this->smButton = self::getButtonEx();
        return $this;
    }
}


?>
