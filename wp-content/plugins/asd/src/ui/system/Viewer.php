<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 15:17
 */


class Viewer
{
    public function __construct()
    {

    }


    public function view($str,$data=false){
        $FileName = ROOT_PATH.'/src/ui/app/views/'.$str.'.php';
        if(file_exists($FileName)){
            include ROOT_PATH.'/src/ui/app/header.php';
            include $FileName;
            include ROOT_PATH.'/src/ui/app/footer.php';

        }
    }
}