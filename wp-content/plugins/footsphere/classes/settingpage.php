<?php

require_once(ABSPATH . "wp-content/plugins/footsphere/classes/page.php");

class settingpage extends page
{
    private $first;
    private $last;
    private $onclick;
    private $result;
    private $component;

    function __construct($id, $name, $baslik, $js, $css)
    {
        if ($js) {
            self::addjscode($js);
        }
        if ($css) {
            self::addcsscode($css);
        }

        $this->first = '
        <form method="post" action="" novalidate="novalidate"><table class="form-table"><tbody>';
        $this->last = '</tbody></table><p class="submit"><input type="submit" name="' . $id . '" id="' . $id . '" class="button button-primary" value="' . $name . '"></p></form>
        ';

        self::setBaslik($baslik);

    }

    public function setAllRows($arrayValue)
    {
        for ($i = 0; $i < count($arrayValue); $i++) {
            self::setRows($arrayValue[$i]);
        }
    }

    public function setRows($arrayValue)
    {
        $result;


        for ($i = 0; $i < count($arrayValue); $i++) {

            $request = '';
            $typ = $arrayValue[$i]['type'];
            if ($typ == "text" || $typ == "email" || $typ == "url" || $typ == "textarea" || $typ == "password") {
                $request = self::getInputtextPro($arrayValue[$i]['id'], $arrayValue[$i]['type'], $arrayValue[$i]['name'], $arrayValue[$i]['desc'], $arrayValue[$i]['disabled'], $arrayValue[$i]['value']);
            } else if ($arrayValue[$i]['type'] == "checkbox") {
                $request = self::getProCheckbox($arrayValue[$i]['id'], $arrayValue[$i]['name'], $arrayValue[$i]['desc']);

            } else if ($arrayValue[$i]['type'] == "radiobutton") {
                $request = self::getProRadioButton($arrayValue[$i]['id'], $arrayValue[$i]['name'], $arrayValue[$i]['desc'], $arrayValue[$i]['arrayValue']);

            } else if ($arrayValue[$i]['type'] == "popupmenu") {
                $request = self::getProPopupMenu($arrayValue[$i]['id'], $arrayValue[$i]['name'], $arrayValue[$i]['desc'], $arrayValue[$i]['arrayValue']);

            } else if ($arrayValue[$i]['type'] == "label"){
                $request = self::getLabel($arrayValue[$i]['id'],$arrayValue[$i]['name'], $arrayValue[$i]['size']);
            } else {
                $request = '';
            }

            $result = $result . $request;


        }



        self::setPage($result);

    }


    public function getPage()
    {
        return $this->first . ' ' . $this->result . ' ' . $this->last;
    }

    public function setPage($result)
    {

        $this->result = $this->result . $result;
        page::setRows($this->first . ' ' . $this->result . ' ' . $this->last);

    }
}


?>