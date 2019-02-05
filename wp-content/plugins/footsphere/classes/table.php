<?php
/*

$table = new table();
$arrayHead = array("Görsel", "Ürünün Adı", "Açıklaması", "Fiyatı", "Üreticisi", "Düzenle");
$table->setHead($arrayHead);
$database = new productDB();
$producerDB = new producerDB();

$list = $database->getAll();

for ($i = 0; $i < count($list); $i++) {
    $backgroundColor;
    $arrayRows = array(
        $list[$i]['ID'],
        "white",
        $database->getImageUrlLink($list[$i]['ID']),
        $list[$i]['post_title'],
        $list[$i]['post_excerpt'],
        $database->getPrice($list[$i]['ID']),
        $producerDB->getName(explode("_", $list[$i]['pin'])[1])
    );
    $table->setRows($arrayRows);
}

    $table->JSCODE("openclick denemesi","2ci deneme","3cü deneme");

echo 

 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/footsphere/classes/component.php");

class table
{
    private $first;
    private $last;
    private $onclick;
    private $result;
    private $jsCode;
    private $firstIcon, $secondIcon, $thirdIcon, $firstIconB, $secondIconB, $thirdIconB;

    private $pageInfoHead;
    private $pageInfoRows;
    private $pageInfoResultEdit;
    private $pageInfoResultDelete;

    private $component;

    private $dil;

    function __construct($firstIcon = "click.png", $secondIcon = "delete.png", $thirdIcon = "change.png", $firstIconB, $secondIconB, $thirdIconB)
    {

        wp_enqueue_style('table');
        wp_enqueue_script('table'); //CSS VE JS Dosyalari aktifleşitiriyor.

        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();
        $this->component = new component();
        $this->firstIcon = $firstIcon;
        $this->secondIcon = $secondIcon;
        $this->thirdIcon = $thirdIcon;
        $this->firstIconB = $firstIconB;
        $this->secondIconB = $secondIconB;
        $this->thirdIconB = $thirdIconB;
        $this->first = '
</div></div>
        <br><br>
        <table class="wp-list-table widefat fixed striped users">
        
  
        <tr>
        ';

        $this->last = '
        </tr>
        
        
    
    
    
             </table>
             <br class="clear">
             </div>
        ';

        $this->result = $first;

    }


    public function setHead($arrayColumn = array())
    {
        $this->pageInfoHead = $arrayColumn;


        $result = '
            <td id="cb" class="check-column"><label></label></td>
            ';

        foreach ($arrayColumn as $key => $value) {
            $result = $result . '
            <th scope="col" name="' . $key . '" 
            id="username" class="manage-column column">
            <span>' . $value . '</span>
            <spanclass="sorting-indicator"></span></a></th>
            ';

        }

        self::setResult($result);

    }



    public function setRows($arrayColumn = array(), $resimVar = true, $yazivar = false, $checkbox = true, $openClick = false)
    {
        //'[0] idsi
        //'[1] arkaplanı,
        //'[2] resim,


        $gorsel = '';
        if ($resimVar) {
            $gorsel = '
<th scope="row" class="delete"  >
<a class="thumb"><img src="' . $arrayColumn[2][1] . '" width="25px">
<span><img src="' . $arrayColumn[2][1] . '" width="600px" height="600px"></span></a>
        </span>
        <a class="thumb"><img src="' . $arrayColumn[2][2] . '" width="25px">
        <span><img src="' . $arrayColumn[2][2] . '" width="600px" height="600px"></span></a>
                </span>
                <a class="thumb"><img src="' . $arrayColumn[2][3] . '" width="25px">
                <span><img src="' . $arrayColumn[2][3] . '" width="600px" height="600px"></span></a>
                        </span>
                     
        </th>';
        } else {
            if ($yazivar) {
                $gorsel = '
                <td class="name column-name" data-colname="İsim">' . $arrayColumn[2] . '</td>   
                
                ';
            } else {
                $gorsel = '
                <th scope="row" class="delete"  >
                <a class="thumb"><img src="/wp-content/plugins/footsphere/assets/images/' . $arrayColumn[2] . '" width="30px"></a>
                </th> ';
            }

        }

        $button = '';

        if ($this->firstIconB) {
            $button = $button . '
            <button onclick="openClick(' . $arrayColumn[0] . ',' . count($arrayColumn) . ')" name="' . $arrayColumn[0] . '_oku"  style="padding: 0; border: none;" "type="submit" >
            <img src="/wp-content/plugins/footsphere/assets/images/' . $this->firstIcon . '" width="24" height="24"/></button>
    
            ';
        }
        if ($this->secondIconB) {
            $button = $button . '
            <button onclick="deleteForm(' . $arrayColumn[0] . ',' . count($arrayColumn) . ')" name="' . $arrayColumn[0] . '_sil"  style="padding: 0; border: none;" "type="submit" >
            <img src="/wp-content/plugins/footsphere/assets/images/' . $this->secondIcon . '" width="24" height="24"/>
            </button>
    
            ';
        }
        if ($this->thirdIconB) {
            $button = $button . '
           
        <button onclick="openForm(' . $arrayColumn[0] . ',' . count($arrayColumn) . ')" name="' . $arrayColumn[0] . '_duzen"  style="padding: 0; border: none;" "type="submit" >
        <img src="/wp-content/plugins/footsphere/assets/images/' . $this->thirdIcon . '" width="24" height="24"/>
        </button>
            ';
        }
        $array = array(
            'onclick' => 1,
            'backgroundcolor' => 'white',
            'id'
        );
        $tirnak = "'";


        $result = $result . '
         
            <tbody  id="the-list_" data-wp-lists="list:user" >

            ';


        if ($checkbox) {

            $result = $result . ' 
            <tr style="background-color: ' . $arrayColumn[1] . ';" id="product-'.$arrayColumn[0].'" name="product-'.$arrayColumn[0].'">
            <th>
          <form method="POST">


            <input type="checkbox" onclick="onClickHandler('. $arrayColumn[0] . ')" id="'.$arrayColumn[0].'_checkBox" name="'.$arrayColumn[0].'_checkBox" class="subscriber" value="' . $arrayColumn[0] . '"></th>
            </form>
        
            ' . $gorsel . '
    
                    
        
            ';
        } else {
            $result = $result . ' 
            <tr style="background-color: ' . $arrayColumn[1] . ';" id="producer-">
            <th>
            </th>
           
        
            ' . $gorsel . '
    
                    
        
            ';
        }
        if ($openClick) {

        }

        for ($i = 3; $i < count($arrayColumn); $i++) {
            $result = $result . '
         <td class="name column-name" id="' . $arrayColumn[0] . '_' . $i . '" name="' . $arrayColumn[0] . '_' . $i . '" data-colname="İsim">' . $arrayColumn[$i] . '</td>   
         ';
        }

        $result = $result . '
        <td class="name column-name">
      ' . $button . '
        </td> 
        </tr></tbody>
        
        ';

        self::setResult($result);
    }




    public function getResult()
    {
        return $this->first . ' ' . $this->result . ' ' . $this->last;
    }

    public function getResultHead()
    {
        return $this->jsCode;
    }
    public function setResult($result)
    {
        $this->result = $this->result . $result;
    }

    public function JSCODE($openClick, $deleteForm, $editForm, $newClick, $isProduct = false)
    {

               // DELETE FORM //
        $result = '';
        for ($i = 1; $i < count($this->pageInfoHead) - 2; $i++) {
            $label = $this->component->getLabel("baslik", $this->pageInfoHead[$i], 4);
            $input = $this->component->getInputtextPro($i . "_rows_D", "text", "", "", true, "");
            $this->component->setDiv("description-wrap", "input-text-wrap", $label . "<br><br>" . $input, "", "", "");
            $div = $this->component->getDiv();
            $result = $result . $div;
        }


        $label = $this->component->getLabel("deleteBaslik",        $this->dil['backend_table_silmeOnayBaslik'], 1);
        $inputHid = $this->component->getInputtextPro("hiddenValueDelete", "hidden", "", "", false, "");
        $this->component->setInput("submitButtonDelete", "button-primary", "submit",         $this->dil['evet'], "", false, "", "");
        $inputButton = $this->component->getInput();
        $this->component->setInput("hiddenValueDelete", "button-primary", "submit",        $this->dil['hayir'], "", false, "", 'onclick="closeForm()"');
        $inputClosebutton = $this->component->getInput();
        $this->component->setForm("", "", "POST", "", $label . "<br><br>" . $result . $inputHid . $inputButton, "");
        $form = $this->component->getForm();
        $this->component->setDiv("deleteForm", "form-popup", $form . $inputClosebutton, "", "");
        $div = $this->component->getDiv();
        $deleteForm = $div; 
               // DELETE FORMM
        $result = '';
// EDİT FORM
        for ($i = 1; $i < count($this->pageInfoHead) - 2; $i++) {
            $label = $this->component->getLabel("baslik", $this->pageInfoHead[$i], 4);
            if (!$isProduct) {
                $input = $this->component->getInputtextPro($i . "_rows", "text", "", "", false, "");
            } else {
                if ($i > 2) {
                    $this->component->setProductFeatures();
                    $productFeaturesArray = $this->component->getProductFeatures();
                    $input = $this->component->getpopupList(
                        $i . "_rows",
                        "",
                        "",
                        $productFeaturesArray[$i - 1]['exs'],
                        "id",
                        $productFeaturesArray[$i - 1]['value'],
                        false,
                        "",
                        ""
                    );
                } else {
                    $input = $this->component->getInputtextPro($i . "_rows", "text", "", "", false, "");
                }

            }

            $this->component->setDiv("description-wrap", "input-text-wrap", $label . "<br><br>" . $input, "", "", "");
            $div = $this->component->getDiv();
            $result = $result . $div;
        }


        $label = $this->component->getLabel("editBaslik", $this->dil['backend_table_duzenlemeOnayBaslik'], 1);
        $inputHid = $this->component->getInputtextPro("hiddenValueEdit", "hidden", "", "", false, "");
        $this->component->setInput("submitButtonEdit", "button-primary", "submit", $this->dil['evet'], "", false, "", "");
        $inputButton = $this->component->getInput();
        $this->component->setInput("hiddenValueEdit", "button-primary", "submit", $this->dil['hayir'], "", false, "", 'onclick="closeForm()"');
        $inputClosebutton = $this->component->getInput();
        $this->component->setForm("", "", "POST", "", $label . "<br><br>" . $result . $inputHid . $inputButton, "");
        $form = $this->component->getForm();
        $this->component->setDiv("editForm", "form-popup", $form . $inputClosebutton, "", "");
        $div = $this->component->getDiv();
        $editForm = $div;  
// EDİT FORM 
        $result = '';
               // OpenForm FORM 

        $label = $this->component->getLabel("openBaslik", "Kullanıcı Bilgisi", 1);
        $inputHid = $this->component->getInputtextPro("hiddenValueOpen", "hidden", "", "", false, "");
        $this->component->setInput("submitButtonOpen", "button-primary", "submit", "Evet", "", false, "", "");
        $inputButton = $this->component->getInput();
        $this->component->setInput("hiddenValueOpen", "button-primary", "submit", "Hayır", "", false, "", 'onclick="closeForm()"');
        $inputClosebutton = $this->component->getInput();
        $this->component->setForm("", "", "POST", "", $label . "<br><br>" . $openClick . $inputHid . $inputButton, "");
        $form = $this->component->getForm();
        $this->component->setDiv("openClick", "form-popup", $form . $inputClosebutton, "", "");
        $div = $this->component->getDiv();
        $openClick = $div; 

               // OpenForm FORM 

        $result = '';
               // New FORM 

        $label = $this->component->getLabel("newBaslik", "New Başlık Yazı", 1);
        $inputHid = $this->component->getInputtextPro("hiddenValueNew", "hidden", "", "", false, "");
        $this->component->setInput("submitButtonNew", "button-primary", "submit", "Evet", "", false, "", "");
        $inputButton = $this->component->getInput();
        $this->component->setInput("hiddenValueNew", "button-primary", "submit", "Hayır", "", false, "", 'onclick="closeForm()"');
        $inputClosebutton = $this->component->getInput();
        $this->component->setForm("", "", "POST", "", $label . "<br><br>" . $newClick . $inputHid . $inputButton, "");
        $form = $this->component->getForm();
        $this->component->setDiv("newForm", "form-popup", $form . $inputClosebutton, "", "");
        $div = $this->component->getDiv();
        $newClick = $div; 

               // New FORM 




        $this->jsCode = $openClick . $newClick . $editForm . $deleteForm;
    }



}


?>