<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/footsphere/lib/Cookie.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/footsphere/classes/element.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/footsphere/classes/table.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/footsphere/classes/popupwindow.php");

class component extends Element
{
    private $label;
    private $inputtext;
    private $file;
    private $textarea;
    private $fileName;
    private $Element;
    private $filedest;
    private $tableContext;
    private $popupwindow;
    private $tableJsCodeContext;
    private $productFeatures;
    private $acilirPencere;
    private $radioButtonGroup;
    private $checkBoxGroup;

    private $urunBasligiText;
    private $urunAciklamasiText;
    private $turuText;
    private $tabanMalzemeText;
    private $kapanisTuru;
    private $astarMalzemesi;
    private $ustMalzeme;
    private $sezon;
    private $icTabanturu;
    private $icTabanMalzemesi;
    private $urungorsel1;
    private $urungorsel2;
    private $urungorsel3;
    private $buttonText;

    private $turuArray;
    private $tabanMalzemeArray;
    private $kapanisTuruArray;
    private $ustMalzemeArray;
    private $astarMalzemesiArray;
    private $sezonArray;
    private $icTabanturuArray;
    private $icTabanMalzemesiArray;

    private $body;
    private $filtreler;
    private $urunler;
    private $proList;
    private $popupMenu;
    private $geciciDegisken;
    // bootstrap
    private $collapsibles;
    private $slayderImage;
    private $product;
    private $genelProduct;
    //
    private $dil;
    private $lang;
    function __construct()
    {

        require_once(ABSPATH . "/wp-content/plugins/footsphere/languages/languages.php");
        $this->lang = new languages(0);
        $this->dil = $this->lang->getDil();

        self::setupText();
    }



    public function setupText()
    {

        
       // echo $lang->getDil()['backend_comp_urunBasligiText'];
        $this->urunBasligiText = $this->dil['backend_comp_urunBasligiText'];
        $this->urunAciklamasiText = $this->dil['backend_comp_urunAciklamasiText'];
        $this->turuText = $this->dil['backend_comp_turuText'];
        $this->tabanMalzemeText = $this->dil['backend_comp_tabanMalzemeText'];
        $this->kapanisTuru = $this->dil['backend_comp_kapanisTuru'];
        $this->astarMalzemesi = $this->dil['backend_comp_astarMalzemesi'];
        $this->ustMalzeme = $this->dil['backend_comp_ustMalzeme'];
        $this->sezon = $this->dil['backend_comp_sezon'];
        $this->icTabanturu = $this->dil['backend_comp_icTabanturu'];
        $this->icTabanMalzemesi = $this->dil['backend_comp_icTabanMalzemesi'];
        $this->urungorsel1 = "1" . $this->dil['backend_comp_urungorselAciklama'];
        $this->urungorsel2 = "2" . $this->dil['backend_comp_urungorselAciklama'];
        $this->urungorsel3 = "3" . $this->dil['backend_comp_urungorselAciklama'];
        $this->buttonText = $this->dil['backend_comp_UrunEklebuttonText'];

        $this->turuArray =
            array(
            array("id" => "Ayakkabı", "value" => "Ayakkabı", "name" => $this->dil['ayakkabi']),
            array("id" => "Terlik", "value" => "Terlik", "name" => $this->dil['terlik'])
        );
        $this->tabanMalzemeArray =
            array(
            array("id" => "Kaçuçuk", "value" => "Kaçuçuk", "name" => $this->dil['kaucuk']),
            array("id" => "PU", "value" => "PU", "name" => $this->dil['PU']),
            array("id" => "Termo", "value" => "Termo", "name" => $this->dil['termo'])
        );
        $this->kapanisTuruArray =
            array(
            array("id" => "Geçme", "value" => "Geçme", "name" => $this->dil['gecme']),
            array("id" => "Cırtlı", "value" => "Cırtlı", "name" => $this->dil['cirtcirtli']),
            array("id" => "Bağcıklı", "value" => "Bağcıklı", "name" => $this->dil['bagcikli'])
        );
        $this->ustMalzemeArray =
            array(
            array("id" => "Deri", "value" => "Deri", "name" => $this->dil['deri']),
            array("id" => "Suni Deri", "value" => "Suni Deri", "name" => $this->dil['sunideri']),
            array("id" => "Kumaş", "value" => "Kumaş", "name" => $this->dil['kumas'])
        );
        $this->astarMalzemesiArray =
            array(
            array("id" => "Deri", "value" => "Deri", "name" => $this->dil['deri']),
            array("id" => "Suni Deri", "value" => "Suni Deri", "name" => $this->dil['sunideri']),
            array("id" => "Kumaş", "value" => "Kumaş", "name" => $this->dil['kumas'])
        );
        $this->sezonArray =
            array(
            array("id" => "İlk bahar", "value" => "İlk bahar", "name" => $this->dil['ilkbahar']),
            array("id" => "Son bahar", "value" => "Son bahar", "name" => $this->dil['sonbahar']),
            array("id" => "Yaz", "value" => "Yaz", "name" => $this->dil['yaz']),
            array("id" => "Kış", "value" => "Kış", "name" => $this->dil['kis'])
        );
        $this->icTabanturuArray =
            array(
            array("id" => "Sabit", "value" => "Sabit", "name" => $this->dil['sabit']),
            array("id" => "Değiştirilebilir", "value" => "Değiştirilebilir", "name" => $this->dil['degistirilebilir'])
        );
        $this->icTabanMalzemesiArray =
            array(
            array("id" => "Deri", "value" => "Deri", "name" => $this->dil['deri']),
            array("id" => "Sünger", "value" => "Sünger", "name" => $this->dil['sunger']),
            array("id" => "Hafızalı Sünger", "value" => "Hafızalı Sünger", "name" => $this->dil['hafizalisunger'])
        );

    }



