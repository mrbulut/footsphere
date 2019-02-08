<?php

class ExchangeRateConverter
{

    private $saveFilePath ='/src/core/lib/currency_feed.xml';
    private $ratesLink = 'http://www.tcmb.gov.tr/kurlar/today.xml';
    private $currencyCode;
    private $xml;
    private $currency = array();

    function __construct($cache = 0)
    {
        $this->saveFilePath =  ROOT_PATH . $this->saveFilePath;
        $this->ReadToAPI($cache); // read
        $this->ConverterToArray(); // converter
    }



    private function ReadToAPI($cache = 0)
    {
        if ($cache > 0) {
            $cacheName = 'currency_feed.xml';
            $cacheAge = $cache * 60;
            if (!file_exists($cacheName) || filemtime($cacheName) > time() + $cacheAge) {
                $contents = file_get_contents($this->ratesLink);
                file_put_contents($cacheName, $contents);
            }
            $this->xml = simplexml_load_file($cacheName);

        } else {
            $this->xml = simplexml_load_file($this->ratesLink);
        }
    }

    private function ConverterToArray()
    {
        foreach ($this->xml->Currency as $group => $item) {
            $this->currencyCode = $item['CurrencyCode'];
            foreach ($item as $key => $item) {
                $this->currency["$this->currencyCode"]["$key"] = "$item";
            }
        }

        // Türk Lirası Ekleniyor
        $this->currency['TRY']['Unit'] = 1;
        $this->currency['TRY']['Isim'] = 'TÜRK LİRASI';
        $this->currency['TRY']['CurrencyName'] = 'TRY';
        $this->currency['TRY']['ForexBuying'] = 1;
        $this->currency['TRY']['ForexSelling'] = 1;
        $this->currency['TRY']['BanknoteBuying'] = 1;
        $this->currency['TRY']['BanknoteSelling'] = 1;
    }

    /**
     * Döviz Bilgilerini Alma
     * @param $code    int    (Döviz kodu)
     * @return array
     */
    public function getCurrency($code)
    {
        return $this->currency[$code];
    }

    /**
     * Döviz Çevirici
     * @param $from        int
     * @param $to        int
     * @param $value    int
     * @param $type    string    (BanknoteBuying|BanknoteSelling|ForexBuying|ForexSelling)
     * @return float
     */
    public function convert($from, $to, $value, $type = 'ForexBuying')
    {
        $value = $value * $this->getCurrency($from)[$type];
        $result = $value / $this->getCurrency($to)[$type];
        return round($result, 4);
    }

    /**
     * Tarih Bilgisi
     * @return string
     */
    public function getDate()
    {
        $output = json_decode(json_encode($this->xml), true);
        return $output['@attributes']['Tarih'];
    }

}

?>