<?php 

require_once("MysqliDb.php");
require_once ABSPATH . "wp-content/plugins/footsphere/lib/config.php";
require_once(ABSPATH . "wp-content/plugins/footsphere/languages/languages.php");

/**
 *
 $database = new bespokeDB();

 echo "User number ,,,,,, loggedin=".$database->setAll(array(1,"2","3","4","5"));
 echo "User number ,,,,,, loggedin=".$database->getAll()['boyu'];
 echo "User number ,,,,,, loggedin=".$database->getBoyu();
 echo "User number ,,,,,, loggedin=".$database->setBoyu(23);
 echo "User number ,,,,,, loggedin=".$database->userINFO() //array;
 */
/*
echo  $db->userINFO()[0]  ; // userid
echo  $db->userINFO()[1]  ; //Email
echo  $db->userINFO()[2]  ; //Adi
echo  $db->userINFO()[3]  ; //Soyadi
echo  $db->userINFO()[4]  ; // KullaniciAdi
echo  $db->getAll()['boyu']  ;
echo  $db->getAll()['kilosu']  ;
echo  $db->getAll()['footsphereDosyaYolu']  ;
echo  $db->getAll()['ekstraDosyaYolu']  ;
$r = (1 == $v) ? 'Yes' : 'No'; // $r is set to 'Yes'
 */
class bespokeDB
{

	private $ID,
		$userID,
		$boy,
		$kilo,
		$fsDosyaYolu,
		$ekstraDosyaYolu,
		$statusAyakkabi,
		$statusTerlik;

	private $database;
	private $tableName;
	private $bespokeRows;

	function __construct()
	{
		$this->database = new MysqliDb();
		$this->tableName = config::getConfig('bespoke/tablename');
		$this->bespokeRows = explode(",", config::getConfig('bespoke/bespokerows'));
		$this->bespokeRowsV = explode(",", config::getConfig('bespoke/bespokerowsV'));
		self::createTable();//eğer veritabanı yoksa oluşturuyor.
		self::setlangueages();
		self::Status();
		wp_enqueue_script('bespoke'); 
 

	}

	
		# tarayıcı dilini veritabanına yazdırıyor.
	public function getLangueages($userID)
	{
		$this->database->where("user_id", $userID);
		$this->database->where("meta_key", 'footsphere_lang');
		return languages::getLang($this->database->getOne("wp_usermeta")['meta_value']);;
	}

	public function getLangueagesShort($userID)
	{
		$this->database->where("user_id", $userID);
		$this->database->where("meta_key", 'footsphere_lang');
		return $this->database->getOne("wp_usermeta")['meta_value'];;
	}

	public function getRole($userID)
	{
		$this->database->where("user_id", $userID);
		$this->database->where("meta_key", 'wp_capabilities');
		return explode('"', $this->database->getOne("wp_usermeta")['meta_value'])[1];;
	}

	public function setlangueages($userID = 0)
	{

		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if ($userID == 0) {
			$userID = self::userID();
		}

		

		if($userID!=0){
			$result = array(
				'user_id' => $userID,
				'meta_key' => 'footsphere_lang',
				'meta_value' => $lang
			);
			$this->database->where("user_id", $userID);
			$this->database->where("meta_key", 'footsphere_lang');
			if (!$this->database->getOne("wp_usermeta")['umeta_id']) {
				return $id = $this->database->insert("wp_usermeta", $result);
			}
		}
		
	}




	public function getBoyu()
	{
		return self::get($this->bespokeRows[1]);
	}
	public function setBoyu($value)
	{
		return self::set($this->bespokeRows[1], $value);
	}

	public function getKilo()
	{
		return self::get($this->bespokeRows[2]);
	}

	public function setKilo($value)
	{
		return self::set($this->bespokeRows[2], $value);
	}

	public function getYas()
	{
		return self::get($this->bespokeRows[3]);
	}

	public function setYas($value)
	{
		return self::set($this->bespokeRows[3], $value);
	}

	public function getFSDyolu()
	{
		return self::get($this->bespokeRows[4]);
	}

	public function setFSDyolu($value)
	{
		return self::set($this->bespokeRows[4], $value);
	}

	public function getEksDosyaYolu($where)
	{
		return explode("+-+", self::get($where));
	}

	public function getEksUploadedFile($where)
	{

		if ($where == "extra") {
			$array = self::getEksDosyaYolu($this->bespokeRows[5]);
		} else if ($where == "uphoto") {
			$array = self::getEksDosyaYolu($this->bespokeRows[10]);
		}
		$result;
		for ($i = 1; $i < count($array); $i++) {
			$name = explode("/", $array[$i])[5];
			$link = $_SERVER['SERVER_NAME'] . $array[$i];
			$result[$name] = $link;
		}
		return $result;
	}