    /**
     * Get the value of label
     */
    public function getButton($id, $name, $goPage = '', $data)
    {
        //$id = '',$class = '',$type='',$placeHolder='',$value='', $disabled=false, $style = '',$ext)

        self::setInput($id, "button button-primary", "submit", $name, "", false, "", "");
        $button = self::getInput();
        self::setInput("hiddenValueOpen", "", "hidden", $data, "", false, "", "");
        $hidden = self::getInput();
        self::setForm($id, "", "POST", "admin.php?page=" . $goPage, $button . $hidden, "");
        $form = self::getForm();
        if ($goPage == '') {
            return $button;
        } else {
            return $form;
        }

    }

    public function getHref($id, $link, $name)
    {
        self::setA($id, $link, "", $name);
        $a = self::getA();
        return $a;
    }


    public function getLabel($id, $name, $buyukluk = 5)
    {
        self::setH($buyukluk, $id, "prompt", $name, "", "");
        $h = self::getH();
        self::setTh("", "", "", "", $h, "");
        $th = self::getTh();
        self::setTr("", "", $th, "");
        $tr = self::getTr();
        self::setDiv($id . "_div", "input-text-wrap", $tr, "", "");
        $div = self::getDiv();
        return $div;
    }


    public function getProPopupMenu($id, $name, $arrayValue, $des, $buttonEnabled = false, $value)
    {
        $result;
        self::setP($id . "_dsec", "description", $desc, "");
        $p = self::getP();

        $option = '   <option value="-1" selected="selected"></option>';
        foreach ($arrayValue as $key => $val) {
            self::setOption("", "", $val, $key);
            $option = $option . self::getOption();
        }
        self::setSelect($id, "", $option, "");
        $sec = self::getSelect();
        self::setLabelEx($id, "prompt", $name, "", "");
        $label = Element::getLabelEx();


        self::setInput($id, "button button-primary", "submit", $value, "", false, "", "");
        $button = self::getInput();

        $result = $div . "<br";

        if ($buttonEnabled) {
            self::setDiv("description-wrap", "textarea-wrap", $label . $sec . $p . $button, "", "");
        } else {
            self::setDiv("description-wrap", "textarea-wrap", $label . $sec . $p, "", "");

        }
        return self::getDiv();
    }



    public function getImageElement($link, $genislik, $yazi = '')
    {
        self::setImg("", "", $link, $genislik, $genislik, $yazi, "", "");
        return self::getImg();
    }


    public function getInputtext($id, $name, $value = '', $change = false)
    {
        self::setInput($id, "", "text", $value, "", $change, "", "");
        $input = self::getInput();
        self::setLabelEx($id . "_label", "prompt", $name, "");
        $label = self::getLabelEx();
        self::setDiv($id . "_div", "input-text-wrap", $label . "<br>" . $input, "", "");
        $div = self::getDiv();
        return $div . "<br>";
    }

    public function getInputtextPro($id, $type = 'text', $name, $description = '', $change = false, $value = "")
    {
        self::setP($id . "_dsec", "description", $description, "");
        $p = self::getP();
        self::setLabelEx($id . "_label", "prompt", $name, "");
        $label = self::getLabelEx();
        if ($change) {
            self::setInput($id, "regular-text ltr", $type, $value, "", true, "", "");
        } else {
            self::setInput($id, "regular-text ltr", $type, $value, "", false, "", "");
        }
        $input = self::getInput() . "";
        self::setTd("", "", $input . $p, "");
        $td = self::getTd();
        self::setTh("", "", "", "", $label, "");
        $th = self::getTh();
        self::setTr("", "", $th . $td, "");
        $tr = self::getTr();

        return $tr . "";

    }



    public function getProCheckbox($id, $name, $desc)
    {

        self::setInput($id, "regular-text ltr", "checkbox", "", 0, false, "", "");
        $input = self::getInput();
        self::setLabelEx($id . "_label", "prompt", $input . $desc, "");
        $label = self::getLabelEx();
        self::setFieldset($id . "_fieldset", "screen-reader-text", $label, "");
        $fieldset = self::getFiledest();
        self::setTd("", "", $fieldset, "");
        $td = self::getTd();
        self::setTh("", "", "", "", $name, "");
        $th = self::getTh();
        self::setTr("", "", $th . $td, "");
        $tr = self::getTr();
        return $tr;
    }





    /**
     * Get the value of file
     */
    public function getFile($id, $name)
    {
        self::setInput($id, "uploadfiles", "file", "", 0, false, "", 'size="35"');
        $file = self::getInput() . "<br";

        self::setLabelEx($id . "_label", "prompt", $name, "");
        $label = self::getLabelEx() . "<br>";

        self::setDiv($id . "_div", "input-text-wrap", $label . $file, "", "");
        $div = self::getDiv();


        self::fileupload_processing($id);

        return $div;

    }

    /**
     * Get the value of textarea
     */
    public function getTextarea($id, $name, $genislik = 20, $change = false, $value = '')
    {
        $extra = ' rows="4" cols="' . $genislik . '"';

        self::setTextareaEx($id . "_area", "mceEditor", $value, "", $change, "", $extra);


        $input = self::getTextareaEx();
        self::setLabelEx($id . "_label", "prompt", $name, "");
        $label = self::getLabelEx();
        self::setDiv($id, "input-text-wrap", $label . "<br>" . $input, "", "");
        $div = self::getDiv();
        return $div;
    }

