<?php
//$db->urunuKullancidanCikarma(35,2);
//$db->urunuKullancidanCikarma($proID,$userID);
//$db->ureticiEkle("kamil",'05353940074',"a@a.com","eskişehir");

require_once("MysqliDb.php");
require_once ($_SERVER['DOCUMENT_ROOT']  . "/wp-content/plugins/footsphere/lib/config.php");
require_once ($_SERVER['DOCUMENT_ROOT']  . "/wp-content/plugins/footsphere/database/optionsDB.php");

class productDB
{


	private $database;
	private $tableName;
	private $bespokeRows;
	private $__urunID = 0;
	private $__genelSonuc;
	private $footsphere;
	private $pages;
	private $komisyonOrani;
	private $ProducerProductsLimit;

	function __construct()
	{
		$options = new optionsDB();
		$this->komisyonOrani = number_format(explode("%", $options->getKomisyonArea())[0] / 100, 1);
		$this->database = new MysqliDb();
		$this->tableName = config::getConfig('product/tablename');
		$this->bespokeRows = explode(",", config::getConfig('product/productrows'));
		$this->pages = explode(",", config::getConfig('footsphere/pages'));
		$this->footsphere = config::getConfig('footsphere/footsphere_');
		$this->ProducerProductsLimit = $options->getProducerModelLimit();
		self::addPages();
	}


	private function addPages()
	{
		$arrayValue = '';

		for ($i = 0; $i < count($this->pages); $i++) {


			$this->database->where("post_content", '[' . $this->footsphere . $this->pages[$i] . ']');
			if (!$this->database->getOne($this->tableName)["post_content"]) {
				$arrayValue = array(
					1,
					$this->database->now(),
					$this->database->now(),
					'[' . $this->footsphere . $this->pages[$i] . ']',
					ucwords($this->pages[$i]),
					'',
					'publish',
					'closed',
					'closed',
					'',
					$this->footsphere . $this->pages[$i],
					'',
					'',
					$this->database->now(),
					$this->database->now(),
					'',
					0,
					'',
					0,
					'page',
					'',
					0
				);


				self::setAll($arrayValue);
			}



		}
	}
	public function getAll()
	{
		$this->database->where('pinged', "", "!=");
		return $this->database->get($this->tableName);
	}

	public function getAllProductID($productID)
	{
		$this->database->where('ID', $productID);
		return $this->database->get($this->tableName)[0];
	}


	public function getBsProductNo($productNo)
	{

		$this->database->where('ID', $productNo);
		return explode("_", $this->database->getOne($this->tableName)['pinged'])[1];
	}

	public function getAllPROID($producerID = 0)
	{

		$this->database->where('pinged', "bespoke_" . $producerID);
		return $this->database->get($this->tableName);
	}
	public function get($sorgu, $urunID)
	{

		$this->database->where($this->bespokeRows[0], $urunID);
		return $this->database->getOne($this->tableName)[$sorgu];

	}
	public function set($sorgu, $value, $urunID)
	{
		$data = array(
			$sorgu => $value
		);
		$this->database->where($this->bespokeRows[0], $urunID);
		if ($this->database->update($this->tableName, $data))
			return true;
		else
			return false;
	}

	public function getAllList()
	{
		$db = new bespokeDB();
		$usermetaDB = new usermetaDB();
		$milisaniye = $usermetaDB->getAllRequsetUserID(self::getUserID());
		$time = $milisaniye[0]['meta_value'] - time();
		$time = $time / 60 / 60;// Saat cinsinden
		$kalanSureYazi = ceil($time) . " saat";
		if ($time < 1) {
			$time = $time * 60;
			$kalanSureYazi = ceil($kalanSureYazi) . " dakika";
			if ($time <= 0) {
				$time = 0;
			}
		}



		if ($time) {
			$result = $result . 'isteğinizin bitmesine ' . $kalanSureYazi . ' kaldı. bu süre sonunda size uygun ayakkabılar burada listelenecektir. ' . "<b> </b> <br>";

		} else {
			$value = explode(",", $db->getKullanilabilirUrunler());
			if (count($value) > 1) {
				for ($i = 0; $i < count($value) - 1; $i++) {
					$result = $result . " " . self::result($value[$i]) . " <br>";
				}
			} else {
				$result = $result . "<b> Herhangi bir ürün yok! </b> <br>";
			}
		}




		return $result;
	}

