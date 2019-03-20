<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 14:52
 */

include_once ROOT_PATH . "/src/ui/app/models/UserModel.php";
include_once ROOT_PATH . "/src/ui/app/models/OptionsModel.php";
include_once ROOT_PATH . "/src/core/lib/Session.php";

class Functions
{

    public static $url;
    public static $error;


    public function __construct()
    {
        self::$error = array();
    }


    public function start()
    {


        self::whatIsTheUserRoleAndLanguage();

        $link = $_SERVER['REQUEST_URI'];

        $link = explode("?page=", $link)[1];

        if($link=="footsphere"){

            $link="footsphere&Dashboard";
        }
        if ($link) {
            if($link=="footsphere&translation"){
                header("Location: ".$_POST['nowpage']);
            }
            $contName = $link;
            $expContName = explode("&", $contName);

            if (!$expContName[1]) {
                $expContName[1] = "Dashboard";
            }

            if (!$expContName[2]) {
                $expContName[2] = "home";
            }
            if ($this->existsController($expContName[1])) {
                $expContName[1] .= "Controller";
                $Cont = new $expContName[1]();
                $methodName = $expContName[2];
                if ($Cont->existsMethods($methodName)) {
                    if ($expContName[3]) {
                        $Cont->$methodName($expContName[3]);
                    } else {
                        $Cont->$methodName();
                    }
                } else {
                    self::$error[] = "Method Bulunamadı.";
                }


            } else {
                self::$error[] = "Sayfa Bulunamadı";
            }
        }
    }

    public function ShowErrors()
    {
        if (count(self::$error) <= 0) {
            return false;
        }
        foreach (self::$error as $key => $value) {
            echo $value . "<br>";
        }
    }


    private static function whatIsTheUserRoleAndLanguage()
    {
        $userId=null;
        $session = new Session();

        $user = new UserModel();
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $userId = $current_user->ID;
        }



        if (!$session->isthere("role")){
            if($user->getRole()=="administrator" || $user->getRole()=="contributor"){
                $session->create("role", "operationmanager");
            }else if ($user->getRole()=="editor"){
                $session->create("role", "producer");
            }else if ($user->getRole()=="subscriber"){
                $session->create("role", "customer");
            }
        }

        if(!$session->isthere("userId")){
            $session->create("userId", $userId);
        }



        $options = new OptionsModel();