    public function fileupload_processing($id)
    {
        $uploadfiles = $_FILES[$id];

        if (is_array($uploadfiles)) {

           // foreach ($uploadfiles['name'] as $key => $value) {
   
        // look only for uploded files
            if ($uploadfiles['error'] == 0) {

                $filetmp = $uploadfiles['tmp_name'];
  
          //clean filename and extract extension
                $filename = $uploadfiles['name'];
  
          // get file info
          // @fixme: wp checks the file extension....
                $filetype = wp_check_filetype(basename($filename), null);
                $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));
                $filename = $filetitle . '.' . $filetype['ext'];
                $upload_dir = wp_upload_dir();

                /**
                 * Check if the filename already exist in the directory and rename the
                 * file if necessary
                 */
                $i = 0;
                while (file_exists($upload_dir['path'] . '/' . $filename)) {
                    $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
                    $i++;
                }

                $filedest = $upload_dir['path'] . '/' . $filename;


                /**
                 * Check write permissions
                 */
                if (!is_writeable($upload_dir['path'])) {
                      //  $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
                    return;
                }

                /**
                 * Save temporary file to uploads dir
                 */
                if (!@move_uploaded_file($filetmp, $filedest)) {
                      //  $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
                      //  continue;
                }




                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title' => $filetitle,
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $filedest);
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attach_data = wp_generate_attachment_metadata($attach_id, $filedest);
                wp_update_attachment_metadata($attach_id, $attach_data);