	public function setEksDosyaYolu($values, $where)
	{
		if ($where == "extra") {
			$array = self::getEksDosyaYolu($this->bespokeRows[5]);
		} else if ($where == "uphoto") {
			$array = self::getEksDosyaYolu($this->bespokeRows[10]);
		}
		$isEqual = false;
		$result = '';
		for ($i = 1; $i < count($array); $i++) {
			$result = "+-+" . $array[$i] . $result;
			if (self::isEqual($array[$i], $values))
				$isEqual = true;
		}
		$result = $result . $values;
		if (!$isEqual) {
			if ($where == "extra") {
				return self::set($this->bespokeRows[5], $result);
			} else if ($where == "uphoto") {
				return self::set($this->bespokeRows[10], $result);
			}
		} else {
			return false;
		}
	}

	public function isEqual($a1, $a2)
	{
		$a1 = explode("/", $a1);
		$a1 = $a1[count($a1) - 1];
		$a2 = explode("/", $a2);
		$a2 = $a2[count($a2) - 1];
		if ($a1 == $a2) {
			return true;
		} else {
			return false;
		}
	}

	public function getKullaniciFotolari()
	{
		return self::get($this->bespokeRows[10]);
	}

	public function setKullaniciFotolari($values)
	{
		return self::set($this->bespokeRows[10], self::getKullaniciFotolari() . $values . ",");
	}

	public function getKullanilabilirUrunler($userID = -1)
	{
		return self::get($this->bespokeRows[6], $userID);
	}

	public function setKullanilabilirUrunler($values, $userID = -1)
	{
		return self::set($this->bespokeRows[6], self::getKullanilabilirUrunler($userID) . $values . ",", $userID);
	}



	public function getAyakOlcusu()
	{
		return self::get($this->bespokeRows[8]);
	}

	public function setAyakOlcusu($values)
	{
		return self::set($this->bespokeRows[8], $values);
	}
	public function getEkstraBilgi()
	{
		return self::get($this->bespokeRows[9]);
	}

	public function setEkstraBilgi($values)
	{
		return self::set($this->bespokeRows[9], $values);
	}

	private function get($sorgu, $userID = -1)
	{
		if ($userID == -1) {
			$userID = self::userID();
		}

		$this->database->where($this->bespokeRows[0], $userID);
		return $this->database->getOne($this->tableName)[$sorgu];

	}
	private function set($sorgu, $value, $userID = -1)
	{
		if ($userID == -1) {
			$userID = self::userID();
		}
		$data = array(
			$sorgu => $value
		);
		$this->database->where($this->bespokeRows[0], $userID);
		if ($this->database->update($this->tableName, $data))
			return true;
		else
			return false;
	}

	public function getUrunBekleyen()
	{
		$this->database->where("bespokeStatus", "actived");
		$this->database->where($this->bespokeRows[6], "");
		return $this->database->get($this->tableName, null, "id");

	}

	public function getTotalGuncelleme()
	{
		$this->database->where("bespokeStatus", "update");

		return $this->database->get($this->tableName, null, "id");

	}

	public function getTotalBespokeProduct()
	{
		$ureticiSayisi = self::getTotalPRODUCER();
		$toplam = 0;
		foreach ($ureticiSayisi as $key => $value) {
			$toplam = $toplam + self::getTotalBespokeProductCalculator($value['id']);
		}

		return $toplam;

	}
	private function getTotalBespokeProductCalculator($proID)
	{
		$this->database->where("pinged", "bespoke_" . $proID);
		return count($this->database->get("wp_posts", null, "id"));
	}
	private function getTotalPRODUCER()
	{
		return $this->database->get("wp_bs_producer", null, "id");
	}

	public function getTotalBespokeUser()
	{
		$this->database->where("bespokeStatus", "actived");

		return $this->database->get($this->tableName);

	}

	public function getTamamlanmisKullanicilar()
	{
		$this->database->where("bespokeStatus", "closed");
		return $this->database->get($this->tableName, null, "id");
	}

	public function getTotalUser($tableName = '')
	{
		if ($tableName == '') $tableName = $this->tableName;

		return $this->database->get($tableName);
	}




	public function getAll()
	{
		$this->database->where($this->bespokeRows[0], self::userID());
		return $this->database->getOne($this->tableName);
	}

	public function getAllID($userID)
	{
		$this->database->where($this->bespokeRows[0], $userID);
		return $this->database->getOne($this->tableName);
	}

	public function getAllWpUserID($userID)
	{

		$this->database->where("ID", $userID);

		return $this->database->getOne("wp_users");
	}

	public function setAll($arrayvalue = '')
	{
		$arrayvalue[0] = self::userID();
		$this->database->where($this->bespokeRows[0], self::userID());


		if ($this->database->getOne($this->tableName)) {

			for ($i = 0; $i < count($arrayvalue); $i++) {
				$result[$this->bespokeRows[$i]] = $arrayvalue[$i];

			}


			$this->database->where($this->bespokeRows[0], self::userID());
			$id = $this->database->update($this->tableName, $result);

			if ($id)
				return true;
			else
				return 'insert failed: ' . $this->database->getLastError();


		} else {
			for ($i = 0; $i < count($arrayvalue); $i++) {


				$result[$this->bespokeRows[$i]] = $arrayvalue[$i];

			}
		// idyi geri döndürür.
			$id = $this->database->insert($this->tableName, $result);

			if ($id)
				return $id;
			else
				return 'insert failed: ' . $this->database->getLastError();
		}

	}