        if($options->getLangueages()){
            if(!$session->isthere("lang")){
                $session->create("lang", $options->getLangueages());
            }
        }else{
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
            $options->setLangueages($lang);
            $session->create("lang",$lang);
        }









    }

    function existsController($ControllerName)
    {
        $filename = ROOT_PATH . '/src/ui/app/controllers/' . $ControllerName . "Controller.php";
        if (file_exists($filename)) {
            include $filename;
            return true;
        } else {
            return false;
        }
    }


    /**
     * [turkceKarakterTemizle türkçe karakterleri ingilizceye dönüştür boşlukları ise - ye dönüştür]
     * @param  [type] $param [string]
     * @return [type]        [string]
     */
    function turkceKarakterTemizle($param)
    {
        $tr = array("ç", "Ç", "ğ", "Ğ", "İ", "ı", "ü", "Ü", "ö", "Ö", "ş", "Ş");
        $ing = array("c", "C", "g", "G", "I", "i", "u", "U", "o", "O", "s", "S");
        return str_replace($tr, $ing, $param);
    }

    /**
     * [uniqidUret zaman damgası, rastgele sayı ve benzersiz bir unigiid üretir.]
     * @return [type] [benzersiz kimlik]
     */
    function uniqidUret()
    {
        $zaman = time();
        $rastgeleSayi = rand(1, 10000);
        $unigiId = uniqid();
        $kimlik = $unigiId;
        $kimlik = $zaman . "" . $rastgeleSayi . "" . $unigiId;
        return $kimlik;
    }

    /**
     * [yeniAdOlustur -> dosya adında büyük A-Z küçük a-z ve rakam dışında bulunan tüm karakterleri temizleyip boşlukları - yapar. ve dosyanın adına benzersiz bir ıd değeri atar.]
     * @param  [type] $text [metodun aldığı parametre]
     * @return [type]       [$yeni temizlenmiş olan değer]
     */
    function seoUrlOlustur($text)
    {
        $tr = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
        $ing = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', '', '');
        $text = strtolower(str_replace($tr, $ing, $text));
        $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
        $text = trim(preg_replace('/\s+/', ' ', $text));
        $text = str_replace(' ', '-', $text);
        return $text;
    }

    function pisset()
    {
        if ($_POST) {
            return true;
        } else {
            return false;
        }
    }

    function gisset()
    {
        if ($_GET) {
            return true;
        } else {
            return false;
        }
    }

    function post($value)
    {
        if (isset($_POST[$value])) {
            return (trim($_POST[$value]));
        } else {
            return false;
        }
    }

    function get($value)
    {
        if (isset($_GET[$value])) {
            return (trim($_GET[$value]));
        } else {
            return false;
        }
    }

    function git($value)
    {
        header("location:$value");
        exit();
    }

    function sureliGit($url, $sure = 1)
    {
        header("refresh:$sure;$url");
    }

    function pr($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    /**
     * kapanmanan etiketleri yazıyı kırparak kapatan fonksiyon */
    function make_excerpt($rawHtml, $length = 500)
    {
        $content = substr($rawHtml, 0, $length)
            . '&hellip; <a href="/link-to-somewhere">More &gt;</a>';
        $encoding = mb_detect_encoding($content);
        $doc = new DOMDocument('', $encoding);
        @$doc->loadHTML('<html><head>'
            . '<meta http-equiv="content-type" content="text/html; charset='
            . $encoding . '"></head><body>' . trim($content) . '</body></html>');
        $nodes = $doc->getElementsByTagName('body')->item(0)->childNodes;
        $html = '';
        $len = $nodes->length;
        for ($i = 0; $i < $len; $i++) {
            $html .= $doc->saveHTML($nodes->item($i));
        }
        return $html;
    }

    /**
     * kapanmayan html etiketleri kapatan fonksiyon
     */
    function etiketKapat($html)
    {
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</' . $openedtags[$i] . '>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }


    public function createTestPlace(){

//TEST DATALARI

        /*
         * Operasyon yoneticisi
         * username : useroperationmanager
         * password : ViewSonic.444
         *
         * Ureticiler
         * username : testproducer  - 3 adet ürün sahibi // 1 onaylanmamış , 1 reddedilmiş , 1 onaylanmış.
         * password : ViewSonic.444
         *
         * username : testproducer2 - 3 adet ürün sahibi  // hepsi onaylı
         * password : ViewSonic.444
         *
         * Müşteriler
         * username : testuser  - Verilerini tamamlamamış. (Fotoğraf ve bilgiler.)
         * password : ViewSonic.444
         *
         * username : testuser2 - Verilerini tamamlamış ve istekde bulunmuş ürün bekliyor. ve
         * password : ViewSonic.444                   birinci üretici üçüncü ürününü teklif etmiş ikinci üretici birinci ürünü teklif etmiş
         *                                            ayrıca 1 adet ürün görüntüleyebiliyor 2500 liralık
         *
         *
         * username : testuser3 - Teklif edilen ürünler onaylanmış ve gösteriliyor.kullanıcının istek süresi bitmiş
         * password : ViewSonic.444            3 ürün görüntüleyebiliyor 60,80,100 liralık
         *
         */



        include_once ROOT_PATH.'/src/data/concrete/UserDal.php';
        include_once ROOT_PATH.'/src/entities/concrete/UserConcrete.php';
        include_once ROOT_PATH.'/src/data/concrete/CustomerDal.php';
        include_once ROOT_PATH.'/src/entities/concrete/CustomerConcrete.php';
        include_once ROOT_PATH.'/src/data/concrete/OptionsDal.php';
        include_once ROOT_PATH.'/src/entities/concrete/OptionsConcrete.php';
        include_once ROOT_PATH.'/src/data/concrete/ProductDal.php';
        include_once ROOT_PATH.'/src/entities/concrete/ProductConcrete.php';
        include_once ROOT_PATH.'/src/data/concrete/MessageDal.php';
        include_once ROOT_PATH.'/src/entities/concrete/MessageConcrete.php';
        include_once ROOT_PATH.'/src/data/concrete/ProducerDal.php';
        include_once ROOT_PATH.'/src/entities/concrete/ProducerConcrete.php';
        include_once ROOT_PATH.'/src/ui/app/models/RequestModel.php';
        include_once ROOT_PATH.'/src/ui/app/models/UserModel.php';
        include_once ROOT_PATH.'/src/entities/concrete/RequestConcrete.php';
        include_once ROOT_PATH.'/src/data/concrete/RequestDal.php';
        $userDal = new UserDal();
        $user = new User();
        $customerDal = new CustomerDal();
        $cutomer = new Customer();
        $requestDal = new RequestDal();
        $request = new Request();
        $optionsDal = new OptionsDal();
        $options = new Options();
        $productDal = new ProductDal();
        $product = new Product();
        $messageDal= new MessageDal();
        $message = new Message();
        $producerDal= new ProducerDal();
        $producer = new Producer();
        $requestModel= new RequestModel();
        $usermodel = new UserModel();

// Operation manager ve üreticiler tanımlanıyor
        $user->setUserName("useroperationmanager");
        $user->setUserPass("ViewSonic.444");
        $user->setUserEmail("add@dd.com");
        $omanagerId = $userDal->createUser(
            $user,"contributor"
        );

        $producerId= $usermodel->addProducer(
            array(
                "username" => "testproducer",
                "email"    => "adddd@dd.com",
                "password" => "ViewSonic.444",
                "OfferLimit" => "5-15"
            )

        );


        $producerId2= $usermodel->addProducer(
            array(
                "username" => "testproducer2",
                "email"    => "adddddd@dd.com",
                "password" => "ViewSonic.444",
                "OfferLimit" => "5-15"
            )

        );


// Birinci üreticinin ürünlerini giriyoruz.
        $product->setProducerNO($producerId);
        $product->setPName("Test ürünü Bekliyor");
        $product->setDescProduct("Test ürünü açıklaması Bekliyor");
        $product->setType("1");
        $product->setStatus("o");
        $productDal->settingQuery($product);
        $productDal->insertToObject();
        $product->setProducerNO($producerId);
        $product->setPName("Test ürünü yanlış girilmiş");
        $product->setDescProduct("Test ürünü açıklaması yanlış girişmiş");
        $product->setType("1");
        $product->setStatus("2");
        $productDal->settingQuery($product);
        $productDal->insertToObject();
        $product->setProducerNO($producerId);
        $product->setPName("Test ürünü Doğru Onaylı.");
        $product->setDescProduct("Test ürünü Onaylı");
        $product->setType("1");
        $product->setBaseMaterial("1");
        $product->setClosureType("1");
        $product->setInsideBaseMeterial("1");
        $product->setInsideBaseType("1");
        $product->setLiningMeterial("1");
        $product->setSeason("1");
        $product->setTopMeterial("1");
        $product->setImage("https://www.adimadim.com.tr/dr-comfort-erkek-ortopedik-ayakkabi-a18ekcft00099-comfort-backsz-dr-comfort-comfort47-28-106810-68-K.jpg");
        $product->setImage2("https://n11scdn.akamaized.net/a1/450/giyim-ayakkabi/klasik-erkek-ayakkabi/dr-comfort-erkek-ortopedik-ayakkabi__1566973758749191.jpg");
        $product->setImage3("https://www.hapshoe.com/Uploads/UrunResimleri/libano-hakiki-deri-siyah-bordo-ortopedik-0ffe.jpg");
        $product->setStatus("1");
        $productDal->settingQuery($product);
        $firstproducerproductID = $productDal->insertToObject();

// İkinci üreticinin ürünlerini giriyoruz.

        $product->setProducerNO($producerId2);
        $product->setPName("İkinci üreticinin Test ürünü bir ");
        $product->setDescProduct("İkinci üreticinin Test ürünü açıklaması bir ");
        $product->setType("1");
        $product->setBaseMaterial("1");
        $product->setClosureType("1");
        $product->setInsideBaseMeterial("1");
        $product->setInsideBaseType("1");
        $product->setLiningMeterial("1");
        $product->setSeason("1");
        $product->setTopMeterial("1");
        $product->setImage("https://www.adimadim.com.tr/dr-comfort-erkek-ortopedik-ayakkabi-a18ekcft00099-comfort-backsz-dr-comfort-comfort47-28-106810-68-K.jpg");
        $product->setImage2("https://n11scdn.akamaized.net/a1/450/giyim-ayakkabi/klasik-erkek-ayakkabi/dr-comfort-erkek-ortopedik-ayakkabi__1566973758749191.jpg");
        $product->setImage3("https://www.hapshoe.com/Uploads/UrunResimleri/libano-hakiki-deri-siyah-bordo-ortopedik-0ffe.jpg");
        $product->setStatus("1");
        $productDal->settingQuery($product);
        $product1ID = $productDal->insertToObject();
        $product->setProducerNO($producerId2);
        $product->setPName("İkinci üreticinin Test ürünü iki ");
        $product->setDescProduct("İkinci üreticinin Test ürünü açıklaması iki ");
        $product->setType("1");
        $product->setBaseMaterial("1");
        $product->setClosureType("1");
        $product->setInsideBaseMeterial("1");
        $product->setInsideBaseType("1");
        $product->setLiningMeterial("1");
        $product->setSeason("1");
        $product->setTopMeterial("1");
        $product->setImage("https://www.adimadim.com.tr/dr-comfort-erkek-ortopedik-ayakkabi-a18ekcft00099-comfort-backsz-dr-comfort-comfort47-28-106810-68-K.jpg");
        $product->setImage2("https://n11scdn.akamaized.net/a1/450/giyim-ayakkabi/klasik-erkek-ayakkabi/dr-comfort-erkek-ortopedik-ayakkabi__1566973758749191.jpg");
        $product->setImage3("https://www.hapshoe.com/Uploads/UrunResimleri/libano-hakiki-deri-siyah-bordo-ortopedik-0ffe.jpg");
        $product->setStatus("1");
        $productDal->settingQuery($product);
        $product2ID = $productDal->insertToObject();
        $product->setProducerNO($producerId2);
        $product->setPName("İkinci üreticinin Test ürünü bir ");
        $product->setDescProduct("İkinci üreticinin Test ürünü açıklaması üç ");
        $product->setType("1");
        $product->setBaseMaterial("1");
        $product->setClosureType("1");
        $product->setInsideBaseMeterial("1");
        $product->setInsideBaseType("1");
        $product->setLiningMeterial("1");
        $product->setSeason("1");
        $product->setTopMeterial("1");
        $product->setImage("https://www.adimadim.com.tr/dr-comfort-erkek-ortopedik-ayakkabi-a18ekcft00099-comfort-backsz-dr-comfort-comfort47-28-106810-68-K.jpg");
        $product->setImage2("https://n11scdn.akamaized.net/a1/450/giyim-ayakkabi/klasik-erkek-ayakkabi/dr-comfort-erkek-ortopedik-ayakkabi__1566973758749191.jpg");
        $product->setImage3("https://www.hapshoe.com/Uploads/UrunResimleri/libano-hakiki-deri-siyah-bordo-ortopedik-0ffe.jpg");
        $product->setStatus("1");
        $productDal->settingQuery($product);
        $product3ID = $productDal->insertToObject();











// İlk test kullanıcısı oluşturuluyor
        $user->setUserName("testuser");
        $user->setUserEmail("a@bc.com");
        $user1ID = $userDal->createUser(
            $user,"subscriber"
        );
        $cutomer->setUserId($user1ID);
        $cutomer->setBespokeStatus("NoCompolete");
        $customerDal->settingQuery($cutomer); // make input and query
        $customerDal->insertToObject();



// İkinci test kullanıcısı oluşturuluyor
        $user->setUserName("testuser2");
        $user->setUserEmail("ab@bc.com");
        $user2ID = $userDal->createUser(
            $user,"subscriber"
        );
        $cutomer->setUserId($user2ID);
        $cutomer->setAge("37");
        $cutomer->setBespokeStatus("Waiting");
        $cutomer->setExtraFilePath("http://localhost/wp-content/plugins/mega-main-menu/framework/src/img/megamain-logo-120x120.png+-+http://localhost/wp-content/plugins/woocommerce-shipstation-integration/assets/images/shipstation-logo-blue.png+-+");
        $cutomer->setExtraInfo("Doktor ayağımın taraklı olduğunu söyledi ve deri tabanlık koku yapıyor.");
        $cutomer->setFootImage("https://cdn.iha.com.tr/Contents/images/2016/06/1508383.jpg");
        $cutomer->setFootImage2("http://www.saglikbilgileri.net/wp-content/uploads/ayak-agrisi3-620x304.jpg");
        $cutomer->setFootImage3("https://www.alternatifterapi.com/Uploads/PageContentImages/13998/b/nocanvas_ayak-mantari-84bcc.jpg");
        $cutomer->setFootSize("42");
        $cutomer->setFootsphereFilePath("https://img1.cgtrader.com/items/240780/8492f96bd1/human-foot-3d-model-max-obj-3ds-fbx-stl-dwg.jpg");
        $cutomer->setLength("183");
        $cutomer->setWeight("79");
        $customerDal->settingQuery($cutomer); // make input and query
        $customerDal->insertToObject();
        $datetime = date('Y-m-d H:i:s');
        $requestOptionsID1= $optionsDal->addRequest($user2ID,"0", (strtotime($datetime)));

        $requestModel->createRequest(
            array(
                "ProducerNo" => $producerId,
                "RequestID" => $requestOptionsID1,
                "Products" => $firstproducerproductID.":"."50".":"."USD".":"."$".";",
                "Type" => "1",
                "Status"=> "0"

            ),
            $user2ID
        );

        $requestModel->createRequest(
            array(
                "ProducerNo" => $producerId2,
                "RequestID" => $requestOptionsID1,
                "Products" => $product1ID.":"."80".":"."USD".":"."$".";",
                "Type" => "1",
                "Status"=> "0"

            ),
            $user2ID
        );

        $user->setUserName("testuser3");
        $user->setUserEmail("abc@bc.com");
        $user3ID = $userDal->createUser(
            $user,"subscriber"
        );
        $cutomer->setUserId($user3ID);
        $customerDal->settingQuery($cutomer); // make input and query
        $customerDal->insertToObject();
        $requestOptionsID2 = $optionsDal->addRequest($user3ID,"0", (strtotime($datetime) -(100000)));

        $requestModel->createRequest(
            array(
                "ProducerNo" => $producerId2,
                "RequestID" => $requestOptionsID2,
                "Products" => $product1ID.":"."60".":"."USD".":"."$".";".$product2ID.":"."80".":"."USD".":"."$".";".$product3ID.":"."100".":"."USD".":"."$".";",
                "Type" => "1",
                "Status"=> "2"
            ),
            $user3ID
        );

        $PName = $product->getPName();
        $DescProduct = $product->getDescProduct();
        $Image = $product->getImage();
        $ProducerNO = $producerId2;
        $product->ResetObject();
        $product->setPName($PName);
        $product->setDescProduct($DescProduct);
        $product->setImage($Image);
        $product->setPrice("60");
        $product->setID($product1ID);
        $product->setProducerNO($ProducerNO);
        $ReadProductID = $productDal->addProductReal($product,$user3ID);
        $customerDal->addProductToUser($ReadProductID,$user3ID);

        $product->setPrice("80");
        $product->setID($product2ID);
        $ReadProductID2 = $productDal->addProductReal($product,$user3ID);
        $customerDal->addProductToUser($ReadProductID2,$user3ID);

        $product->setPrice("100");
        $product->setID($product3ID);
        $ReadProductID3 = $productDal->addProductReal($product,$user3ID);
        $customerDal->addProductToUser($ReadProductID3,$user3ID);

        $product->setPrice("2500");
        $product->setID($product3ID);
        $ReadProductID4 = $productDal->addProductReal($product,$user2ID);
        $customerDal->addProductToUser($ReadProductID4,$user2ID);



        // Mesajlar oluşturuluyor.


        // Üretici ile Operasyon yöneticisi ile arasında geçen dialog
        $message->setDate(date("Y-m-d H:i:s"));
        $message->setStatus(1);

        $message->setUserId(3);
        $message->setWhoIsMessage(1);
        $message->setMessage("Merhaba üreticiyim. yardım istiyorum");
        $messageDal->settingQuery($message);
        $messageDal->insertToObject();
        $message->setWhoIsMessage(1);
        $message->setMessage("Hemen Yardımcı olayım.");
        $messageDal->settingQuery($message);
        $messageDal->insertToObject();
        $message->setStatus(1);
        $message->setWhoIsMessage(1);
        $message->setMessage("Bekliyorum ");
        $messageDal->settingQuery($message);
        $messageDal->insertToObject();


        // MÜşteri ile Operasyon yöneticisi ile arasında geçen dialog

        $message->setDate(date("Y-m-d H:i:s"));
        $message->setStatus(1);
        $message->setUserId($user1ID);
        $message->setWhoIsMessage(1);
        $message->setMessage("Merhaba");
        $messageDal->settingQuery($message);
        $messageDal->insertToObject();
        $message->setWhoIsMessage(1);
        $message->setMessage("Merhaba");
        $messageDal->settingQuery($message);
        $messageDal->insertToObject();
        $message->setStatus(1);
        $message->setWhoIsMessage(1);
        $message->setMessage("ürün alamıyorum ");
        $messageDal->settingQuery($message);
        $messageDal->insertToObject();


        //TEST DATALARI


    }

    public function createRulesInAAM(){
        include_once ROOT_PATH.'/src/core/lib/AamUserRoles.php';
        $roles = new AamUserRoles();
    }


}