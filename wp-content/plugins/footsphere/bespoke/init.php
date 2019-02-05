<?php  

require_once ABSPATH."wp-content/plugins/footsphere/database/MysqliDb.php";
require_once ABSPATH."wp-content/plugins/footsphere/lib/config.php";

$pages =explode(",",config::getConfig('footsphere/pages'));
$footsphere = config::getConfig('footsphere/footsphere_');

add_shortcode( $footsphere.$pages[0], 'addBespokePage');  
add_shortcode( $footsphere.$pages[1], 'addContactPage');  
add_shortcode( $footsphere.$pages[2], 'addProfilPage');  
add_shortcode( $footsphere.$pages[3], 'addReturnPage');  

function addBespokePage(){
	ob_start();
	include( 'page/bespoke.php' );
	$output = ob_get_contents();;
	ob_end_clean();
	return $output;
}

function addProfilPage(){
	ob_start();
	include( 'page/profil.php' );
	$output = ob_get_contents();;
	ob_end_clean();
	      return $output;
  } 
function addContactPage(){
	ob_start();
	include( 'page/contact.php' );
	$output = ob_get_contents();;
	ob_end_clean();
	return $output;
}
function addReturnPage(){
	ob_start();
	include( 'page/return.php' );
	$output = ob_get_contents();;
	ob_end_clean();
	return $output;
}


?>