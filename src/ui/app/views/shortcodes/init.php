<?php
/**
 * Created by PhpStorm.
 * User: iksmtr
 * Date: 19.03.2019
 * Time: 17:00
 */

// is creating shortcodes
add_shortcode( "footsphere_bespoke", 'addBespokePage');
add_shortcode( "footsphere_message", 'addContactPage');
add_shortcode( "footsphere_profil", 'addProfilPage');

function addBespokePage(){
    ob_start();

    include ROOT_PATH.'/src/ui/app/views/shortcodes/header.php';
    include ROOT_PATH.'/src/ui/app/views/shortcodes/product/product.php';
    include ROOT_PATH.'/src/ui/app/views/shortcodes/footer.php';
    $output = ob_get_contents();;
    ob_end_clean();
    return $output;
}

function addProfilPage(){
    ob_start();
    include ROOT_PATH.'/src/ui/app/views/shortcodes/header.php';
    include ROOT_PATH.'/src/ui/app/views/shortcodes/profil/profil.php';
    include ROOT_PATH.'/src/ui/app/views/shortcodes/footer.php';
    $output = ob_get_contents();;
    ob_end_clean();
    return $output;
}
function addContactPage(){
    ob_start();
    include ROOT_PATH.'/src/ui/app/views/shortcodes/header.php';
    include ROOT_PATH.'/src/ui/app/views/shortcodes/message/message.php';
    include ROOT_PATH.'/src/ui/app/views/shortcodes/footer.php';
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

// it is creating pages shortcodes'    add pages like in this "[footsphere_bespoke]"
include ROOT_PATH.'/src/data/concrete/ProductDal.php';
$wpPostDal = new wp_postsDal();
$wpPostDal->AddedallPages();



include_once ROOT_PATH . "/src/ui/app/models/UserModel.php";
include_once ROOT_PATH . "/src/ui/app/models/OptionsModel.php";
include_once ROOT_PATH . "/src/core/lib/Session.php";



$userId=null;
$session = new Session();

$user = new UserModel();
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $userId = $current_user->ID;
}



if (!$session->isthere("role")){
    if($user->getRole()=="administrator" || $user->getRole()=="contributor"){
        $session->create("role", "operationmanager");
    }else if ($user->getRole()=="editor"){
        $session->create("role", "producer");
    }else if ($user->getRole()=="subscriber"){
        $session->create("role", "customer");
    }
}



$options = new OptionsModel();

if($options->getLangueages()){
    if(!$session->isthere("lang")){
        $session->create("lang", $options->getLangueages());
    }
}else{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
    $options->setLangueages($lang);
    $session->create("lang",$lang);
}

include_once ROOT_PATH.'/src/core/res/values/GeneralCons.php';


$get = new GeneralCons($_SESSION['lang']);
$_SESSION['role'];
$GLOBALS['string'] = $get->StringAll();

$GLOBALS['PriceSymbol'] = $get->getCurrencySymbol();
$GLOBALS['PriceShortCode'] = $get->getCurrency();

$GLOBALS['userId'] =$userId;








?>