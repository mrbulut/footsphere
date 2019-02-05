<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/page.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");

class tablepage extends page
{
    private $page;
    private $table;
    private $popupwindow;
    private $popupmenu;
    private $component;
    private $result;
    private $form;

    public function __construct($js = null, $css = null)
    {

        if ($js) {
            self::addjscode($js);
        }
        if ($css) {
            self::addcsscode($css);
        }

        //new page($js,$css);

    }



    public function getTable()
    {
        return $this->table;
    }

    public function createTable(
        $arrayHead,
        $inArray,
        $jsCode,
        $resimVar = true,
        $yaziVar = false,
        $click = false,
        $delete = false,
        $change = false,
        $isProduct
    ) {
        $this->component = new component();
        $this->component->setTable(
            $arrayHead,
            $inArray,
            $jsCode,
            $resimVar,
            $yaziVar,
            $click,
            $delete,
            $change,
            $isProduct
        );
        $this->table = $this->component->getTable();
        self::setFooter($this->table);
        self::setJsCode($this->component->getTableJsCode());
    }

    public function getPopupwindow()
    {
        return $this->popupwindow;
    }

    public function setPopupwindow($name, $array='')
    {
        $this->component = new component();
        if($array){
            $this->component->setPopupwindow($name, $array);

        }else{
            $this->component->setProductFeatures();
            $this->component->setPopupwindow($name, $this->component->getProductFeatures());
        }
        $this->popupwindow = $this->component->getPopupwindow();
        self::setHeader($this->popupwindow);
        
    }

    public function getPopupmenu()
    {
        return $this->popupmenu;
    }


    public function setPopupmenu(
        $id,
        $name,
        $desc,
        $listid,
        $key,
        $value,
        $buttonEnabled = true,
        $bosYazi,
        $buttonText
    ) {
        $this->component = new component();
        $this->popupmenu = $this->component->getpopupList(
            $id,
            $name,
            $desc,
            $listid,
            $key,
            $value,
            $buttonEnabled,
            $bosYazi,
            $buttonText
        );

        $this->component->setForm("","","POST","",$this->popupmenu,"");

        self::setRows($this->component->getForm());
    }


    public function getResultTable()
    {
        $this->result = self::getHeader() . self::getRows() . self::getFooter();
        return $this->result;
    }


    public function setResultTable($result)
    {
        $this->result = $result;

        return $this;
    }

    public function createForm($buttonID, $buttonText, $producerID, $userID, $requestID, $change, $type)
    {

        self::setButtonEx($buttonID, "button button-primary", "submit", $buttonText, "", "");
        $button = self::getButtonEx();
        $button = $button .
            '
        <input type="hidden" id="hiddenUserID" name="hiddenUserID" value="' . $userID . '">
        <input type="hidden" id="hiddenProducerNo" name="hiddenProducerNo" value="' . $producerID . '">
        <input type="hidden" id="hiddenChange" name="hiddenChange" value="' . $change . '">
        <input type="hidden" id="requestID" name="requestID" value="' . $requestID . '">
        <input type="hidden" id="hiddenType" name="hiddenType" value="' . $type . '">

        
        ';

        Element::setForm("sadas", "", "POST", "/wp-admin/admin.php?page=teklifver", $button, "");

        $this->form = Element::getForm();

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }
}


?>