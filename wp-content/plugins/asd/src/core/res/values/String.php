<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:07
 */

include 'core/lib/JsonReader.php';


class String
{
    private $lang;

    public function __construct($lang)
    {
        $this->lang = $lang;
    }

    public function Get($key){
       return JsonReader::jsonRead($this->lang)[$key];
    }


}