<?php
    /*
    public function getLabel()
    {
        return $this->label;
    }

    
    public function setLabel($id='',$class='',$text='',$style='')
    {
        $this->h = self::common("h".$size,$id,$class,'',$text,$style);

        return $this;
    } */
class Element
{

    private $label;
    private $h;
    private $a;
    private $option;
    private $select;
    private $button;
    private $li;
    private $canvas;
    private $p;
    private $span;
    private $fieldset;
    private $strong;
    private $u;
    private $i;
    private $b;
    private $q; //  "" iki tırnak arasında yazmayı sağlıyor.
    private $ul;
    private $nav;
    private $section;
    private $progressbar;
    private $th;
    private $tr;
    private $td;
    private $colgroup;
    private $col;
    private $input;
    private $img;
    private $form;
    private $table;
    private $tbody;
    private $div;
    private $datalist;
    private $font;
    private $textarea;
    function __construct()
    {

    }

    private function common($element = '', $id = '', $class = '', $type = '', $text = '', $style = '', $value = '', $placeHolder = '', $ext = '')
    {
        return '
        <' . $element . ' type="' . $type . '" id="' . $id . '" name ="' . $id . '" class="' . $class . '" style="' . $style . 
        '" value="' . $value . '"  placeholder="' . $placeHolder . '" ' . $ext . '
        >' . $text . '</' . $element . '>
        ';
    }

//
    public function getLabelEx()
    {
        return $this->label;
    }

    public function setLabelEx($id = '', $class = '', $text = '', $style = '')
    {
        $this->label = self::common("label", $id, $class, "", $text, $style);

        return $this;
    }



    /**
     * Get the value of h
     */
    public function getH()
    {
        return $this->h;
    }

    /**
     * Set the value of h
     *
     * @return  self
     */
    public function setH($size, $id = '', $class = '', $text = '', $style = '',$ext='')
    {
        $this->h = self::common("h" . $size, $id, $class, '', $text, $style,'','',$ext);

        return $this;
    }

    /**
     * Get the value of a
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set the value of a
     *
     * @return  self
     */
    public function setA($id = '', $href = '', $class = '', $text = '', $style = '',$ext='',$value='')
    {
        $this->a = self::common("a", $id, $class, '', $text, $style, $value, '',$ext. ' href="' . $href . '"');

        return $this;
    }
 //   

    /**
     * Get the value of option
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set the value of option
     *
     * @return  self
     */
    public function setOption($id = '', $class = '', $text = '', $value = '')
    {
        $this->option = self::common("option", $id, $class, '', $text, '', $value, "");

        return $this;
    }

