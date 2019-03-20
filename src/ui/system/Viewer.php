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
            include ROOT_PATH . '/src/ui/app/views/templates/header.php';
            include $FileName;
            include ROOT_PATH . '/src/ui/app/views/templates/footer.php';

        }
    }

    public function viewShortCode($shortcode){

        add_shortcode( "footsphere_bespoke", 'Bespoke');

        function Bespoke(){
            ob_start();
            include( ROOT_PATH.'/src/ui/app/views/templates/header.php' );
            $output = ob_get_contents();;
            ob_end_clean();
            return $output;
        }
    }
}