	public function setFirstName($value)
	{
		$this->database->setFirstName($value);
	}
	public function setLastName($value)
	{
		$this->database->setLastName($value);
	}



	public function userID()
	{
		return $this->database->getUserID();
	}

	public function userINFO()
	{
		return $this->database->getUserINFO();
	}

	private function createTable()
	{
		$value = '';
		for ($i = 0; $i < count($this->bespokeRowsV); $i++) {
			if ($this->bespokeRowsV[$i] == 1) {
				$this->bespokeRowsV[$i] = "INT(32)";
			} elseif ($this->bespokeRowsV[$i] == "S") {
				$this->bespokeRowsV[$i] = "TEXT";
			} else if ($this->bespokeRowsV[$i] == "T") {
				$this->bespokeRowsV[$i] = "DATE NULL";
			}


			if ($i == (count($this->bespokeRows) - 1)) {
				$value = $value . "" . $this->bespokeRows[$i] . " " . $this->bespokeRowsV[$i];

			} else {

				$value = $value . "" . $this->bespokeRows[$i] . " " . $this->bespokeRowsV[$i] . ",";

			}

		}



		if (!$this->database->tableExists($this->tableName)) {
			$sql = "CREATE TABLE " . $this->tableName . " (
 			id INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 			" . $value . ")";
			$this->database->rawQuery($sql);
		}

		if (self::getAll()[$this->bespokeRows[0]] != self::userID()) {
			self::setAll(array(self::userID(), "", "", "", "", "", "", "eksik"));
		}

	}



	public function urunSil($proID, $userID)
	{
		$value = explode(",", self::getKullanilabilirUrunler($userID));
		$result = '';
		if (count($value) > 1) {
			for ($i = 0; $i < count($value) - 1; $i++) {
				if ($value[$i] != $proID) {
					$result = $result . $value[$i] . ",";
				}
			}
		}
		return self::set($this->bespokeRows[6], $result, $userID);
	}

	public function dosyaSil($deqer)
	{
		$value = self::getEksDosyaYolu();
		$result = '';
		if (count($value) > 1) {
			for ($i = 1; $i < count($value); $i++) {
				$firstvalue = $value[$i];

				if (explode("wp-content", $value[$i])[1] != explode("wp-content", $deqer)[1]) {
					$result = $result . "+-+" . $firstvalue;
				}
			}
		}
		return self::set($this->bespokeRows[5], $result);
	}

	public function durumKontrol()
	{
		$result = false;

		if (self::getBoyu() == null || self::getKilo() == null || self::getYas() == null) {
			$result = false;
		} else {
			$result = true;
		}
		return $result;
	}


	





		

	

	



// STATUS KISMI //
	public function getStatusTerlik($userID)
	{
		$genelStatus = explode(";", self::getBespokeStatus($userID))[1];
		$this->statusTerlik = explode("=",$genelStatus)[1];
		return $this->statusTerlik;
	}
	public function setStatusTerlik($userID,$statusTerlik)
	{
		$genelStatus = explode(";", self::getBespokeStatus($userID))[0];
		self::setBespokeStatus($userID, $genelStatus . ";" . "terlik=" . $statusTerlik);
	}

	public function getStatusAyakkabi($userID)
	{
		$genelStatus = explode(";", self::getBespokeStatus($userID))[0];
		$this->statusAyakkabi = explode("=",$genelStatus)[1];
		return $this->statusAyakkabi;
	}


	public function setStatusAyakkabi($userID,$statusAyakkabi)
	{
		$genelStatus = explode(";", self::getBespokeStatus($userID))[1];

		self::setBespokeStatus($userID,  "ayakkabi=" . $statusAyakkabi . ";" . $genelStatus);
	}

	public function Status()
	{
		$boy = self::getBoyu();
		$kilo = self::getKilo();
		$yas = self::getYas();
		$ayak = self::getAyakOlcusu();
		
		if ($boy != null && $boy != "" &&
			$kilo != null && $kilo != "" &&
			$yas != null && $yas != "" &&
			$ayak != null && $ayak != "") {
			

			if (self::getBespokeStatus(self::userID()) == "eksik") {
				//self::setStatusAyakkabi("tamam");
				//self::setStatusTerlik("tamam");
				self::setBespokeStatus( -1, "ayakkabi=tamam;terlik=tamam");

			}

		}
	}

	public function getBespokeStatus($userID=-1)
	{
		return self::get($this->bespokeRows[7],$userID);
	}

	public function setBespokeStatus($userID=-1,$values)
	{
		return self::set($this->bespokeRows[7], $values,$userID);
	}

// STATUS KISMI //

}

?>