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
class requestDB
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
		$this->tableName = config::getConfig('request/tablename');
		$this->bespokeRows = explode(",", config::getConfig('request/requestrows'));
		$this->bespokeRowsV = explode(",", config::getConfig('request/requestrowsV'));
		self::createTable();//eğer veritabanı yoksa oluşturuyor.

	}

	public function getRequestStatus($id)
	{
		$this->database->where("id", $id);
		$result["Status"] = $status;
		return $this->database->getOne($this->tableName);
	}

	public function setRequestStatus($id, $status)
	{
		$this->database->where("id", $id);
		$result["Status"] = $status;
		return $this->database->update($this->tableName, $result);
	}

	public function setRequestIDStatus($requestID,$status)
	{
		$this->database->where("requestNo", $requestID);
		$result["Status"] = $status;
		return $this->database->update($this->tableName, $result);
	}



	public function getRequestALL()
	{
		return $this->database->get($this->tableName);
	}

	public function getRequestControl($userID){
		$this->database->where($this->bespokeRows[0], $userID);
		return $this->database->get($this->tableName);
	}

	public function getRequest($userID, $producer, $requestID = 0)
	{
		$this->database->where($this->bespokeRows[0], $userID);
		$this->database->where($this->bespokeRows[1], $producer);
		if ($requestID != 0) {
			$this->database->where($this->bespokeRows[2], $requestID);
		}
		return $this->database->get($this->tableName);
	}
	public function getRequestID($requestID)
	{
		$this->database->where("requestNo", $requestID);
		return $this->database->getOne($this->tableName);
	}

	

	public function getProducerID($producerID)
	{
		$this->database->where("producerNo", $producerID);
		return $this->database->get($this->tableName);
	}




	public function setRequest($userID, $producer, $requestID, $urunler,$type)
	{

		$this->database->where($this->bespokeRows[0], $userID);
		$this->database->where($this->bespokeRows[1], $producer);
		$this->database->where($this->bespokeRows[2], $requestID);
		$id = $this->database->getOne($this->tableName)['id'];
		if ($id) {
			$result[$this->bespokeRows[0]] = $userID;
			$result[$this->bespokeRows[1]] = $producer;
			$result[$this->bespokeRows[2]] = $requestID;
			$result[$this->bespokeRows[3]] = $urunler;
			$result[$this->bespokeRows[5]] = $type;


			$this->database->where("id", $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return true;
			else
				return false;


		} else {
			$result[$this->bespokeRows[0]] = $userID;
			$result[$this->bespokeRows[1]] = $producer;
			$result[$this->bespokeRows[2]] = $requestID;
			$result[$this->bespokeRows[3]] = $urunler;
			$result[$this->bespokeRows[4]] = 0;
			$result[$this->bespokeRows[5]] = $type;

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result)
				return $result;
			else
				return false;
		}

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
			$sql = "CREATE TABLE " . $this->tableName . " 
			(id INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 			" . $value . ")";
			$this->database->rawQuery($sql);
		}

	}

	public function deleteRequest($requsetID)
	{
		if ($this->database->where("id", $requsetID)) {
			return $this->database->delete($this->tableName);
		} else {
			return false;
		}
	}



	public function getProducerRequestLenghtOnaylanmis($producerNo)
	{
		$this->database->where("producerNo", $producerNo);
		$this->database->where("Status", 1);
		$this->database->orwhere("Status",2);

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





}

?>