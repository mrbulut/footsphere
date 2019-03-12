

<b>Using The ConfigReader class in ConfigReader. </b> 

"/res/lib/ConfigReader.php"

Used get global defined variables
<pre><code>
$GLOBALS['databaseConfig'] = array(
        'host' => array(
                    'host1' = '1.1.1.1',
                    'host2' = '2.2.2.2'
         );
         
 $varHost1 =    ConfigReader::Read("host/host1","databaseConfig);
       
</pre></code>

--------------

<b> Using The Cookie class in Cookie.php </b> "/res/lib/Cookie.php"

--------------
<pre><code>
$name;  // key of cookie 
$value; // value of cookie
$time;  // how much time will live of cookie
$Cookie = new Cookie();
$Cookie->create($name,$value,$time);
$Cookie->delete($name);
$Cookie->isthere($name); return true or false
$Cookie->get($name);
</pre></code>


--------------

<b>Using The DataConverter class in DataConverter.php</b> "/res/lib/DataConverter.php"
<pre><code>

$date; // date format
DateConverter::MiliSecondToMinute($date);
DateConverter::MiliSecondToHour($date);
DateConverter::DateToMilisecond($date);

</pre></code>

--------------

<b>Using The JsonReader class in JsonReader.php</b> "/res/lib/JsonReader.php"
<pre><code>

$dataRoute; // json file location
$array = JsonReader::jsonRead($dataRoute); 

</pre></code>

--------------
<b>Using The Session class in Session.php</b> "/res/lib/Session.php"
<pre><code>
$name;  // key of Session 
$value; // value of Session

Cookie::create($name,$value);
Cookie->delete($name);
Cookie->isthere($name); return true or false
Cookie->get($name);
</pre></code>

--------------

<b>Using The ExhangeRateConverter class in ExhangeRateConverter.php</b> "/res/lib/ExhangeRateConverter.php"

converting with buying 
<pre>
  TRY [TÜRK LİRASI]
  USD [AMERİKAN DOLARI]
  AUD [AVUSTRALYA DOLARI]
  DKK [DANİMARKA KRONU]
  EUR [EURO]
  GBP [İNGİLİZ STERLİNİ]
  CHF [İSVİÇRE FRANGI]
  SEK [İSVEÇ KRONU]
  CAD [KANADA DOLARI]
  KWD [KUVEYT DİNARI]
  NOK [NORVEÇ KRONU]
  SAR [SUUDİ ARABİSTAN RİYALİ]
  JPY [JAPON YENİ]
  BGN [BULGAR LEVASI]
  RON [RUMEN LEYİ]
  RUB [RUS RUBLESİ]
  IRR [İRAN RİYALİ]
  CNY [ÇİN YUANI]
  PKR [PAKİSTAN RUPİSİ]
</pre>
<pre><code>
$rates = new ExchangeRateConverter(10); // 10 minutes cache
$rates->convert('TRY','USD',25); TRY 25 Convert X $ 
$kur->convert('TRY','USD',25, 'BanknoteBuying') // BanknoteBuying, BanknoteSelling, ForexBuying, ForexSelling
$rates->getCurrency('TRY')  ; real time data
</pre></code>