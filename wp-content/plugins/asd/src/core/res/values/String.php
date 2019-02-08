<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:07
 */

include_once ROOT_PATH.'/src/core/lib/JsonReader.php';


class StringReader
{
    private $lang;

    private $array;

    public function __construct($lang)
    {
        $this->lang = $lang;
        $filePath = ROOT_PATH . "/src/core/res/values/language/" . $lang . ".json";
        self::setArray(JsonReader::jsonRead($filePath));
    }

    public function Get($key){
        return self::getArray()[$key];
    }

    public function getArray()
    {
        return $this->array;
    }

    public function setArray($array)
    {
        $this->array = $array;
    }

}