	public function setAll($arrayvalue = '', $urunID = '')
	{


		if ($urunID != '') {

			for ($i = 0; $i < count($this->bespokeRows) - 2; $i++) {


				$result[$this->bespokeRows[$i]] = $arrayvalue[$i];

			}


			$this->database->where($this->bespokeRows[0], $urunID);
			$id = $this->database->update($this->tableName, $result);

			if ($id)
				return true;
			else
				return 'insert failed: ' . $this->database->getLastError();


		} else {

			for ($i = 0; $i < count($this->bespokeRows); $i++) {
				$result[$this->bespokeRows[$i]] = 0;
				
			}
	
			$id = $this->database->insert("wp_posts", $result);
			if ($id)
				return $id;
			else
				return 'insert failed: ' . $this->database->getLastError();




		}

	}

	public function addProduct($arrayValue){
		for ($i = 0; $i < count($this->bespokeRows); $i++) {
			$result[$this->bespokeRows[$i]] = $arrayValue[$i];
			
		}

		$id = $this->database->insert("wp_posts", $result);
		if ($id)
			return $id;
		else
			return 'insert failed: ' . $this->database->getLastError();

	}



	public function getProduct($productID)
	{
		$this->database->where("post_parent", $productID);
		$this->database->where("post_type", "attachment");
		$this->__genelSonuc = $this->database->getOne($this->tableName);
	}

	public function getProductID($productID)
	{
		$this->database->where("ID", $productID);
		return $this->database->getOne($this->tableName);
	}


	public function getImageUrl()
	{
		return $this->__genelSonuc["guid"];
	}

	public function getProductLink($productID)
	{
		$this->database->where("ID", $productID);

		return $this->database->getOne($this->tableName)["guid"];
	}

	public function getUserID()
	{
		return $this->database->getUserID();
	}

	public function getName($productID)
	{
		$this->database->where("ID", $productID);

		return $this->database->getOne($this->tableName)["post_title"];
	}
	public function getPostName()
	{
		return $this->__genelSonuc["post_name"];
	}

	public function getDescription($proID)
	{
		$this->database->where("ID", $proID);
		return $this->database->getOne($this->tableName)["post_excerpt"];
	}

	public function getUrunAdi($productID)
	{

		$this->database->where("ID", $productID);
		return $this->database->getOne($this->tableName)["post_title"];

	}



