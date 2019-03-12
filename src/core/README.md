

Images,Values,Strings,Language folders  under the res folder 

ready-to-use modules   under the lib folder

enterprise constants   under the entites folder

<b>Using The GeneralCons class in GeneralCons.php</b> "/res/values/String.php"

Used like below when getting any text,currency,..

<pre><code>
$string = new GeneralCons("English");
echo $string->GetString('backend_profil_kAdiText');
echo $string->getLangValueShortCode();
echo $string->getCurrency();
echo $string->getCurrencySymbol();
echo $string->getFilesInLangFiles() // return array files in "/res/values/languages" "example: Tükçe,English,Polish,.." 
</pre></code>

- We are adding language files like shortcode.json. "/res/values/language/"

