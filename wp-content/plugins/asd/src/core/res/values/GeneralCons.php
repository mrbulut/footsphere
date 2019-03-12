<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 15:07
 */

include_once ROOT_PATH . '/src/core/lib/JsonReader.php';


class GeneralCons
{
    private $lang;
    private $filePath = "/src/core/res/values/language/";
    private $array;

    private $langValueShortCode;// array("English" => "en");
    private $currency; // string USD,TRY,...
    private $currencySymbol; // string ₺,$,..
    private $filesInLangFiles; // files in the languages file

    //there are files in the language file

    public function getFilesInLangFiles()
    {
        return $this->filesInLangFiles;
    }


    public function String($key)
    {
        return self::getArray()[$key];
    }

    public function getLangValueShortCode()
    {
        return $this->langValueShortCode;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getCurrencySymbol()
    {
        return $this->currencySymbol;
    }


    public function __construct($lang)
    {
        $this->lang = $lang; // English,Turkish,..
        self::setup($this->lang);
        self::setArray(JsonReader::jsonRead(ROOT_PATH . $this->filePath . $this->langValueShortCode . ".json"));
    }

    private function setup($LangValue)
    {
        $langArray = self::fs_languages();
        $this->langValueShortCode = "en";
        $this->currency = "USD";
        $this->currencySymbol = "$";

        foreach ($langArray as $key => $value) {
            $valueArray = explode(":", $value);

            if ($valueArray[0] == $LangValue) {
                $this->langValueShortCode = $valueArray[0];
                $this->currency = $valueArray[1];
                $this->currencySymbol = $valueArray[2];
                break;
            }
        }

        self::whichFilesHave(ROOT_PATH . $this->filePath);

    }

    private function whichFilesHave($filePath)
    {
        $dir = opendir($filePath);

        $result = array();

        $i = 0;
        while (($dosya = readdir($dir)) !== false) {
            if (!is_dir($dosya)) {
                $result[$i] = $dosya;
                $i++;
            }
        }
        closedir($dir);

        $langArray = self::fs_languages();

        foreach ($result as $key => $value) {
            foreach ($langArray as $key2 => $value2) {
                if (explode(".", $value)[0] == explode(":", $value2)[0]) {
                    $this->filesInLangFiles[$key] = $key2;
                }
            }

        }


    }


    private function fs_languages()
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

    /**
     * @return mixed
     */


    /**
     * @param mixed $langValueShortCode
     */
    public function setLangValueShortCode($langValueShortCode)
    {
        $this->langValueShortCode = $langValueShortCode;
    }

    /**
     * @return mixed
     */

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */


    /**
     * @param mixed $currencySymbol
     */
    public function setCurrencySymbol($currencySymbol)
    {
        $this->currencySymbol = $currencySymbol;
    }


    private function getArray()
    {
        return $this->array;
    }

    private function setArray($array)
    {
        $this->array = $array;
    }

    public function setFilesInLangFiles($filesInLangFiles)
    {
        $this->filesInLangFiles = $filesInLangFiles;
    }


}