    /**
     * Get the value of select
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * Set the value of select
     *
     * @return  self
     */
    public function setSelect($id = '', $class = '', $text = '', $style = '')
    {
        $this->select = self::common("select", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of button
     */
    public function getButtonEx()
    {
        return $this->button;
    }

    /**
     * Set the value of button
     *
     * @return  self
     */
    public function setButtonEx($id = '', $class = '', $type = '', $text = '', $value,$style = '')
    {
        $this->button = self::common("button", $id, $class, $type, $text, $style,$value,"","");

        return $this;
    }

    /**
     * Get the value of li
     */
    public function getLi()
    {
        return $this->li;
    }

    /**
     * Set the value of li
     *
     * @return  self
     */
    public function setLi($id = '', $class = '', $text = '', $value = '', $style = '')
    {
        $this->li = self::common("li", $id, $class, '', $text, $style, $value);

        return $this;
    }

    /**
     * Get the value of canvas
     */
    public function getCanvas()
    {
        return $this->canvas;
    }

    /**
     * Set the value of canvas
     *
     * @return  self
     */
    public function setCanvas($id = '', $class = '', $text = '', $width = '', $height = '', $style = '')
    {
        $this->canvas = self::common("canvas", $id, $class, '', $text, $style, '', '', 'width="' . $width . '" height="' . $height . '"');


        return $this;
    }

    /**
     * Get the value of p
     */
    public function getP()
    {
        return $this->p;
    }

    /**
     * Set the value of p
     *
     * @return  self
     */
    public function setP($id = '', $class = '', $text = '', $style = '')
    {
        $this->p = self::common("p", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of span
     */
    public function getSpan()
    {
        return $this->span;
    }

    /**
     * Set the value of span
     *
     * @return  self
     */
    public function setSpan($id = '', $class = '', $text = '', $style = '')
    {
        $this->span = self::common("span", $id, $class, '', $text, $style);
        return $this;
    }

    /**
     * Get the value of fieldset
     */
    public function getFieldset()
    {
        return $this->fieldset;
    }

    /**
     * Set the value of fieldset
     *
     * @return  self
     */
    public function setFieldset($id = '', $class = '', $text = '', $style = '')
    {
        $this->fieldset = self::common("fieldset", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of strong
     */
    public function getStrong()
    {
        return $this->strong;
    }

    /**
     * Set the value of strong
     *
     * @return  self
     */
    public function setStrong($id = '', $class = '', $text = '', $style = '')
    {
        $this->strong = self::common("strong", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of u
     */
    public function getU()
    {
        return $this->u;
    }

    /**
     * Set the value of u
     *
     * @return  self
     */
    public function setU($id = '', $class = '', $text = '', $style = '')
    {
        $this->u = self::common("u", $id, $class, '', $text, $style);

        return $this;
    }

    public function getB()
    {
        return $this->b;
    }

    /**
     * Set the value of u
     *
     * @return  self
     */
    public function setB($id = '', $class = '', $text = '', $style = '')
    {
        $this->b = self::common("b", $id, $class, '', $text, $style);

        return $this;
    }
    public function getQ()
    {
        return $this->b;
    }

    /**
     * Set the value of u
     *
     * @return  self
     */
    public function setQ($id = '', $class = '', $text = '', $style = '')
    {
        $this->b = self::common("q", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of u
     */
    public function getI()
    {
        return $this->i;
    }

    /**
     * Set the value of u
     *
     * @return  self
     */
    public function setI($id = '', $class = '', $text = '', $style = '')
    {
        $this->i = self::common("i", $id, $class, '', $text, $style);

        return $this;
    }

    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set the value of u
     *
     * @return  self
     */
    public function setSection($id = '', $class = '', $text = '', $style = '')
    {
        $this->section = self::common("i", $id, $class, '', $text, $style);

        return $this;
    }
    /**
     * Get the value of ul
     */
    public function getUl()
    {
        return $this->ul;
    }

    /**
     * Set the value of ul
     *
     * @return  self
     */
    public function setUl($id = '', $class = '', $text = '', $style = '')
    {
        $this->ul = self::common("ul", $id, $class, '', $text, $style);

        return $this;
    }


    public function getNav()
    {
        return $this->nav;
    }

    /**
     * Set the value of ul
     *
     * @return  self
     */
    public function setNav($id = '', $class = '', $text = '', $style = '')
    {
        $this->nav = self::common("nav", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of progressbar
     */
    public function getProgressbar()
    {
        return $this->progressbar;
    }

    /**
     * Set the value of progressbar
     *
     * @return  self
     */
    public function setProgressbar($id = '', $max = '', $value = '', $class = '', $text = '', $style = '')
    {
        $this->progressbar = self::common("progress", $id, $class, '', $text, $style, $value, '', 'max="' . $max . '"');

        return $this;
    }

    /**
     * Get the value of th
     */
    public function getTh()
    {
        return $this->th;
    }

    /**
     * Set the value of th
     *
     * @return  self
     */
    public function setTh($id = '', $scope = '', $value = '', $class = '', $text = '', $style = '')
    {
        $this->th = self::common("th", $id, $class, '', $text, $style, $value, '', 'scope="' . $scope . '"');

        return $this;
    }

    public function getTd()
    {
        return $this->td;
    }

    /**
     * Set the value of th
     *
     * @return  self
     */
    public function setTd($id = '', $class = '', $text = '', $style = '')
    {
        $this->td = self::common("td", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of tr
     */
    public function getTr()
    {
        return $this->tr;
    }

    /**
     * Set the value of tr
     *
     * @return  self
     */
    public function setTr($id = '', $class = '', $text = '', $style = '')
    {
        $this->tr = self::common("tr", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of colgroup
     */
    public function getColgroup()
    {
        return $this->colgroup;
    }

    /**
     * Set the value of colgroup
     *
     * @return  self
     */
    public function setColgroup($id = '', $class = '', $text = '', $style = '')
    {
        $this->colgroup = self::common("colgroup", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of col
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * Set the value of col
     *
     * @return  self
     */
    public function setCol($id = '', $class = '', $text = '', $style = '')
    {
        $this->col = self::common("col", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of input
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set the value of input
     *
     * @return  self
     */
    public function setInput(
        $id = '',
        $class = '',
        $type = '',
        $value = '',
        $placeHolder = '',
        $disabled = false,
        $style = '',
        $ext=''
    ) {
        if ($disabled) {
            $ext = $ext . "disabled";
        }
        $this->input = self::common("input", $id, $class, $type, "", $style, $value, $placeHolder, $ext);



        return $this;
    }



    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg(
        $id = '',
        $class = '',
        $src = '',
        $width = '',
        $height = '',
        $alt = '',
        $style = '',
        $ext
    ) {
        $ext = $ext . '
         src="' . $src . '" height="' . $height . '" width="' . $width . '" alt="' . $alt . '" 

        ';
        $this->img = self::common("img", $id, $class, "", "", $style, "", "", $ext);
        return $this;
    }

    /**
     * Get the value of form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set the value of form
     *
     * @return  self
     */
    public function setForm($id = '', 
    $class = '', $method = '', $action = '',
     $text, $ext)
    {
        $ext = $ext . ' method="' . $method . '"  action="' . $action . '"

        ';
        $this->form = self::common("form", $id . "_form", $class, '', $text, $style, "","", $ext);

        return $this;
    }

    public function getTableEx()
    {
        return $this->table;
    }

    /**
     * Set the value of li
     *
     * @return  self
     */
    public function setTableEx($id = '', $class = '', $text = '', $style = '')
    {
        $this->table = self::common("table", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of tbody
     */
    public function getTbody()
    {
        return $this->tbody;
    }

    /**
     * Set the value of tbody
     *
     * @return  self
     */
    public function setTbody($id = '', $class = '', $text = '', $style = '')
    {
        $this->tbody = self::common("tbody", $id, $class, '', $text, $style);

        return $this;
    }

    /**
     * Get the value of div
     */
    public function getDiv()
    {
        return $this->div;
    }

    /**
     * Set the value of div
     *
     * @return  self
     */
    public function setDiv($id = '', $class = '', $text = '', $style = '', $ext)
    {
        $this->div = self::common("div", $id, $class, '', $text, $style, "", "", $ext);


        return $this;
    }

    /**
     * Get the value of datalist
     */
    public function getDatalist()
    {
        return $this->datalist;
    }

    /**
     * Set the value of datalist
     *
     * @return  self
     */
    public function setDatalist($id = '', $class = '', $text = '', $style = '', $ext = '')
    {
        $this->datalist = self::common("datalist", $id, $class, '', $text, $style, "", "", $ext);

        return $this;
    }

    /**
     * Get the value of font
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set the value of font
     *
     * @return  self
     */
    public function setFont($id = '', $class = '', $text = '', $size = '', $color = '')
    {
        $ext = '
        size="' . $size . '"
        color="' . $color . '"
        ';
        $this->font = self::common("font", $id, $class, '', $text, $style, "", "", $ext);

        return $this;
    }


    /**
     * Get the value of textarea
     */
    public function getTextareaEx()
    {
        return $this->textarea;
    }

    /**
     * Set the value of textarea
     *
     * @return  self
     */
    public function setTextareaEx($id = '', $class = '', $value = '', $placeHolder = '', $disabled = false, $style = '', $ext)
    {
        if ($disabled) {
            $ext = $ext . 'disabled="disabled"';
        }
        $this->textarea = self::common("textarea", $id, $class, $style, $value, $placeHolder, $ext);

        return $this;
    }
}


?>