	public function getPrice($productID)
	{
		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "_price");
		return $this->database->getOne("wp_postmeta")["meta_value"];
	}

	public function getOldPrice($productID)
	{
		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "uretici_price");
		return $this->database->getOne("wp_postmeta")["meta_value"];
	}

	public function getStatusUrun($productID)
	{
		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "_statusPostUrun");
		return $this->database->getOne("wp_postmeta")["meta_value"];
	}

	public function setStatusUrun($urunID, $metaValue)
	{

		$this->tableName = "wp_postmeta";

		$anahtar = '_statusPostUrun';
		$this->database->where("post_id", $urunID);
		$this->database->where("meta_key", $anahtar);
		$id = $this->database->getOne("wp_postmeta")["meta_id"];


		$this->bespokeRows = array("post_id", "meta_key", "meta_value");

		if ($id) {
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;


			$this->database->where("meta_id", $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return true;
			else
				return false;


		} else {
			$this->bespokeRows = array("post_id", "meta_key", "meta_value");
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result)
				return $result;
			else
				return false;
		}

	}


	public function getStatus($productID)
	{
		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "_statusPost");
		return $this->database->getOne("wp_postmeta")["meta_value"];
	}

	public function getStatusStatus($status)
	{
		$this->database->where("meta_key", "_statusPost");
		$this->database->where("meta_value", $status);
		return $this->database->get("wp_postmeta");
	}


	public function getAllStatusList($status)
	{
		$list = self::getStatusStatus($status);

		$sonuc = self::getProductID($list[0]['post_id']);




		$array = array();

		for ($i = 0; $i < count($list); $i++) {
			$this->database->where("ID", $list[$i]['post_id']);
			array_push($array, $this->database->getOne($this->tableName));
		}
		$this->database->where("ID", $list[0]['post_id']);

		return $array;



	}

	public function setStatus($urunID, $metaValue)
	{

		$anahtar = '_statusPost';
		$this->database->where("post_id", $urunID);
		$this->database->where("meta_key", $anahtar);
		$id = $this->database->getOne("wp_postmeta")["meta_id"];
		$this->tableName = "wp_postmeta";
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");

		if ($id) {
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;


			$this->database->where("meta_id", $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return true;
			else
				return false;


		} else {
			$this->bespokeRows = array("post_id", "meta_key", "meta_value");
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result)
				return $result;
			else
				return false;
		}

	}

	public function getImageUrlLink($productID)
	{
		$this->database->where("post_parent", $productID);
		return explode("-+-", $this->database->getOne($this->tableName)["guid"]);
	}




	// SETler
	private function now()
	{
		return $this->database->now();
	}

	private function donustur()
	{
		$text = trim($text);
		$search = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ', '.');
		$replace = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '-', '');
		$new_text = str_replace($search, $replace, $text);
		return $new_text;
	}

	private function ImageType($value)
	{
		return "jpg";
	}

	public function getEklenenUrunID()
	{
		return $this->__urunID;
	}
	public function urunEklemek(
		$urunBasligi,
		$kisaAciklamasi,
		$imageUrl,
		$imageName,
		$price,
		$userID,
		$productID
	) {

		
		$this->database->where("post_title", $urunBasligi);
		$this->database->where("post_excerpt", $kisaAciklamasi);
		$this->database->where("guid", $imageUrl);
		$this->database->where("pinged", "bespoke_" . $productID);


		if ($this->database->getOne("wp_posts")["ID"]) {
			//echo "string............st.............st.. sonuc = URUN VAR!!!";
		} else {

			self::urukEkle($urunBasligi, $kisaAciklamasi, $imageUrl, $imageName, $price, $userID, $productID);
		}
	}



	public function urunSilmek($productID)
	{
		self::urunSil($productID);
	}

	public function urunGuncelleme($productID, $urunBasligi, $kisaAciklamasi, $price)
	{

		$oldprice = $price;
		$price = $price + $price * $this->komisyonOrani;
		$this->database->where("id", $productID);

		$result['post_title'] = $urunBasligi;
		$result['post_excerpt'] = $kisaAciklamasi;

		//$result['guid'] = $imageUrl;
		//$result['pinged'] = "bespoke_".$producerID;


		$this->database->update($this->tableName, $result);

		
		// Ücreti güncelleme //

		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "_price");
		$resultPrice['meta_value'] = $price;

		$this->database->update("wp_postmeta", $resultPrice);

			// Üretici Ücreti güncelleme //

		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "uretici_price");
		$resultOldPrice['meta_value'] = $oldprice;

		$this->database->update("wp_postmeta", $resultOldPrice);

	}
	public function urukEkle(
		$urunBasligi,
		$kisaAciklamasi,
		$imageUrl,
		$imageName,
		$price,
		$userID,
		$producerID = -1
	) {
		
		require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
		$price = $lang->localToUsd($price);


		$randomSayi = rand(2, 500340);
		$oldprice = $price;

		$price = $price + $price * $this->komisyonOrani;



		$proID = self::addProduct(array(
			1, 
			self::now(),
			 self::now(), 
			 '',
			$urunBasligi,
			$kisaAciklamasi,
			'publish',
			'open',
			'closed',
			'',
			$producerID . "" . $randomSayi . "" . $price,
			'',
			'bespoke_' . $producerID,
			self::now(),
			self::now(),
			'',
			0,
			"/product/" . $producerID . "" . $randomSayi . "" . $price,
			0,
			'product',
			'',
			0
		));

		$this->__urunID = $proID;

		if ($proID) {

			$imageUrl = explode("+-+",$imageUrl)[1];

			$array = array(
				'1',
				self::now(),
				self::now(),
				'',
				$imageName,
				'',
				'inherit',
				'open',
				'closed',
				'',
				$imageName,
				'',
				'',
				self::now(),
				self::now(),
				'',
				$proID,
				$imageUrl,
				0,
				'attachment',
				'image/' . self::ImageType($imageUrl),
				0
			);
			if (self::setAll($array)) {
				if (self::urunEkleWPOptions($proID)) {
					if (self::urunEkleWPmetaTag($proID, $price, $oldprice, $userID)) {
						if (self::urunuKullaniciyaEkleme($proID,$userID)) {
						//self::addStatusProduct($proID);
							return $proID;
						} else {
							return false;
						}
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;

		}

	}

	public function addStatusProduct($post_id)
	{
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");
		$result[$this->bespokeRows[0]] = $post_id;
		$result[$this->bespokeRows[1]] = "_statusPost";
		$result[$this->bespokeRows[2]] = 0;

	// idyi geri döndürür.
		$result = $this->database->insert($this->tableName, $result);
		if ($result)
			return $result;
		else
			return false;
	}

	public function getStatusProduct($post_id)
	{
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");
		$this->database->where("post_id", $post_id);
		$this->database->where("meta_key", "_statusPost");
		return $this->database->get("wp_postmeta");

	}




	public function updateStatusProduct($post_id, $meta_value)
	{
		$this->database->where("post_id", $post_id);
		$this->database->where("meta_key", "_statusPost");

		$id = $this->database->getOne("wp_postmeta")["meta_id"];


		$this->bespokeRows = array("post_id", "meta_key", "meta_value");
		$result[$this->bespokeRows[0]] = $post_id;
		$result[$this->bespokeRows[1]] = "_statusPost";
		$result[$this->bespokeRows[2]] = $meta_value;


		$this->database->where("meta_id", $id);
		$result = $this->database->update($this->tableName, $result);

		if ($result)
			return true;
		else
			return false;
	}



	private function urunSil($productID)
	{
	//	$db = new bespokeDB();
	//	$db->urunSil($productID);
		$this->database->where("ID", $productID);

		if ($this->database->delete($this->tableName)) {
			$this->database->where("post_parent", $productID);
			return $this->database->delete($this->tableName);
		}
	}


	public function varmiYokmuKontrol()
	{
		$dbDB = new bespokeDB();
		$value = explode(",", $dbDB->getKullanilabilirUrunler());
		$result = false;
		if (count($value) > 1) {
			for ($i = 0; $i < count($value) - 1; $i++) {
				$this->database->where("ID", $value);
				if ($this->database->getOne($this->tableName)['ID']) {
					$result = true;
				}
			}
		}
		return $result;
	}


	private function kullaniciYaEkle($proID,$uid)
	{
		$bespoke_DB = new bespokeDB();
		return $bespoke_DB->setKullanilabilirUrunler($proID,$uid);
	}

	private function urunEkleWPOptions($urunID)
	{
		$this->tableName = "wp_options";
		$this->bespokeRows = array("option_name", "option_value", "autoload");
		$dizi = array(
			"_transient_wc_related_" . $urunID => 'a:1:{s:50:"limit=3&exclude_ids%5B0%5D=0&exclude_ids%5B1%5D=' . $urunID . '";a:0:{}}',
			"_transient_timeout_wc_related_" . $urunID => '1542867624'
		);

		$result = true;
		foreach ($dizi as $anahtar => $deger) {
			if (self::wpOptionsSetallOver($anahtar, $deger, $urunID) > 0) {
			} else {
				$result = false;
			}
		}





		return $result;

	}


	private function getMetaID($postID)
	{
		$result = 0;
		$this->database->where("post_id", $postID);
		$this->database->where("meta_key", "siparisEkstraBilgisi");

		$result = $this->database->getOne("wp_postmeta")["meta_id"];
		return $result;
	}



	public function getSepetEksBilgi($productID)
	{
		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "siparisEkstraBilgisi");
		return $this->database->getOne("wp_postmeta")["meta_value"];
	}

	public function getKargoTarihBilgi($productID)
	{
		$this->database->where("post_id", $productID);
		$this->database->where("meta_key", "kargoTarihBilgi");
		return $this->database->getOne("wp_postmeta")["meta_value"];
	}

	public function setKargoTarihBilgi($urunID, $metaValue)
	{

		$anahtar = 'kargoTarihBilgi';
		$this->database->where("post_id", $urunID);
		$this->database->where("meta_key", $anahtar);
		$id = $this->database->getOne("wp_postmeta")["meta_id"];
		$this->tableName = "wp_postmeta";
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");

		if ($id) {
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;


			$this->database->where("meta_id", $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return true;
			else
				return false;


		} else {
			$this->bespokeRows = array("post_id", "meta_key", "meta_value");
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result)
				return $result;
			else
				return false;
		}

	}






	public function setSepetEksBilgi($urunID, $metaValue)
	{

		$anahtar = 'siparisEkstraBilgisi';
		$id = self::getMetaID($urunID);
		$this->tableName = "wp_postmeta";
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");

		if ($id) {
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;


			$this->database->where("meta_id", $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return true;
			else
				return false;


		} else {
			$this->bespokeRows = array("post_id", "meta_key", "meta_value");
			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $metaValue;

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result)
				return $result;
			else
				return false;
		}

	}

	public function urunuKullaniciyaEkleme($productID, $userID)
	{
		$bespoke_DB = new bespokeDB();
		$bespoke_DB->setKullanilabilirUrunler($productID, $userID);

		$this->tableName = "wp_postmeta";
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");

		$arrayy = array(
			'aam-post-access-user' . $userID => 'a:2:{s:13:"frontend.list";s:1:"0";s:13:"frontend.read";s:1:"0";}' // burdan sonrasi izinle alakalı

		);
		$array = array($productID => $arrayy);
		$result = true;
		foreach ($arrayy as $anahtar => $deger) {
			if (self::setAllOver($anahtar, $deger, $productID) > 0) {
			} else {
				$result = false;
			}
		}
	}

	public function urunuKullancidanCikarma($productID, $userID)
	{
		$bespoke_DB = new bespokeDB();
		$bespoke_DB->urunSil($productID, $userID);
		$this->tableName = "wp_postmeta";
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");

		$arrayy = array(
			'aam-post-access-user' . $userID => '' // burdan sonrasi izinle alakalı

		);
		$array = array($productID => $arrayy);
		$result = true;
		foreach ($arrayy as $anahtar => $deger) {
			if (self::setAllOver($anahtar, $deger, $productID) > 0) {
			} else {
				$result = false;
			}
		}
	}



	private function urunEkleWPmetaTag($urunID, $price, $oldprice, $userID, $satinAlmaNotu = '')
	{
		$this->tableName = "wp_postmeta";
		$this->bespokeRows = array("post_id", "meta_key", "meta_value");
		$arrayy = array(
			"_wc_review_count" => '0',
			"_wc_rating_count" => 'a:0:{}',
			"_wc_average_rating" => '0',
			"_edit_lock" => '1542781539:1',
			"_edit_last" => '1',
			"_thumbnail_id" => '9',
			"_sku" => '',
			"_regular_price" => $price,
			"_sale_price" => '',
			"_sale_price_dates_from" => '',
			"_sale_price_dates_to" => '',
			"total_sales" => '',
			"_tax_status" => 'taxable',
			"_tax_class" => '',
			"_manage_stock" => 'no',
			"_backorders" => 'no',
			"_low_stock_amount" => '',
			"_sold_individually" => 'no',
			"_weight" => '',
			"_length" => '',
			"_width" => '',
			"_height" => '',
			"_upsell_ids" => 'a:0:{}',
			"_crosssell_ids" => 'a:0:{}',
			"_purchase_note" => $satinAlmaNotu,
			"_default_attributes" => 'a:0:{}',
			"_virtual" => 'no',
			"_downloadable" => 'no',
			"_product_image_gallery" => '',
			"_download_limit" => '-1	',
			"_download_expiry" => '-1',
			"_stock" => '',
			"_stock_status" => 'instock',
			'_product_version' => '3.5.1',
			'_price' => $price,
			'uretici_price' => $oldprice,
			'aam-post-access-visitor' => 'a:2:{s:13:"frontend.list";s:1:"1";s:13:"frontend.read";s:1:"1";}',
			'aam-post-access-rolesubscriber' => 'a:2:{s:13:"frontend.list";s:1:"1";s:13:"frontend.read";s:1:"1";}',
			'aam-post-access-user' . $userID => 'a:2:{s:13:"frontend.list";s:1:"0";s:13:"frontend.read";s:1:"0";}'
			 // burdan sonrasi izinle alakalı
		);
		$array = array($urunID => $arrayy);
		$result = true;
		foreach ($arrayy as $anahtar => $deger) {

			if (self::setAllOver($anahtar, $deger, $urunID) > 0) {
			} else {
				$result = false;
			}
		}



		return $result;

	}

	private function setAllOver($anahtar, $deger, $urunID = 0)
	{
		if ($urunID == 0) {
			$this->database->where($this->bespokeRows[0], $urunID);

			if ($this->database->getOne($this->tableName)) {

				$result[$this->bespokeRows[0]] = $urunID;
				$result[$this->bespokeRows[1]] = $anahtar;
				$result[$this->bespokeRows[2]] = $deger;


				$this->database->where($this->bespokeRows[0], $urunID);
				$id = $this->database->update($this->tableName, $result);

				if ($id)
					return true;
				else
					return 'insert failed: ' . $this->database->getLastError();


			} else {

				$result[$this->bespokeRows[0]] = $urunID;
				$result[$this->bespokeRows[1]] = $anahtar;
				$result[$this->bespokeRows[2]] = $deger;
		// idyi geri döndürür.
				$id = $this->database->insert($this->tableName, $result);
				if ($id)
					return $id;
				else
					return 'insert failed: ' . $this->database->getLastError();
			}
		} else {

			$result[$this->bespokeRows[0]] = $urunID;
			$result[$this->bespokeRows[1]] = $anahtar;
			$result[$this->bespokeRows[2]] = $deger;
		// idyi geri döndürür.
			$id = $this->database->insert($this->tableName, $result);
			if ($id)
				return $id;
			else
				return 'insert failed: ' . $this->database->getLastError();

		}


	}

	private function wpOptionsSetallOver($anahtar, $deger, $urunID = 0)
	{
		$this->database->where($this->bespokeRows[0], $urunID);


		if ($this->database->getOne($this->tableName)) {

			$result[$this->bespokeRows[0]] = $anahtar;
			$result[$this->bespokeRows[1]] = $deger;
			$result[$this->bespokeRows[2]] = "yes";


			$this->database->where($this->bespokeRows[0], $urunID);
			$id = $this->database->update($this->tableName, $result);

			if ($id)
				return true;
			else
				return 'insert failed: ' . $this->database->getLastError();


		} else {

			$result[$this->bespokeRows[0]] = $anahtar;
			$result[$this->bespokeRows[1]] = $deger;
			$result[$this->bespokeRows[2]] = "yes";
		// idyi geri döndürür.
			$id = $this->database->insert($this->tableName, $result);
			if ($id)
				return $id;
			else
				return 'insert failed: ' . $this->database->getLastError();
		}
	}

	public function kullanilabilirUrunleriGetir()
	{
		$this->databaseBespoke = new bespokeDB();
		if ($this->databaseBespoke->durumKontrol()) {
			if ($this->databaseBespoke->getBespokeStatus() == "closed" || $this->databaseBespoke->getBespokeStatus() == "") {
				$result = false;
			} else {
				$result = self::getAllList();
			}
		} else {
			$result = $this->databaseBespoke->profilDoldurmalisin();
		}

		return $result;
	}

	private function result($productNumber)
	{

		self::getProduct($productNumber);
		$imgUrl = explode("-+-", self::getImageUrl())[0];
		$urunAdi = self::getUrunAdi($productNumber);
		$postName = self::getPostName();
		$urunFiyati = self::getPrice($productNumber);
		$description = self::getDescription($productNumber);
		//echo "string***********************-88-8-8--?===" .$urunFiyati;
		$result = '


		<div class="row">  
		<main id="main" class="col-sm-8 col-md-9 content-holder">
		<div class="products-container clearfix ">
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("<span class="mg-brand-wrapper mg-brand-wrapper-product"><a href="http://www.orthocomfy.com/brands/orthocomfy/">Orthocomfy</a></span>").insertBefore(".woocommerce-tabs");
			});
			</script>
			<section class="section_offset">

			<div class="clearfix">

			<div id="product-' . $productNumber . '" class="product post-' . $productNumber . ' type-product status-publish has-post-thumbnail product_cat-dibaetic product_cat-wide product_cat-men first instock shipping-taxable purchasable product-type-variable has-default-attributes">

			<div class="single_product images">








			<div>
			<img width="250" height="300" src="' . $imgUrl . '" class="wp-post-image" > 
			</div>


			</div><!--/ .single_product-->

			<div class="single_product_description">



			<h1 name="urunAdi" itemprop="name" class="offset_title">' . $urunAdi . '</h1>
			<!--/ .page-nav-->






			<hr>

	
			<p class="product_price"><b><span class="woocommerce-Price-amount amount">' . $urunFiyati . '&nbsp;<span class="woocommerce-Price-currencySymbol">$</span></span></b></p>
			<form  class="variations_form cart"  method="POST" enctype="multipart/form-data" data-product_id="' . $productNumber . '" data-product_variations="" current-image="">

			<div class="tab_container" id="tab-description">
			<h5><br>' . $description . '<br></h5>
			</div>
			<div>
		
			
			
			<textarea name="satinAlmaNot" placeholder="Post your Comment Here ..." cols="40" rows="6" class="wpcf7-form-control wpcf7-textarea" required="required">' . self::getSepetEksBilgi($productNumber) . '</textarea>

			
</div>

			<div class="single_variation_wrap">
			<div class="woocommerce-variation single_variation" style="display: none;"></div>   <div class="variations_button">

			<!--/ .description-table-->
			<br>
			<br>
			
		    

			<button type="submit" name="satinAlmaButton" class="single_add_to_cart_button button alt disabled wc-variation-selection-needed">Add to cart</button>


			<input type="hidden" name="add-to-cart" value=" ' . $productNumber . '">
			<input type="hidden" name="product_id" value=" ' . $productNumber . '">

			</form>
			</div>
			</div>

			</div><!--/ .single_product_description-->

			</div><!-- #product-104 -->

			</div><!--/ .clearfix-->

			</section><!--/ .section_offset-->

			<div class="clear"></div>













			</div><!--/ .products-container-->



			</main>
			</div>
			</div>



			';
		return $result;
	}


	public function getProducerProductLimit()
	{
		return $this->ProducerProductsLimit;
	}

}
?>