u<?php 

require_once("MysqliDb.php");
require_once ABSPATH . "wp-content/plugins/footsphere/lib/config.php";
require_once ABSPATH . "wp-content/plugins/footsphere/database/optionsDB.php";
require_once ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php";

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
echo  $db->getAll()['boyu']  ;ay
echo  $db->getAll()['kilosu']  ;
echo  $db->getAll()['footsphereDosyaYolu']  ;
echo  $db->getAll()['ekstraDosyaYolu']  ;
$r = (1 == $v) ? 'Yes' : 'No'; // $r is set to 'Yes'
 */
class usermetaDB
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
	private $teklifSuresi;

	function __construct()
	{


		
		$options = new optionsDB();
		$this->teklifSuresi = $options->getRequestTimeArea();
		$this->database = new MysqliDb();
		$this->tableName = "wp_usermeta";
		$this->bespokeRows = array("umeta_id", "user_id", "meta_key", "meta_value");
		$this->bespokeRowsV = array(1, 1, "S", "S");

	}


	public function getAllRequsetUser()
	{
		$this->database->where($this->bespokeRows[2], "requestterlik");
		$this->database->orwhere($this->bespokeRows[2], "requestayakkabi");

		return $this->database->get($this->tableName);
	}

	public function getAllRequsetUserID($userID)
	{
		$this->database->where($this->bespokeRows[2], "request");
		$this->database->where($this->bespokeRows[1], $userID);
		return $this->database->get($this->tableName);
	}

	public function getTimeRequestID($requsetID)
	{
		$this->database->where($this->bespokeRows[2], $requsetID);
		$time =  $this->database->getOne($this->tableName)[$this->bespokeRows[3]];
		$time = ceil($time - time());
		return $time/60/60;


	}
	public function getTimeUserID($userID,$istekTuru)
	{
		$this->database->where($this->bespokeRows[1], $userID);
		$this->database->where($this->bespokeRows[2], "request".$istekTuru);
		$time = $this->database->getOne($this->tableName)[$this->bespokeRows[3]];
		$time = ceil($time - time());
		return ceil($time/60/60);

	}


	public function getRequesType($userID)
	{
		$this->database->where($this->bespokeRows[1], $userID);
		$time =  explode(":",$this->database->getOne($this->tableName)[$this->bespokeRows[3]])[1];
		$time = ceil($time - time());
		return $time/60;

	}



	public function createRequestUser($userID,$istekturu)
	{

		$database = new bespokeDB();
		$this->database->where($this->bespokeRows[1], $userID);
		$this->database->where($this->bespokeRows[2], "request".$istekturu);
		$id = $this->database->getOne($this->tableName)[$this->bespokeRows[0]];
		if (!$id) {
			$result[$this->bespokeRows[1]] = $userID;
			$result[$this->bespokeRows[2]] = "request".$istekturu;
			$result[$this->bespokeRows[3]] = time() + (3600 * $this->teklifSuresi);


		//	$result[$this->bespokeRows[3]] = strtotime($this->database->now())+(3600*$this->teklifSuresi);

		// idyi geri döndürür.
			$result = $this->database->insert($this->tableName, $result);
			if ($result) {
				if($istekturu=="terlik"){
					$database->setStatusTerlik(-1,"closed");
				}else{

					$database->setStatusAyakkabi(-1,"closed");
				}

				return $result;
			} else
				return false;


		}
	}

	public function userID()
	{
		return $this->database->getUserID();
	}

	public function deleteRequestUser($userID,$istekturu)
	{
		$this->database->where($this->bespokeRows[1], $userID);
		$this->database->where($this->bespokeRows[2], "request".$istekturu);
		if ($this->database->getOne($this->tableName)[$this->bespokeRows[0]]) {
			return $this->database->delete($this->tableName);
		} else {
			return false;
		}
	}

	public function updateRequestUser($userID, $date,$istekturu)
	{

		$this->database->where($this->bespokeRows[1], $userID);
		$this->database->where($this->bespokeRows[2], "request".$istekturu);
		$id = $this->database->getOne($this->tableName)[$this->bespokeRows[0]];
		if ($id) {
			$result[$this->bespokeRows[3]] = $date;

			$this->database->where($this->bespokeRows[0], $id);
			$result = $this->database->update($this->tableName, $result);

			if ($result)
				return $result;
			else
				return false;


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













}

?>