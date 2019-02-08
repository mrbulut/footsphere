

Images,Values,Strings,Language folders  under the res folder 
ready-to-use modules   under the lib folder
enterprise constants   under the entites folder

--------------
<b>Using The StringReader class in String.php</b> "/res/values/String.php"

Used like below when getting any text 
<pre><code>
$string = new StringReader("tr");
echo $string->Get('backend_profil_kAdiText');
</pre></code>

- We are adding language files like shortcode.json. "/res/values/language/"


--------------

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