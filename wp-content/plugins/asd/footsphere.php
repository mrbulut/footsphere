<?php

/**
Plugin Name: DENEMEPLGUSİB
Plugin URI: techsy.worksd
Description: XSXSs
Author: ^'+!'¡2£#>233
Version: 11.0
Author URI: ---
License: MIT
 **/
//SETUP MUST //
define('ABSPATH',dirname(__FILE__)."/../../../");

define('ROOT_PATH',__DIR__);

add_action('admin_menu', 'fs_modifymenu');

function fs_modifymenu()
{
    add_menu_page(
        "Footsphere", //page title
        "Footsphere", //menu title
        'edit_posts', //capabilities
        'footsphere',//menu slug
        'my_custom_menu_page' //function
    //icon
    );
}

function my_custom_menu_page(){
    include ROOT_PATH . '/src/ui/autoloader.php';
}



/*
 *
 *
 * herşeyi ezberinden söylüyon
 * rap yaptığını sanıyon
 * şimdi bana kulak veriyon
 * izle seni nasıl sikiyom
 *
 *
 * trap trap
 *
 * bitti mi sanıyon
 * bomba gibi geliyom
 *
 * beat beat
 *
 * ordan burdan çaldığın sözleri
 * gelip bana satıyon
 * ben bunu takmıyom
 * çünkü seni böyle bile sikiyom
 *
 * trap trap
 *
 * bitti mi sanıyon
 * kusura bakma biraz geç geliyom
 *
 * beat beat
 *
 * yaptığın rap değil
 * sadece bana küfür ediyon
 * şimdi seni anlıyom
 * sen beni kıskanıyon
 *
 *
 * trap trap
 *
 * tamam tamam bitiriyom
 * biliyom sana ağır geliyom
 *
 * beat beat
 *
 *
 * şimdi ağlıcan biliyom
 * rapi ezberden söylemek sanıyon
 * istersen sana ders vereyim
 * biliyon rapi senden daha iyi biliyom.
 */

?>




