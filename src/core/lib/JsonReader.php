<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:10
 */


class JsonReader
{
    public function jsonRead($fileName)
    {
        $dosyayolu = $fileName;
        $dosya = fopen($dosyayolu, 'r');
        $json = fread($dosya, filesize($dosyayolu));
        $data = json_decode($json, true);
        fclose($dosya);
        return $data;
    }
}