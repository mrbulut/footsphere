<?php 

require_once("MysqliDb.php");
require_once ABSPATH . "wp-content/plugins/footsphere/lib/config.php";

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
class producerDB
{

	private $ID,
		$userID,
		$boy,
		$kilo,
		$fsDosyaYolu,
		$ekstraDosyaYolu;

	private $database;
	private $tableName;
	private $bespokeRows;

	function __construct()
	{
		$this->database = new MysqliDb();
		$this->tableName = config::getConfig('producer/tablename');
		$this->bespokeRows = explode(",", config::getConfig('producer/producerrows'));
		$this->bespokeRowsV = explode(",", config::getConfig('producer/producerrowsV'));
		self::createTable();//eğer veritabanı yoksa oluşturuyor.

	}

	private function get($sorgu)
	{

		$this->database->where($this->bespokeRows[0], self::userID());
		return $this->database->getOne($this->tableName)[$sorgu];

	}
	private function set($sorgu, $value)
	{
		$data = array(
			$sorgu => $value
		);
		$this->database->where($this->bespokeRows[0], self::userID());
		if ($this->database->update($this->tableName, $data))
			return true;
		else
			return false;
	}

	public function getAllID($userID)
	{
		$this->database->where('id', $userID);
		return $this->database->getOne($this->tableName);
	}

	public function getAll()
	{
		//return dbObject::table($this->tableName)->get();
		return $this->database->get($this->tableName);
	}
	public function getName($producerID)
	{

		$this->database->where("id", $producerID);
		return $this->database->getOne($this->tableName)[$this->bespokeRows[0]];
	}
	public function getUserName($producerID)
	{

		$this->database->where("id", $producerID);
		return $this->database->getOne("wp_users")["user_login"];
	}

	public function ureticiGuncelle($producerID,$adi, $srktadi,
	 $tel, $tel2,$email, $adres, $odeme, $kargo, $maxmix)
	{
		$this->database->where("id", $producerID);
		$result['ureticiAdi'] = $adi;
		$result['SirketAdi'] = $srktadi;
		$result['telefon'] = $tel;
		$result['telefon2'] = $tel2;
		$result['email'] = $email;
		$result['adresi'] = $adres;
		$result['odemeBilgi'] = $odeme;
		$result['kargoBilgi'] = $kargo;
		$result['MinMaxTeklif'] = $maxmix;

		

		$this->database->update($this->tableName, $result);


	}
	public function ureticiEkle($userID,$adi, $email, $teklifara)
	{
			$result['id']= $userID;
			$result['MinMaxTeklif']= $teklifara;
			$result[$this->bespokeRows[0]] = $adi;
			$result[$this->bespokeRows[4]] = $email;
			$id = $this->database->insert($this->tableName, $result);

			if ($id)
				return $id;
			else
				return 'insert failed: ' . $this->database->getLastError();
		

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

	}

	public function ureticiSil($producerID)
	{
		if ($this->database->where("id", $producerID)) {
			if($this->database->delete($this->tableName)) {
				$this->database->deleteUser($producerID);
			}
		} else {
			return false;
		}
	}








}


class bitti {


}
?>