        //        $this->filedest = $this->filedest . "-+-" . "/wp-content" . $filedest;
         //       $this->fileName = $this->fileName . "-+-" . "" . $fileName;

            }
        }
    }

    public function cookieKaydet($name, $value)
    {
        Cookie::create($name, $value);

    }



    public function getFiledest($id)
    {
        $uploadfiles = $_FILES[$id];
        $filename = $uploadfiles['name'];
  
          // get file info
          // @fixme: wp checks the file extension....
        $filetype = wp_check_filetype(basename($filename), null);
        $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));
        $filename = $filetitle . '.' . $filetype['ext'];
        $upload_dir = wp_upload_dir();

        /**
         * Check if the filename already exist in the directory and rename the
         * file if necessary
         */
        $i = 0;
        while (file_exists($upload_dir['path'] . '/' . $filename)) {
            $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
            $i++;
        }

        $filedest = $upload_dir['path'] . '/' . $filename;
        $filedest = explode("wp-content", $filedest)[1];
        $this->filedest = "+-+" . "/wp-content" . $filedest;
        return $this->filedest;
    }

    public function getFileName($id)
    {
        $uploadfiles = $_FILES[$id];

        $filename = $uploadfiles['name'];
  
        // get file info
        // @fixme: wp checks the file extension....
        $filetype = wp_check_filetype(basename($filename), null);
        $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));
        $filename = $filetitle . '.' . $filetype['ext'];
        $upload_dir = wp_upload_dir();

        /**
         * Check if the filename already exist in the directory and rename the
         * file if necessary
         */
        $i = 0;
        while (file_exists($upload_dir['path'] . '/' . $filename)) {
            $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
            $i++;
        }
        $this->fileName = $filename;
        return $this->fileName;
    }



    public function getpopupList(
        $id,
        $name,
        $desc,
        $listid,
        $key,
        $value,
        $buttonEnabled = true,
        $bosYazi = '',
        $buttonText
    ) {
        self::setLabelEx($id . "_label", "prompt", $name, "", "");
        $label = Element::getLabelEx();
        self::setP($id . "_dsec", "description", $desc, "");
        $p = self::getP();
        $option = '<option value="" selected="selected">' . $bosYazi . '</option>';
        self::setInput($id . "_btn", "button button-primary", "submit", $buttonText, "", false, "", "");
        $button = self::getInput();

        for ($i = 0; $i < count($listid); $i++) {
            self::setOption("", "", $listid[$i]['name'], $listid[$i][$key]);
            $option = $option . self::getOption();
        }

        self::setSelect($id, "", $option, "");
        $sec = self::getSelect();


        if ($buttonEnabled) {
            self::setDiv("description-wrap", "textarea-wrap", $label . "<br>" . $sec . $p . $button . "<br>", "", "");
        } else {
            self::setDiv("description-wrap", "textarea-wrap", $label . "<br>" . $sec . $p . "<br>", "", "");

        }

        return self::getDiv();
    }


    /**
     * Set the value of filedest
     *
     * @return  self
     */
    public function setFiledest($filedest)
    {
        $this->filedest = $filedest;

        return $this;
    }

    /**
     * Get the value of table
     */
    public function getTable()
    {
        return $this->tableContext;
    }
    public function getTableJsCode()
    {
        return $this->tableJsCodeContext;
    }

    /**
     * Set the value of table
     * setTable(array("bas","bas2"...),array(array(bas,bas....),array(bas,bas2.....)),array("",silmek ile ilgili
     * ,edit ile ilgili,new form),true,false,false,true,true)
     * @return  self
     */
    public function setTable(
        $arrayHead,
        $inArray,
        $jsCode,
        $resimVar = true,
        $yaziVar = false,
        $click = false,
        $delete = false,
        $change = false,
        $isProduct = false
    ) {
        $tabler = new table("click.png", "delete.png", "change.png", $click, $delete, $change);
        $tabler->setHead($arrayHead);

        if (count($inArray) > 0) {
            foreach ($inArray as $key => $value) {
                $tabler->setRows($value, $resimVar, $yaziVar, true, false);
            }
        }


        $tabler->JSCODE($jsCode[0], $jsCode[1], $jsCode[2], $jsCode[3], $isProduct);

        $this->tableContext = $tabler->getResult();
        $this->tableJsCodeContext = $tabler->getResultHead();
    }


    public function getPopupwindow()
    {
        return $this->popupwindow;
    }

    public function setPopupwindow($name, $array)
    {
        $popupwindow = new popupwindow($name);
        $popupwindow->setRowsAll($array);
        $this->popupwindow = $popupwindow->getResult();
    }



    /**
     * Get the value of productFeatures
     */
    public function getProductFeatures()
    {
        return $this->productFeatures;
    }

    /**
     * Set the value of productFeatures
     *
     * @return  self
     */
    public function setProductFeatures()
    {
        $this->popupWindowArray = array(
            array(
                'type' => "inputtext",
                'id' => "urunadi",
                'name' => $this->urunBasligiText,
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "textarea",
                'id' => "urunAciklamasi",
                'name' => $this->urunAciklamasiText,
                'exs' => 42,
                'key' => '',
                'value' => '',
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "turu",
                'name' => $this->turuText,
                'exs' => $this->turuArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "tabanMalzeme",
                'name' => $this->tabanMalzemeText,
                'exs' => $this->tabanMalzemeArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "kapanisTuru",
                'name' => $this->kapanisTuru,
                'exs' => $this->kapanisTuruArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "ustMalzeme",
                'name' => $this->ustMalzeme,
                'exs' => $this->ustMalzemeArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "astarMalzemesi",
                'name' => $this->astarMalzemesi,
                'exs' => $this->astarMalzemesiArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "Sezon",
                'name' => $this->sezon,
                'exs' => $this->sezonArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "icTabanturu",
                'name' => $this->icTabanturu,
                'exs' => $this->icTabanturuArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "popupmenu",
                'id' => "icTabanMalzemesi",
                'name' => $this->icTabanMalzemesi,
                'exs' => $this->icTabanMalzemesiArray,
                'key' => "id",
                'value' => "value",
                'button' => false
            ),
            array(
                'type' => "file",
                'id' => "uploadFile",
                'name' => $this->urungorsel1,
                'exs' => '',
                'key' => "",
                'value' => "",
                'button' => false,
            ),
            array(
                'type' => "file",
                'id' => "uploadFile2",
                'name' => $this->urungorsel2,
                'exs' => '',
                'key' => "",
                'value' => "",
                'button' => false,
            ),
            array(
                'type' => "file",
                'id' => "uploadFile3",
                'name' => $this->urungorsel3,
                'exs' => '',
                'key' => "",
                'value' => "",
                'button' => false,
            ),
            array(
                'type' => "button",
                'id' => "yeniUrunEkleClick",
                'name' => $this->buttonText,
                'exs' => '',
                'key' => "",
                'value' => "",
                'button' => false,
            )
        );

        $this->productFeatures = $this->popupWindowArray;

        return $this;
    }

    /**
     * Get the value of acilirPencere
     */
    public function getAcilirPencere()
    {
        return $this->acilirPencere;
    }

    /**
     * Set the value of acilirPencere
     *
     * @return  self
     */
    public function setAcilirPencere($acilirPencereid, $baslik, $icerik)
    {
        $result = '';

        self::setButtonEx("", "handlediv", "button", "", "", "");
        $button = self::getButtonEx();
        self::setSpan("", "hide-if-no-js", $baslik, "");
        $span = self::getSpan();
        self::setSpan("", "hide-if-no-js", $span, "");
        $span = self::getSpan();
        self::setH(2, "", "hndle ui-sortable-handle", $span, "", 'onclick="' . $acilirPencereid . '()"');
        $h = self::getH();
        self::setDiv("anaDiv", "inside", $icerik, "", "");
        $anaDiv = self::getDiv();

        self::setDiv($acilirPencereid, "postbox closed", $button . $h . $anaDiv, "", "");
        $result = self::getDiv() . '
            <script>
            function ' . $acilirPencereid . '() {
                if (document.getElementById("' . $acilirPencereid . '").className == "postbox") {
                  document.getElementById("' . $acilirPencereid . '").className = "postbox closed";
                }
                else {
                  document.getElementById("' . $acilirPencereid . '").className = "postbox";
                }
              }
            </script>
            ';

        $this->acilirPencere = $result;

        return $this;
    }

    /**
     * Get the value of radioButtonGroup
     */
    public function getRadioButtonGroup()
    {
        return $this->radioButtonGroup;
    }

    /**
     * Set the value of radioButtonGroup
     *
     * @return  self
     */
    public function setRadioButtonGroup($array)
    {
        /*
<div class="form-check">
  <input type="radio" class="form-check-input" id="materialGroupExample1" name="groupOfMaterialRadios">
  <label class="form-check-label" for="materialGroupExample1">Option 1</label>
</div>

<!-- Group of material radios - option 2 -->
<div class="form-check">
  <input type="radio" class="form-check-input" id="materialGroupExample2" name="groupOfMaterialRadios" checked>
  <label class="form-check-label" for="materialGroupExample2">option 2</label>
</div>


         */

        $result = '';

        for ($i = 0; $i < count($array); $i++) {
            $aa = $array[$i];
            $id = $aa['id'];
            $value = $aa['value'];
            $text = $aa['text'];
            $secim = $aa['checked'];
            $kapali = $aa['unchecked'];



            self::setInput($id, "", "radio", $value, "", false, "", $secim);
            $cbox = self::getInput();
            self::setLabelEx($id . "_label", "", $cbox . $text . " ", "");
            $label = self::getLabelEx();
            self::setDiv("", "rows radio" . $kapali, $label, "", "");
            $result = $result . self::getDiv();

        }
    //    self::setForm("","","","",$result,"");



        $this->radioButtonGroup = $result;

        return $this;
    }

    /**
     * Get the value of checkBoxGroup
     */
    public function getCheckBoxGroup()
    {
        return $this->checkBoxGroup;
    }

    /**
     * Set the value of checkBoxGroup
     *
     * @return  self
     */
    public function setCheckBoxGroup($array)
    {
        /*
        array = (
            array(
                id => idsi,
                value => valuesi,
                text => texti,
                checked => checked,veya ''
                unchecked=> disabled veya ''
            )
        )
         */


        $result = '';

        for ($i = 0; $i < count($array); $i++) {
            $aa = $array[$i];
            $id = $aa['id'];
            $value = $aa['value'];
            $text = $aa['text'];
            $secim = $aa['checked'];
            $kapali = $aa['unchecked'];



            self::setInput($id, "", "checkbox", $value, "", false, "", $secim);
            $cbox = self::getInput();
            self::setLabelEx($id . "_label", "", $cbox . $text . " ", "");
            $label = self::getLabelEx();
            self::setDiv("", "rows checkbox" . $kapali, $label, "", "");
            $result = $result . self::getDiv();

        }
    //    self::setForm("","","","",$result,"");

        $this->checkBoxGroup = $result;
        return $this;
    }

    public function getProductAllFilter()
    {
        //



        $input = '<form method="POST" >';

        // TUR 
        if ($_POST['terlikTurSecButton']) {
            $terlikClass = "btn btn-warning btn-lg";
            $ayakClass = "btn btn-secondary btn-sm";
        } else {
            $ayakClass = "btn btn-warning btn-lg";
            $terlikClass = "btn btn-secondary btn-sm";

        }
        self::setButtonEx("ayakkabiTurSecButton", $ayakClass, "", $this->turuArray[0]['name'], $this->turuArray[0]['value'], "");
        $btnAyak = self::getButtonEx();
        self::setButtonEx("terlikTurSecButton", $terlikClass, "", $this->turuArray[1]['name'], $this->turuArray[0]['value'], "");
        $btnTerlik = self::getButtonEx();
        self::setDiv("turSecimdiv", "btn-group", $btnAyak . $btnTerlik, "", "");
        self::setCollapsibles("urunturSec", $this->turuText, self::getDiv(), "show");
        $input = $input . self::getCollapsibles();
        // TUR 


        // SEZON

        $array = array(
            $this->sezonArray,
            $this->tabanMalzemeArray,
            $this->ustMalzemeArray,
            $this->astarMalzemesiArray,
            $this->icTabanturuArray,
            $this->icTabanMalzemesiArray
        );

        $arrayHead = array(
            $this->sezon,
            $this->tabanMalzemeText,
            $this->ustMalzeme,
            $this->astarMalzemesi,
            $this->icTabanturu,
            $this->icTabanMalzemesi
        );

        $arrayID = array(
            "Sezon", "tabanMalzeme", "ustMalzeme", "astarMalzemesi", "icTabanturu", "icTabanMalzemesi"
        );




        for ($i = 0; $i < count($array); $i++) {
            $icArray = $array[$i];

            for ($j = 0; $j < count($icArray); $j++) {


                $icArray[$j]['id'] = $arrayID[$i] . $j;
                $icArray[$j]['value'] = $array[$i][$j]['value'];
                $icArray[$j]['text'] = $array[$i][$j]['name'];
                $icArray[$j]['unchecked'] = ''; // SEÇİM YAPMAK KAPALI
                if ($_POST[$arrayID[$i] . $j] == $array[$i][$j]['value'])
                    $icArray[$j]['checked'] = 'checked';// Seçili yapmak


            }


            self::setCheckBoxGroup($icArray);
            self::setDiv("turSecimdiv" . $i, "btn-group", self::getCheckBoxGroup(), "", "");
            self::setCollapsibles("uruntur" . $i, $arrayHead[$i], self::getDiv(), "");

            $input = $input . self::getCollapsibles();


        }

        self::setButtonEx("filterButton", "button_blue button", "", $this->dil['arama'], "", "");
        $btnFilter = self::getButtonEx();
        self::setButtonEx("temizleButton", "button_blue button", "", $this->dil['temizle'], "", "");
        $temizleButton = self::getButtonEx();

        return $input . "<br>" . $btnFilter . $temizleButton . "</form>";
    }

    /**
     * Get the value of collapsibles
     */
    public function getCollapsibles()
    {
        return $this->collapsibles;
    }

    /**
     * Set the value of collapsibles
     *
     * @return  self
     */
    public function setCollapsibles($id, $buttonText, $inside, $show)
    {


        $result = '  <p>
        <a class="btn btn-light" data-toggle="collapse" href="#' . $id . '" role="button" aria-expanded="true" aria-controls="' . $id . '">
          ' . $buttonText . '  <i class="fa fa-sort-down"></i>
        </a>
      <div class="collapse  show ' . $show . '" id="' . $id . '">
        <div class="card card-body">
        ' . $inside . '
        </div>
      </div>
';

        self::setA("", "#collapseExample", "btn btn-primary", "", "", ' role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseExample"', $buttonText);
        $button = self::getA();

        self::setDiv("collapseExample", "collapse", $inside, "padding:7%;", 'align="center"');
        $div = self::getDiv();

        self::setDiv("genelDivCollap", "p-3 mb-2 bg-light text-dark", $result, "padding:0%;", "");
        $this->collapsibles = self::getDiv();

        return $this;
    }




    /**
     * Get the value of slayderImage
     */
    public function getSlayderImage()
    {
        return $this->slayderImage;
    }

    /**
     * Set the value of slayderImage
     *
     * @return  self
     */
    public function setSlayderImage($array)
    {
        $image = '';

        $random = rand(5, 1000000000);
        $random = "slayder_" . $random;

        for ($i = 1; $i < count($array); $i++) {
            if ($i == 1) {
                $image = '
                <div class="carousel-item active">
                <img class="d-block w-100" src="' . $array[$i] . '">
          
              </div>
              ';
            } else {
                $image = $image . '<div class="carousel-item">
                <img class="d-block w-100" src="' . $array[$i] . '">
              </div>';
            }
        }
        $slayderImage =
            '
            <div id="' . $random . '" class="carousel slide" data-ride="carousel">
         
            <div class="carousel-inner">
             ' . $image . '
            </div>
            <a class="carousel-control-prev" href="#' . $random . '" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#' . $random . '" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        ';

        self::setDiv("", "", $slayderImage, "", "");
        $this->slayderImage = self::getDiv();

        return $this;
    }

    /**
     * Get the value of product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the value of product
     *
     * $image ->  array 
     * $baslik-> text
     * $aciklama-> text
     * $ozellikler-> array
     * @return  self
     */
    public function setProduct(
        $fiyat,
        $baslik,
        $aciklama,
        $producerNO,
        $image,
        $ozellikler,
        $productNO,
        $lid
    ) {
        $result = '';



        self::setSpan("urunFiyat", "woocommerce-Price-amount amount", $fiyat, "");
        $fiyat = self::getSpan();
        self::setP("", "product_price", "<b>" . $fiyat . "</b>", "");
        $fiyat = self::getP();




        self::setH(1, "urunBaslik", "offset_title", $baslik, "", 'itemprop="name"');
        $baslik = self::getH();


        self::setLabelEx("urunAcik", "text-secondary", "<i>" . $this->dil['urunaciklama'] . ";</i>", "");
        self::setLabelEx("urunAcik", "", self::getLabelEx() . "<br>" . $aciklama . "<br>", "");
        $aciklama = self::getLabelEx();


        $ozelliklistesi = '';

        $i = 0;



        if ($ozellikler > 0) {
            foreach ($ozellikler as $key => $value) {
                $i++;
                if ($i > 1) {

                    if ($key == "tabanMalzeme")
                        $key = $this->tabanMalzemeText;
                    else if ($key == "kapanisTuru")
                        $key = $this->kapanisTuru;
                    else if ($key == "ustMalzeme")
                        $key = $this->ustMalzeme;
                    else if ($key == "astarMalzemesi")
                        $key = $this->astarMalzemesi;
                    else if ($key == "Sezon")
                        $key = $this->sezon;
                    else if ($key == "icTabanturu")
                        $key = $this->icTabanturu;
                    else if ($key == "icTabanMalzemesi")
                        $key = $this->icTabanMalzemesi;

                    $array = array(
                        "kaucuk" => "Kaçuçuk",
                        "PU" => "PU",
                        "termo" => "Termo",
                        "gecme" => "Geçme",
                        "cirtcirtli" => "Cırtlı",
                        "bagcikli" => "Bağcıklı",
                        "deri" => "Deri",
                        "sunideri" => "Suni Deri",
                        "kumas" => "Kumaş",
                        "ilkbahar" => "İlk bahar",
                        "yaz" => "Yaz",
                        "sonbahar" => "Son bahar",
                        "kis" => "Kış",
                        "sabit" => "Sabit",
                        "degistirilebilir" => "Değiştirilebilir",
                        "sunger" => "Sünger",
                        "hafizalisunger" => "Hafızalı Sünger",
                    );
                    $tersarray = array_reverse($array, false);
                    foreach ($array as $k => $va) {
                        if ($va == $value) {
                            $deger = $this->dil[$k];
                            self::setLabelEx("", "", $key . " : " . $deger, "");
                            self::setLi("", "", self::getLabelEx(), "");
                            $ozelliklistesi = $ozelliklistesi . self::getLi();
                            break;


                        }
                    }




                }
            }
        }



        self::setUl("", "col-sm-12", $ozelliklistesi, "");
        $ozelliklistesi = self::getUl();
        self::setLabelEx("urunOzellikler", "text-secondary", "<i>" . $this->dil['urunozellikler'] . ";</i>", "");
        self::setDiv("", "row", $ozelliklistesi, "", "");
        $ozelliklerDiv = self::getLabelEx() . "<br>" . self::getDiv();






       // $siparisNotu = self::getTextarea("satinAlmaNot" . $productNO, "Eklemek istediğiniz", 30, false);



        $satinalma = '
        <form>
        <button type="submit" class="single_add_to_cart_button button alt">' . $this->dil['satinalbutton'] . '</button>
        <input type="hidden" name="add-to-cart" value="' . $productNO . '">
        <input type="hidden" name="product_id" value="' . $productNO . '">
        <input type="hidden" name="producer_id" value="' . $producerNO . '">
        </form>
        ';

        //echo " bas: " . $ozelliklistesi . "<br>";
       // echo " bas: " . $fiyat . "<br>";


        $result =
            $baslik .
            $fiyat . "<br>" .
            $ozelliklerDiv .
            $aciklama .
            $siparisNotu . "<br>" .
            $satinalma . "<br>";



        self::setSlayderImage($image);
        self::setDiv("", "col-sm-6", self::getSlayderImage(), "", "");
        $div6_1 = self::getDiv();
        self::setDiv("", "col-sm-6", $result, "", "");
        $div6_2 = self::getDiv();
        self::setDiv("", "row", $div6_1 . $div6_2, "margin:3%; background-color:#F8F8F8; padding-top:3%;", "");
        $div = self::getDiv();
        self::setLi($lid, "liClass", $div, "", "");
        $li = self::getLi();

        if ($ozellikler > 1)
            $this->product = $li;


        return $this;
    }


    /**
     * Get the value of filtreler
     */
    public function getFiltreler()
    {
        return $this->filtreler;
    }

    /**
     * Set the value of filtreler
     *
     * @return  self
     */
    public function setFiltreler()
    {
        $arrayID = array(
            "Sezon", "tabanMalzeme",
            "ustMalzeme", "astarMalzemesi",
            "icTabanturu", "icTabanMalzemesi"
        );


        foreach ($arrayID as $key => $value) {

            if ($arrayID == "Sezon") {
                $array = 4;
            } else if ($arrayID == "icTabanturu") {
                $array = 2;
            } else {
                $array = 3;
            }


            for ($j = 0; $j < $array; $j++) {
                if (isset($_POST[$value . $j])) {
                    $this->filtreler[$value . $j] = $_POST[$value . $j];
                }
            }
        }


        return $this;
    }


    /**
     * Get the value of genelProduct
     */
    public function getGenelProduct()
    {
        return $this->genelProduct;
    }







    public function setGenelProduct($productList, $tur, $filtreler, $bas = 0)
    {
        $bitis = $bas + 10;
        $listenenUrunSayisi = 10;

        $toplamUrun = count($productList);

        $j = 0;
        $analink = $_SERVER['REQUEST_URI'];
        $pageNumberArray = explode("/page/", $analink);
        $link = explode("=", $_SERVER['REQUEST_URI']);

        $pageNumber = 1;
        if ($pageNumberArray[1]) {
            $pageNumber = $pageNumberArray[1][0];
            $pageNumberEx = '/page/' . $pageNumber;
            if ($link[1]) {
                $href = explode("?product_order", $analink);
                $href = $href[0] . "?product_order=";
            }
            if ($listenenUrunSayisi * $pageNumber >= $toplamUrun) {
                $last = true;
            }
        } else {
            $first = true;
            $href = '?product_order=';
        }




        if (count($productList) < $bitis) {
            $bitis = count($productList);
        }

        for ($i = 0; $i < $bitis; $i++) { 
            # code...
            self::setProduct(
                $this->urunler[$i]['fiyat'],
                $this->urunler[$i]['bas'],
                $this->urunler[$i]['aciklama'],
                $this->urunler[$i]['producerNO'],
                $this->urunler[$i]['image'],
                $this->urunler[$i]['ozellikler'],
                $this->urunler[$i]['productNO'],
                $i + $bas
            );
        }





        for ($i = (($pageNumber - 1) * $listenenUrunSayisi); $i < (($pageNumber - 1) * $listenenUrunSayisi) + $listenenUrunSayisi; $i++) {
            require_once(ABSPATH . "wp-content/plugins/footsphere/classes/product.php");
            $product = new product(0, $productList[$i], $tur, $filtreler);
            $fiyat = $product->getUrunFiyati();
            $baslik = $product->getUrunAdi();
            $aciklama = $product->getUrunAciklama();
            $producerNO = $product->getProducerNO();
            $image = $product->getUrunResmi();
            $ozellikler = $product->getUrunOzellikleri();
            $productNO = $product->getProductNO();
            if ($fiyat != '' || $fiyat != null) {
                $this->urunler[$j] = array(
                    'bas' => $baslik,
                    'fiyat' => $fiyat,
                    'aciklama' => $aciklama,
                    'producerNO' => $producerNO,
                    'image' => $image,
                    'ozellikler' => $ozellikler,
                    'productNO' => $productNO
                );
                $j++;
            }

            if ($productList[$i + 10] != '' || $productList[$i + 10] != null)
                $this->proList = $this->proList . $productList[$i + 10] . ",";





        }
        $link[1] = explode("/page/", $link[1]);

        for ($i = 0; $i < count($this->urunler); $i++) {
            if ($link[1][0] == "ascending") {
                $tmpArray = array(); // Sıralanmasını istediğimiz alanı buraya aktracağız
                foreach ($this->urunler as $key => $value) {
                    $tmpArray[$key] = $value['fiyat'];
                }
                array_multisort($tmpArray, SORT_ASC, $this->urunler);

                self::setProduct(
                    $this->urunler[$i]['fiyat'],
                    $this->urunler[$i]['bas'],
                    $this->urunler[$i]['aciklama'],
                    $this->urunler[$i]['producerNO'],
                    $this->urunler[$i]['image'],
                    $this->urunler[$i]['ozellikler'],
                    $this->urunler[$i]['productNO'],
                    $i + $bas
                );
                $this->popupMenu = '
                
                <span class="active_option open_select">' . $this->dil['fiyatagoreartan'] . '</span>

          <ul class="options_list dropdown ">
            <li class="animated_item" style="transition-delay: 0.1s;">
              <a href="' . $href . 'normal' . $pageNumberEx . '">' . $this->dil['soneklenenler'] . '</a>
            </li>
            <li class="selected" style="transition-delay: 0.2s;">
              <a   href="' . $href . 'ascending' . $pageNumberEx . '">' . $this->dil['fiyatagoreartan'] . '</a>
            </li>
            <li class="animated_item" style="transition-delay: 0.5s;">
              <a href="' . $href . 'descending' . $pageNumberEx . '">' . $this->dil['fiyatagoreazalan'] . '</a>
            </li>
                    </ul>
                    ';
            } else if ($link[1][0] == "descending") {
                $tmpArray = array(); // Sıralanmasını istediğimiz alanı buraya aktracağız
                foreach ($this->urunler as $key => $value) {
                    $tmpArray[$key] = $value['fiyat'];
                }
                array_multisort($tmpArray, SORT_DESC, $this->urunler);

                self::setProduct(
                    $this->urunler[$i]['fiyat'],
                    $this->urunler[$i]['bas'],
                    $this->urunler[$i]['aciklama'],
                    $this->urunler[$i]['producerNO'],
                    $this->urunler[$i]['image'],
                    $this->urunler[$i]['ozellikler'],
                    $this->urunler[$i]['productNO'],
                    $i + $bas
                );
                $this->popupMenu = '
                
                <span class="active_option open_select">' . $this->dil['fiyatagoreazalan'] . '</span>

                <ul class="options_list dropdown ">
                <li class="animated_item" style="transition-delay: 0.1s;">
                  <a href="' . $href . 'normal' . $pageNumberEx . '">' . $this->dil['soneklenenler'] . '</a>
                </li>
                <li class="animated_item" style="transition-delay: 0.2s;">
                  <a   href="' . $href . 'ascending' . $pageNumberEx . '">' . $this->dil['fiyatagoreartan'] . '</a>
                </li>
                <li class="selected" style="transition-delay: 0.5s;">
                  <a href="' . $href . 'descending' . $pageNumberEx . '">' . $this->dil['fiyatagoreazalan'] . '</a>
                </li>
                        </ul>
                    ';
            } else {
                self::setProduct(
                    $this->urunler[$i]['fiyat'],
                    $this->urunler[$i]['bas'],
                    $this->urunler[$i]['aciklama'],
                    $this->urunler[$i]['producerNO'],
                    $this->urunler[$i]['image'],
                    $this->urunler[$i]['ozellikler'],
                    $this->urunler[$i]['productNO'],
                    $i + $bas
                );

                $this->popupMenu = '
                
                <span class="active_option open_select">' . $this->dil['soneklenenler'] . '</span>

                <ul class="options_list dropdown ">
                <li class="selected" style="transition-delay: 0.1s;">
                  <a href="' . $href . 'normal' . $pageNumberEx . '">' . $this->dil['soneklenenler'] . '</a>
                </li>
                <li class="animated_item" style="transition-delay: 0.2s;">
                  <a   href="' . $href . 'ascending' . $pageNumberEx . '">' . $this->dil['fiyatagoreartan'] . '</a>
                </li>
                <li  class="animated_item" style="transition-delay: 0.5s;">
                  <a href="' . $href . 'descending' . $pageNumberEx . '">' . $this->dil['fiyatagoreazalan'] . '</a>
                </li>
                        </ul>
                    ';
            }



            $this->geciciDegisken = $this->geciciDegisken . self::getProduct();
        }



        $this->body = $this->body . $this->geciciDegisken;


        self::setImg("", "", "/wp-content/plugins/footsphere/assets/images/loader.gif", "100", "", "", "", "");
        $img = self::getImg();
        self::setDiv("loader", "", $img, "background-color:#fff;border:0px solid #ccc;margin10px;padding:8px;text-align:center;width:100%;height:100px;display:none;", "");
        $loaderDiv = self::getDiv();
        self::setUl("listeleme", "listeleme", $this->body, "width:100%;padding:0;margin:0;list-style:none;");
        $body = self::getUl() . $loaderDiv;


        if (!$first) {
            $firstresult = '
            <li>
    <a class="prev page-numbers" href="' . $pageNumberArray[0] . '/page/' . ($pageNumber - 1) . '">←</a></li>
    <li>
    
    <a class="page-numbers" href="' . $pageNumberArray[0] . '/page/' . ($pageNumber - 1) . '">' . ($pageNumber - 1) . '</a></li>
            ';
        }

        if (!$last) {
            $lastresult = '
            <li><a class="page-numbers" href="' . $pageNumberArray[0] . '/page/' . ($pageNumber + 1) . '">' . ($pageNumber + 1) . '</a></li>
    <li>

    <a class="next page-numbers" href="' . $pageNumberArray[0] . '/page/' . ($pageNumber + 1) . '">→</a>
    </li>
            ';
        }


        $footer = '
        <footer class="bottom_box on_the_sides">

				<div class="left_side">
					<p class="woocommerce-result-count">
	' . ($toplamUrun - 1) . ' ' . $this->dil['toplamurunfrontendacik'] . '.</p>				</div><!--/ .left_side-->

				<div class="right_side">
					

<div class="pagination">
						<nav>
	<ul class="page-numbers">
    
    ' . $firstresult . '
    
	<li><span aria-current="page" class="page-numbers current">' . ($pageNumber) . '</span></li>
    
    ' . $lastresult . '

</ul>

</nav>
					</div><!--/ .pagination-->
				</div><!--/ .right_side-->

				</footer>
   ';




        $result = '
        
        <div  style="height:100%;">
  <div>
    <table style="height:100%;width:100%">
        <thead>
            <tr>
                <td>
                


                <div class="v_centered">

        <span>' . $this->dil['sirala'] . '</span>

        <div class="dropdown-list sort-param sort-param-order" style="height:25px;">

          ' . $this->popupMenu . '

        </div><!--/ .sort-param-->


      </div>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <div id="genelProductDiv"  name="genelProductDiv" class="row" style="overflow: auto; width: 100%;  height: 100%; position: relative;">
           
                     ' . $body . '
                     </div>
                    
                   
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td>
                    
                   

				
			' . $footer . '
                  
                </td>
            </tr>
        </tfoot>
    </table>
</div>
        ';
        $this->genelProduct = $result;

        return $this;
    }

    /**
     * Get the value of body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }


}

?>