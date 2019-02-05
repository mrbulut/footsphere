
<?php

/**
 *convert($from, $to, $value, $type = 'ForexBuying'):
*Bu method, parametre olarak çevrim yapılacak dövizlere ait kodları, çevrilecek miktarı ve dönecek değer tipini alır. Sonuç olarak decimal döndürür. $type parametresi aşağıdaki değerleri alabilir;

*- ForexBuying : Alış fiyatı (varsayılan),
*- ForexSelling : Satış fiyatı,
*- BanknoteBuying : Efektif alış fiyatı,
*- BanknoteSelling : Efektif satış fiyatı.
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
class languages
{
  ///$json = '{"kadi" : "tayfun erbilen", "sifre" : "123456"}';
  //$data = json_decode($json, true)
  private $dil;
  private $dildegeri;
  private $json;
  private $yerelfiyat;
  private $kur;
  private $localParaBirimi;
  private $localParaBirimiSimgesi;

  function __construct($userID = 0)
  {
    require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
    $bespokeDB = new bespokeDB();

    if ($userID == 0)
      $this->dildegeri = $bespokeDB->getLangueagesShort($bespokeDB->userID());
    else
      $this->dildegeri = $bespokeDB->getLangueagesShort($userID);

    require_once(ABSPATH . "wp-content/plugins/footsphere/lib/dovizkur.php");
    $this->kur = new doviz(10);
    self::setLocalParaBirimi($this->dildegeri);
    self::getValue();
  }

  public function usdToLocal($price)
  {
    $money  =$this->kur->convert("USD", self::getLocalParaBirimi(), $price);
 
    return ceil($money)." ".self::getLocalParaBirimiSimgesi();;
  }

  public function usdToLocalSembolsuz($price)
  {
    $money  =$this->kur->convert("USD", self::getLocalParaBirimi(), $price);
 
    return ceil($money);
  }

  public function localToUsd($price)
  {
    return $this->kur->convert(self::getLocalParaBirimi(), "USD", $price);
  }

  

  public function getValue()
  {
    $this->json = self::jsonRead($this->dildegeri);
    self::setDil($this->json);
  }

  public function terstenOkuma($key)
  {
    return $this->json->$key;
  }

  public function jsonRead($fileName)
  {
    $dosyayolu = ABSPATH . "wp-content/plugins/footsphere/languages/files/" . $fileName . ".json";
    $dosya = fopen($dosyayolu, 'r');
    $json = fread($dosya, filesize($dosyayolu));
    $data = json_decode($json, true);
    fclose($dosya);
    return $data;
  }
  
  /* Languages */
  public function fs_languages()
  {
    $langs = array(
      'English' => 'en:USD:$',
      'Arabic' => 'ar:SAR:﷼',
      'Bulgarian' => 'bg:EUR:€',
      'Catalan' => 'ca:EUR:€',
      'Czech' => 'cs:EUR:€',
      'Danish' => 'da:DKK:kr',
      'German' => 'de:EUR:€',
      'Greek' => 'el:EUR:€',
      'Español' => 'es:EUR:€',
      'Persian-Farsi' => 'fa',
      'Faroese translation' => 'fo',
      'French' => 'fr:EUR:€',
      'Hebrew (עברית)' => 'he:ILS:₪',
      'hr' => 'hr:EUR:€',
      'magyar' => 'hu:EUR:€',
      'Indonesian' => 'id:USD:$',
      'Italiano' => 'it:EUR:€',
      'Japanese' => 'jp:JPY:¥',
      'Korean' => 'ko:USD:$',
      'Dutch' => 'nl:EUR:€',
      'Norwegian' => 'no:NOK:kr',
      'Polski' => 'pl:EUR:€',
      'Português' => 'pt_BR:EUR:€',
      'Română' => 'ro:RON:lei      ',
      'Russian (Русский)' => 'ru:RUB:руб',
      'Slovak' => 'sk:EUR:€',
      'Slovenian' => 'sl:EUR:€',
      'Serbian' => 'sr:EUR:€',
      'Swedish' => 'sv:SEK:kr',
      'Türkçe' => 'tr:TRY:₺',
      'Uyghur' => 'ug_CN:USD:$',
      'Ukrainian' => 'uk::EUR:€',
      'Vietnamese' => 'vi:USD:$',
      'Simplified Chinese (简体中文)' => 'zh_CN:CNY:¥',
      'Traditional Chinese' => 'zh_TW:CNY:¥',
    );
    return $langs;
  }



  public function getLang($lang)
  {

    $langArray = self::fs_languages();
    $result = 'English';
    foreach ($langArray as $key => $value) {
      if ($lang == explode(":",$value)[0])
        $result = $key;
    }
    return $result;
  }

  /**
   * Get the value of dil
   */
  public function getDil()
  {

    return $this->dil;
  }

  /**
   * Set the value of dil
   *
   * @return  self
   */
  public function setDil($dil)
  {
    $this->dil = $dil;

    return $this;
  }

  /**
   * Get the value of yerelfiyat
   */
  public function getYerelfiyat()
  {
    return $this->yerelfiyat;
  }

  /**
   * Set the value of yerelfiyat
   *
   * @return  self
   */
  public function setYerelfiyat($yerelfiyat)
  {
    $this->yerelfiyat = $yerelfiyat;

    return $this;
  }

  /**
   * Get the value of localParaBirimi
   */
  public function getLocalParaBirimi()
  {
    return $this->localParaBirimi;
  }

  /**
   * Set the value of localParaBirimi
   *
   * @return  self
   */
  public function setLocalParaBirimi($dildegeri)
  {
    $langArray = self::fs_languages();
    foreach ($langArray as $key => $value) {
      if ($dildegeri == explode(":",$value)[0]){
        $this->localParaBirimi = explode(":",$value)[1];
        $this->localParaBirimiSimgesi = explode(":",$value)[2];
      }
   
    }
    return $this;
  }



  /**
   * Get the value of localParaBirimiSimgesi
   */ 
  public function getLocalParaBirimiSimgesi()
  {
    return $this->localParaBirimiSimgesi;
  }

  /**
   * Set the value of localParaBirimiSimgesi
   *
   * @return  self
   */ 
  public function setLocalParaBirimiSimgesi($localParaBirimiSimgesi)
  {
    $this->localParaBirimiSimgesi = $localParaBirimiSimgesi;

    return $this;
  }
}


 


?>
