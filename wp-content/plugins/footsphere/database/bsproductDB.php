<?php 

require_once("MysqliDb.php");
require_once ($_SERVER['DOCUMENT_ROOT']  . "/wp-content/plugins/footsphere/lib/config.php");

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
class bsproductDB
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
		$this->tableName = config::getConfig('bsproduct/tablename');
		$this->bespokeRows = explode(",", config::getConfig('bsproduct/bsproductrows'));
		$this->bespokeRowsV = explode(",", config::getConfig('bsproduct/bsproductrowsV'));
		self::createTable();//eğer veritabanı yoksa oluşturuyor.

	}

	public function getAllID($id, $tur='', $filtreler)
	{
		$this->database->where("id", $id);
		if ($tur!='') {
			$this->database->where("turu", $tur);
		}
		$urun = $this->database->getOne($this->tableName);
	


		if ($filtreler) {
			$durum = false;

			foreach ($filtreler as $key => $value) {
				if ($urun) {
					if ($urun[substr($key, 0, -1)] == $value)
						$durum = true;
				}
			}

			if ($durum) {
				return $urun;
			}
		} else {
			return $urun;
		}
	}


	public function getAllOnlyID($id)
	{
		$this->database->where("id", $id);

		return $this->database->getOne($this->tableName);
	}



	public function getAllProducer($producerID)
	{
		$this->database->where("producerNo", $producerID);
		return $this->database->getOne($this->tableName);
	}

	public function getAll()
	{
		return $this->database->get($this->tableName);
	}
	public function setProductStatus($id, $status)
	{
		$this->database->where("id", $id);
		$result["Status"] = $status;
		return $this->database->update($this->tableName, $result);
	}

	public function getProductStatus($id)
	{
		$this->database->where("id", $id);
		return $this->database->getOne($this->tableName)['Status'];
	}

	public function getProductAll($producerID, $tur = null)
	{
		if ($tur) {
			if ($tur=="Ayakkabı" || $tur =="Ayakkab?"){
				//$this->database->orwhere("turu", $tur);

				$this->database->where("turu", "Ayakkab%", 'like');
			}else{

				$this->database->where("turu", $tur);
			}
		}
		$this->database->where("producerNo", $producerID);
		return $this->database->get($this->tableName);
	}


	public function deleteProduct($id)
	{
		if ($this->database->where("id", $id)) {
			return $this->database->delete($this->tableName);
		} else {
			return false;
		}
	}

	public function updateProduct(
		$id,
		$producerNo,
		$baslik,
		$aciklama,
		$turu,
		$tabanMalzeme,
		$kapanisTuru,
		$ustMalzeme,
		$astarMalzemesi,
		$Sezon,
		$icTabanturu,
		$icTabanMalzemesi
	) {
		$result[$this->bespokeRows[0]] = $producerNo;
		$result[$this->bespokeRows[1]] = $baslik;
		$result[$this->bespokeRows[2]] = $aciklama;
		$result[$this->bespokeRows[3]] = $turu;
		$result[$this->bespokeRows[4]] = $tabanMalzeme;
		$result[$this->bespokeRows[5]] = $kapanisTuru;
		$result[$this->bespokeRows[6]] = $ustMalzeme;
		$result[$this->bespokeRows[7]] = $astarMalzemesi;
		$result[$this->bespokeRows[8]] = $Sezon;
		$result[$this->bespokeRows[9]] = $icTabanturu;
		$result[$this->bespokeRows[10]] = $icTabanMalzemesi;

		$this->database->where("id", $id);
		$result = $this->database->update($this->tableName, $result);

	}

	public function addProduct(
		$producerNo,
		$baslik,
		$aciklama,
		$turu,
		$tabanMalzeme,
		$kapanisTuru,
		$ustMalzeme,
		$astarMalzemesi,
		$Sezon,
		$icTabanturu,
		$icTabanMalzemesi,
		$image
	) {
		//producerNo,baslik,aciklama,turu,tabanMalzeme,kapanisTuru,ustMalzeme,astarMalzemesi,Sezon,icTabanturu,icTabanMalzemesi,image,Status
		$this->database->where($this->bespokeRows[0], $producerNo);
		$this->database->where($this->bespokeRows[1], $baslik);
		$this->database->where($this->bespokeRows[2], $aciklama);
		$this->database->where($this->bespokeRows[3], $turu);
		$this->database->where($this->bespokeRows[4], $tabanMalzeme);
		$this->database->where($this->bespokeRows[5], $kapanisTuru);
		$this->database->where($this->bespokeRows[6], $ustMalzeme);
		$this->database->where($this->bespokeRows[7], $astarMalzemesi);
		$this->database->where($this->bespokeRows[8], $Sezon);
		$this->database->where($this->bespokeRows[9], $icTabanturu);
		$this->database->where($this->bespokeRows[10], $icTabanMalzemesi);

		$id = $this->database->getOne($this->tableName)['id'];
		if ($id) {
			$result[$this->bespokeRows[0]] = $producerNo;
			$result[$this->bespokeRows[1]] = $baslik;
			$result[$this->bespokeRows[2]] = $aciklama;
			$result[$this->bespokeRows[3]] = $turu;
			$result[$this->bespokeRows[4]] = $tabanMalzeme;
			$result[$this->bespokeRows[5]] = $kapanisTuru;
			$result[$this->bespokeRows[6]] = $ustMalzeme;
			$result[$this->bespokeRows[7]] = $astarMalzemesi;
			$result[$this->bespokeRows[8]] = $Sezon;
			$result[$this->bespokeRows[9]] = $icTabanturu;
			$result[$this->bespokeRows[10]] = $icTabanMalzemesi;


			$this->database->where("id", $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return true;
			else
				return false;


		} else {
			$result[$this->bespokeRows[0]] = $producerNo;
			$result[$this->bespokeRows[1]] = $baslik;
			$result[$this->bespokeRows[2]] = $aciklama;
			$result[$this->bespokeRows[3]] = $turu;
			$result[$this->bespokeRows[4]] = $tabanMalzeme;
			$result[$this->bespokeRows[5]] = $kapanisTuru;
			$result[$this->bespokeRows[6]] = $ustMalzeme;
			$result[$this->bespokeRows[7]] = $astarMalzemesi;
			$result[$this->bespokeRows[8]] = $Sezon;
			$result[$this->bespokeRows[9]] = $icTabanturu;
			$result[$this->bespokeRows[10]] = $icTabanMalzemesi;
			$result[$this->bespokeRows[11]] = $image;
			$result[$this->bespokeRows[12]] = 0;

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result)
				return $result;
			else
				return false;
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



	public function getProducerRequestLenghtOnaylanmis($producerNo)
	{
		$this->database->where("producerNo", $producerNo);
		$this->database->where("Status", 1);
		return $this->database->get($this->tableName);
	}

	public function getProducerRequestLenghtRed($producerNo)
	{
		$this->database->where("producerNo", $producerNo);
		$this->database->where("Status", -1);
		return $this->database->get($this->tableName);
	}

	public function getProducerRequestLenghtToplam($producerNo)
	{
		$this->database->where("producerNo", $producerNo);
		return $this->database->get($this->tableName);
	}

	public function getUserID()
	{
		return $this->database->getUserID();
	}





}

?>