<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/footsphere/classes/component.php");
/*
 $popupwindow = new popupwindow("Ürün Ekle");
    $popupwindow->setRows("inputtext", "urunAdi", "Ürün başlığı");
    $popupwindow->setRows("textarea", "urunAciklamasi", "Ürün Açıklaması", 50);
    $popupwindow->setRows("popupmenu", "ureticiSec", "Üretici seç", array("asd", "asdsa"));
    $popupwindow->setRows("file", "uploadFile", "Ürünün görselini Ekleyin.");
 */
class popupwindow
{
    private $first;
    private $last;
    private $onclick;
    private $result;
    private $jsCode;
    private $name;
    private $component;

    function __construct($name)
    {  
        wp_enqueue_script('popupwindow'); //CSS VE JS Dosyalari aktifleşitiriyor.


        $this->name = "- " . $name;

        $this->component = new component();

        $this->first = '

        <br><br>
        <div id="postbox-container-1" class="postbox-container">
        <div id="side-sortables" class="meta-box-sortables ui-sortable">
        
    <div  id="dashboard_quick_press" class="postbox closed">
    <button  type="button" onclick="downFunc()" class="handlediv" aria-expanded="true">
    <span class="screen-reader-text">Paneli aç/kapa: <span class="hide-if-no-js">' . $this->name . '</span> <span class="hide-if-js">' . $this->name . '</span></span><span class="toggle-indicator" aria-hidden="true"></span></button>
    <h2 onclick="downFunc()" class="hndle ui-sortable-handle"><span><span class="hide-if-no-js">' . $this->name . '</span> <span class="hide-if-js">' . $this->name . '</span></span></h2>
    <div class="inside">
    
        <form name="uploadfile" id="uploadfile_form" method="POST" enctype="multipart/form-data" action="" accept-charset="utf-8" class="initial-form hide-if-no-js">
            
  
        ';

        $this->last = '
      


        </form>
        </div>
        </div>
        </div>
        </div>
        </div>

        ';

    }
    public function setRowsAll($array){
        for ($i=0; $i < count($array) ; $i++) { 
            self::setRows(
                $array[$i]['type'], 
                $array[$i]['id'], 
                $array[$i]['name'], 
                $array[$i]['exs'], 
                $array[$i]['key'], 
                $array[$i]['value'], 
                $array[$i]['button']
            );
        }
    }

    public function setRows($type, $id, $name, $exs = null, $key = '', $value = '', $button = false)
    {
        $result = '';

        if ($type == "inputtext") {
            $result = $this->component->getInputtext($id, $name);
        } else if ($type == "textarea") {
            $result = $this->component->getTextarea($id, $name, $exs);
        } else if ($type == "text") {
            $result = $this->component->getLabel($id, $name, $exs);
        } else if ($type == "file") {
            $result = $this->component->getFile($id, $name) . "<br>";
        } else if ($type == "popupmenu") {
            $result = $this->component->getpopupList(
                $id,
                $name,
                "",
                $exs,
                $key,
                $value,
                $button,
                "",
                ""
            );

        } else if ($type == "button") {
            $result = "<br>" . $this->component->getButton($id, $name, "", "") . "<br>";
        }



        self::setResult($result);

    }

    public function JSCODE()
    {
        return '
        


        ';
    }

    /**
     * Get the value of result
     */
    public function getResult()
    {
        return self::JSCODE() .
            $this->first .
            $this->result .
            $this->last;
    }

    /**
     * Set the value of result
     *
     * @return  self
     */
    public function setResult($result)
    {
        $this->result = $this->result . $result;
        return $this;
    }
}


?>