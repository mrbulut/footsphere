<?php
/*
Türü: Ayakkabı, Terlik
Taban Malzemesi:Kauçuk, PU, TermoKapanış Türü:Geçme, Cırtlı, BağcıklıÜst Malzeme:Deri, Suni Deri, KumaşAstarı Malzemesi:Deri, Kumaş LateksSezon: İlkbahar / Sonbahar, Yaz, Kışİç Taban: Sabit, Çıkarılabilir/Değiştirlebilir
İç Taban Malzemesi: Deri, Sünger, Hafızalı Sünger, PU,




*/
// Veriyi $GLOBAL['config']['mysql']['host']; şeklinde çekiyoruz.
$GLOBALS['config'] = array(
    	'mysql' => array(
            'host' => 'localhost',
            'kullaniciAdi' => 'root',
            'sifre' => '',
            'db' => 'techycompanydb'
        ),
   /*
        'mysql' => array(
            'host' => 'localhost',
            'kullaniciAdi' => 'orthocomfyuser',
            'sifre' => 'BxYkQUq4EVpfZvB',
            'db' => 'orthocomfycomwpdb'
        ),

      	'  'mysql' => array(
      'host' => 'localhost',
      'kullaniciAdi' => 'techycompanyuser',
      'sifre' => '=k}[md62)lP5',
      'db' => 'techycompanydb'
  ),
 */
	'bespoke' => array(
		'tablename' => 'wp_bespoke',
		'bespokerows' => 'userID,boyu,kilosu,yas,footsphereDosyaYolu,ekstraDosyaYolu,kullanilabilirUrunler,bespokeStatus,AyakOlcusu,EkstraBilgi,AyakFotolari', //bespoke veritabanı tablosunun sutunları
		'bespokerowsV' => '1,S,S,S,S,S,S,S,S,S,S' //1 integer, S string , T zaman olduğunu ifade eder.
	),
	'product' => array(
		'tablename' => 'wp_posts',
		'productrows' => 'post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count'
	),//wp_posts product veritabanı tablosunun sutunları
	'contact' => array(
		'tablename' => 'wp_bs_contact',
		'contactrows' => 'userID,mesajSahibi,mesaji,date,Status', //bespoke veritabanı tablosunun sutunları
		'contactrowsV' => '1,S,S,T,1' //1 integer, S string , T zaman olduğunu ifade eder.
	),//wp_posts product veritabanı tablosunun sutunları
	'producer' => array(
		'tablename' => 'wp_bs_producer',
		'producerrows' => 'ureticiAdi,SirketAdi,telefon,telefon2,email,adresi,urunleri,odemeBilgi,kargoBilgi,MinMaxTeklif', //bespoke veritabanı tablosunun sutunları
		'producerrowsV' => 'S,S,1,1,S,S,S,S,S,S' //1 integer, S string , T zaman olduğunu ifade eder.
	),//wp_posts product veritabanı tablosunun sutunları
	'request' => array(
		'tablename' => 'wp_bs_request',
		'requestrows' => 'userID,producerNo,requestNo,urunler,Status,type', //bespoke veritabanı tablosunun sutunları
		'requestrowsV' => '1,1,1,S,1,S' //1 integer, S string , T zaman olduğunu ifade eder.
	),//wp_posts product veritabanı tablosunun sutunları
	'bsproduct' => array(
		'tablename' => 'wp_bs_product',
		'bsproductrows' => 'producerNo,baslik,aciklama,turu,tabanMalzeme,kapanisTuru,ustMalzeme,astarMalzemesi,Sezon,icTabanturu,icTabanMalzemesi,image,Status', //bespoke veritabanı tablosunun sutunları
		'bsproductrowsV' => '1,S,S,S,S,S,S,S,S,S,S,S,1' //1 integer, S string , T zaman olduğunu ifade eder.
	),//wp_
	'footsphere' => array(
		'footsphere_' => 'footsphere_',
		'pages' => 'bespoke,contact,profil,return',
		'sifre' => '',
		'db' => 'yeniDB'
	),

	'social' => array(
		'facebookid' => 'hash',
		'facebooksec' => 'hash',
		'twid' => 'hash',
		'twsec' => 'hash',
		'instid' => 'hash',
		'instsec' => 'hash'

	),

	'projectSession' => array(
		'projectName' => 'hash',
		'projectVersion' => '1.0.0'
	)



);
// Sosyal medya id ve secleri ;
$facebookid = 'add';
$facebooksec = 'add';
$twid = '';
$twsec = '';
$instid = 'hash';
$instsec = 'hash';


require_once __DIR__ . "/database/optionsDB.php";
$db = new optionsDB();
	$db->socialLoginKeys(array($facebookid, $facebooksec, $twid, $twsec, $instid, $instsec)); // facebook giris


	

require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
$db = new bespokeDB();
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");
$db = new contactDB();
require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
$db = new productDB();
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
$db = new producerDB();
require_once(ABSPATH . "wp-content/plugins/footsphere/database/requestDB.php");
$db = new requestDB();
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bsproductDB.php");
$db = new bsproductDB();
require_once __DIR__ . "/bespoke/init.php";



add_action('admin_init', 'registerCssAndJs');

function registerCssAndJs(){
	$arrayCss = array("table","message","bootstrap.min","openPhoto","teklifpage","productshow");
	$arrayJs =array("table","popupwindow","message","bespoke","bootstrap.min","openPhoto","teklifpage","productshow");

	foreach ($arrayCss as $key => $value) {
		registerCss($value);
	}
	foreach ($arrayJs as $key => $value) {
		registerJs($value);
	}
}

function registerCss($name){
    wp_register_style($name, plugins_url('/assets/css/'.$name.'.css', __FILE__));
}
function registerJs($name){
	wp_register_script($name, plugins_url('/assets/js/'.$name.'.js', __FILE__));
}

/// TEŞEKKÜR YAZISINI KALDIRIYOR
function custom_admin_footer() {
	echo '';
	} 
add_filter('admin_footer_text', 'custom_admin_footer');
/// TEŞEKKÜR YAZISINI KALDIRIYOR
































require_once __DIR__ . "/classes/user.php";
require_once __DIR__ . "/database/MysqliDb.php";

$weblink = $_SERVER['REQUEST_URI'];
if ($weblink == "/wp-admin/" || $weblink == "/wp-admin/index.php") {
	$user = new user();
	$db = new MysqliDb();
	$userID = $user->getID();
	$role = $db->getRole()[0];

	if ($role == "editor") {
		header('Location: /wp-admin/admin.php?page=Producer');
		exit();
	}else if($role == "contributor"){
		header('Location: /wp-admin/admin.php?page=index');
		exit();
	}
}
?>