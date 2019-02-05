<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:03
 */

class Filter
{
    function on($string){
        return htmlentities($string,ENT_QUOTES,'UTF-8');
    }
}