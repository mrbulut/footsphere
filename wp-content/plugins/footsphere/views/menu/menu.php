<?php

define('ROOTDIR', plugin_dir_path(__FILE__));

require_once(ROOTDIR . 'producerspage/contact.php');
require_once(ROOTDIR . 'producerspage/dashboard.php');
require_once(ROOTDIR . 'producerspage/order.php');
require_once(ROOTDIR . 'producerspage/profil.php');
require_once(ROOTDIR . 'producerspage/products.php');
require_once(ROOTDIR . 'producerspage/request.php');

require_once(ROOTDIR . 'adminpage/page/settings.php');
require_once(ROOTDIR . 'adminpage/page/dashboard.php');
require_once(ROOTDIR . 'adminpage/page/index.php');
require_once(ROOTDIR . 'adminpage/page/contact.php');
require_once(ROOTDIR . 'adminpage/page/request.php');
require_once(ROOTDIR . 'adminpage/page/producer.php');
require_once(ROOTDIR . 'adminpage/page/products.php');
require_once(ABSPATH . "wp-content/plugins/footsphere/views/page/message.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/views/page/lastrequest.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/views/page/teklifver.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/languages/languages.php");


	

//menu items
//add_action('admin_menu','fs_modifymenu');
add_action('admin_menu', 'fs_modifymenu');
add_action('admin_menu', 'fs_function_producer');

function fs_modifymenu()
{
	$langg = new languages(0);
	$dil = $langg->getDil();
	//this is the main item for the menu
	add_menu_page(
		$dil['menu_producer_dashboard'], //page title
		$dil['menu_producer_dashboard'], //menu title
		'edit_posts', //capabilities
		'index',//menu slug
		'footsphere' //function
    //icon
	);
    //function
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(
		index, //parent slug
		$dil['menu_editor_ayarlar'], //page title
		$dil['menu_editor_ayarlar'],//menu title
		'edit_posts', //capability
		'settings', //menu slug
		'settings'
	); //function


	add_submenu_page(
		index, //parent slug
		$dil['menu_producer_istek'], //page title
		$dil['menu_producer_istek'],//menu title
		'edit_posts', //capability
		'request_adminpage', //menu slug
		'request_adminpage'
	); //function

	add_submenu_page(
		index, //parent slug
		$dil['menu_producer_iletisim'], //page title
		$dil['menu_producer_iletisim'],//menu title
		'edit_posts', //capability
		'contact', //menu slug
		'contact'
	); //function

	add_submenu_page(
		index, //parent slug
		$dil['menu_editor_ureticiler'], //page title
		$dil['menu_editor_ureticiler'],//menu title
		'edit_posts', //capability
		'producer', //menu slug
		'producer'
	); //function

	add_submenu_page(
		index, //parent slug
		$dil['menu_producer_urunler'], //page title
		$dil['menu_producer_urunler'],//menu title
		'edit_posts', //capability
		'products', //menu slug
		'products'
	); //function

	  	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(
		0, //parent slug
		'message', //page title
		'message', //menu title
		'edit_posts', //capability
		'message', //menu slug
		'message'
	); //function

	  	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(
		0, //parent slug
		'lastrequest', //page title
		'lastrequest', //menu title
		'edit_posts', //capability
		'lastrequest', //menu slug
		'lastrequest'
	); //function

	add_submenu_page(
		0, //parent slug
		'teklifver', //page title
		'teklifver', //menu title
		'edit_posts', //capability
		'teklifver', //menu slug
		'teklifver'
	); //function
}

function fs_function_producer()
{

	$lang = new languages(0);
	$dil = $lang->getDil();

	add_menu_page(
		$dil['menu_producer_dashboard'], //page title
		$dil['menu_producer_dashboard'],
		'edit_posts', //capabilities
		'Producer',//menu slug
		'producer_dash' //function
    //icon
	);

	add_submenu_page(
		Producer, //parent slug
		$dil['menu_producer_istek'], //page title
		$dil['menu_producer_istek'],//menu title
		'edit_posts', //capability
		'producer_request', //menu slug
		'producer_request'
	); //function

	add_submenu_page(
		Producer, //parent slug
		$dil['menu_producer_siparis'], //page title
		$dil['menu_producer_siparis'],//menu title
		'edit_posts', //capability
		'producer_order', //menu slug
		'producer_order'
	); //function

	add_submenu_page(
		Producer, //parent slug
		$dil['menu_producer_urunler'], //page title
		$dil['menu_producer_urunler'],
		'edit_posts', //capability
		'producer_products', //menu slug
		'producer_products'
	); //function

	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(
		Producer, //parent slug
		$dil['menu_producer_profil'], //page title
		$dil['menu_producer_profil'],
		'edit_posts', //capability
		'producer_profil', //menu slug
		'producer_profil'
	); //function

	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(
		Producer, //parent slug
		$dil['menu_producer_iletisim'], //page title
		$dil['menu_producer_iletisim'], //menu title
		'edit_posts', //capability
		'producer_contact', //menu slug
		'producer_contact'
	); //function

}



?>
