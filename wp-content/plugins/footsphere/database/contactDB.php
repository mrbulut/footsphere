<?php 

require_once("MysqliDb.php");
require_once ABSPATH . "wp-content/plugins/footsphere/lib/config.php";
require_once ABSPATH . "wp-content/plugins/footsphere/lib/Cookie.php";


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
echo  $db->userINFO()[5]  ; // rolu
echo  $db->getAll()['boyu']  ;
echo  $db->getAll()['kilosu']  ;
echo  $db->getAll()['footsphereDosyaYolu']  ;
echo  $db->getAll()['ekstraDosyaYolu']  ;
$r = (1 == $v) ? 'Yes' : 'No'; // $r is set to 'Yes'
 */
class contactDB
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
	private $operasyoncuBGColor = "pink";
	private $operatorAdi ;
	private $kullanici;
	private $dil;

	function __construct()
	{
		$this->database = new MysqliDb();
		$this->tableName = config::getConfig('contact/tablename');
		$this->bespokeRows = explode(",", config::getConfig('contact/contactrows'));
		$this->bespokeRowsV = explode(",", config::getConfig('contact/contactrowsV'));
		self::createTable();//eğer veritabanı yoksa oluşturuyor.
		require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
		$this->dil = $lang->getDil();
		$this->kullanici = $this->dil['backend_contact_messageSen'];
		$this->operatorAdi = $this->dil['backend_contact_messageYetkili'];

	}



	public function getAlluserID($userID)
	{
		if ($userID == -1) {
			$dizi = [];
			$this->database->where('status', 0);
			return $this->database->get($this->tableName);
		} elseif ($userID == 0) {
			return $this->database->get($this->tableName);
		} else {
			$this->database->where('userID', $userID);
			return $this->database->getOne($this->tableName);
		}

	}


	public function getAllFull()
	{
		return $this->database->get($this->tableName);

	}

	public function getAll()
	{
		$this->database->where($this->bespokeRows[0], self::userID());
		return $this->database->getOne($this->tableName);
	}

	public function setAll($arrayvalue = '')
	{

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
	public function getTotalMessage()
	{

		return count($this->database->get($this->tableName, null, "id"));

	}

	public function getTotalMessageLenght($userID)
	{
		$this->database->where("userID", $userID);

		return count($this->database->get($this->tableName, null, "id"));

	}

	public function getOkunmamisMessage()
	{

		$this->database->where($this->bespokeRows[4], 0);

		return count($this->database->get($this->tableName, null, "id"));
	}

	public function mesajlariGorulduYap($userID)
	{
		$data = array(
			$this->bespokeRows[4] => 1
		);
		$this->database->where($this->bespokeRows[0], $userID);
		$this->database->where($this->bespokeRows[4], 0);
	
		return $this->database->update($this->tableName, $data);


	}
	public function mesajYaz($message, $userID = 0,$uretici=false)
	{
		$this->database->orderBy("id", "Desc");
		if ($userID == 0 || $uretici==true) {
			$userID = self::userID();
			$this->database->where($this->bespokeRows[0], $userID);
			$lastMessage = $this->database->getOne($this->tableName)[$this->bespokeRows[2]];
			$this->database->where($this->bespokeRows[0], $userID);
			$lastwho = $this->database->getOne($this->tableName)[$this->bespokeRows[1]];

			if ("white" == $lastwho && $message == $lastMessage) {

			} else {
				return self::setAll(array($userID, "white", $message, $this->database->now(), 0));

			}

		} else {
			$this->database->where($this->bespokeRows[0], $userID);
			$lastMessage = $this->database->getOne($this->tableName)[$this->bespokeRows[2]];
			$lastwho = $this->database->getOne($this->tableName)[$this->bespokeRows[1]];
			if ($this->operasyoncuBGColor == $lastwho && $message == $lastMessage) {
			} else {
				return self::setAll(array($userID, $this->operasyoncuBGColor, $message, $this->database->now(), 1));
			}
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
				$this->bespokeRowsV[$i] = "DATETIME NULL";
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

	public function getAllMessage()
	{
		$databaseBespoke = new bespokeDB();
		$result = self::getAllList();

		return $result;
	}



	public function getAllMessageUserID($userID,$yetki=false)
	{
		if($userID == -1){
			$userID == self::userID();
		}
		$this->database->where($this->bespokeRows[0], $userID);

		$list = $this->database->get($this->tableName);

		for ($i = 0; $i < count($list); $i++) {

			$arrayValue[$i] = array(
				'mesajSahibi' => $list[$i]['mesajSahibi'],
				'mesaji' => $list[$i]['mesaji'],
				'date' => $list[$i]['date'],
				'Status' => 0
			);
		}


		if($yetki){
			self::mesajlariGorulduYap($userID);
		}


		return $arrayValue;
	}

	public function getAllList()
	{
		$this->database->where($this->bespokeRows[0], self::userID());


		$value = $this->database->get($this->tableName, null, "id");

		$result = "";
		if (count($value) > 1) {
			foreach ($value as $valu) {
				$result = $result . " " . self::result($valu['id']) . " <br>";
			}
		} else {
			$result = $result . "<b>".$this->dil['mesajyok']." </b> <br>";
		}



		return $result;
	}

	public function okunmamisMesajiVarmi($ID)
	{
		$this->database->where("userID", $ID);
		$result = 1;
		$list = $this->database->get($this->tableName);
		foreach ($list as $key) {
			if ($key['Status'] == 0) {
				$result = 0;
			}
		}
		return $result;

	}

	public function getLastMessageDate($ID)
	{
		$this->database->where("userID", $ID);
		$list = $this->database->get($this->tableName);
		return $list[count($list) - 1]['date'];

	}

	public function getSonMesajTarihi($ID)
	{
		$this->database->where("id", $ID);
		return $this->database->getOne($this->tableName)['date'];


	}

	public function getMessageList($ID)
	{
		$this->database->where("id", $ID);
		return $this->database->getOne($this->tableName);
	}





	private function result($ID)
	{

		$messageList = self::getMessageList($ID);
		$message = $messageList[$this->bespokeRows[2]];
		$tarih = $messageList[$this->bespokeRows[3]];
		$kiminMesaji = $messageList[$this->bespokeRows[1]];
		$who = '';
		if ($kiminMesaji == $this->operasyoncuBGColor) {
			$who = "<b>" . $this->operatorAdi . "</b>: ";
		} else {
			$who = "<b>" . $this->kullanici . "</b>: ";;

		}

		//echo "string***********************-88-8-8--?===" .$urunFiyati;
		$result = '

 		<div>
 		<aside style="background-color:' . $kiminMesaji . '; padding:10px;" align="right"><label name="" align="right" style="font-size:16px;">' . $who . '<br> ' . $message . '</label><br>
 		<label name="messageDate" align="right" style="font-size:12px;">' . $tarih . '</label>
 		</aside>
 		</div>

 		';



		return $result;
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

	
}

?>