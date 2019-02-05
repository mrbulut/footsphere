<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/tablepage.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/table.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/message.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");

require_once(ABSPATH . "wp-content/plugins/footsphere/lib/Cookie.php");

require_once(ABSPATH . "wp-content/plugins/footsphere/database/productDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/bespokeDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/contactDB.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/database/producerDB.php");
class messagelistpage extends tablepage
{
    private $dil;
    public function __construct()
    {
        $js = null;
        $css = null;
        $new = new tablepage($js, $css);
        $database = new productDB();
        $bespokeDB = new bespokeDB();
        $producerDB = new producerDB();
        $component = new component();
        $contactDB = new contactDB();

        require_once(ABSPATH . "/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();

        if (isset($_POST['gonderButton'])) {
            echo "<script>alert(" . $_POST['messageBox_area'] . "-" . $_POST['hiddenValueUser'] . ");</script>";
            $contactDB = new contactDB();
            $contactDB->mesajYaz($_POST['messageBox_area'], $_POST['hiddenValueUser']);

        }
        $list = $bespokeDB->getTotalUser();
        for ($i = 0; $i < count($list); $i++) {
            if ($_POST['durumSec'] == "" || $_POST['durumSec'] == null) {

                if (!$contactDB->okunmamisMesajiVarmi($list[$i]['userID']))
                    $backgroundColor = "pink";
                else
                    continue;


            } else {
                if (!$contactDB->okunmamisMesajiVarmi($list[$i]['userID']))
                    $backgroundColor = "pink";
                else
                    $backgroundColor = "white";
            }
            $toplamMesajSayisi = $contactDB->getTotalMessageLenght($list[$i]['userID']);
            if ($toplamMesajSayisi != 0) {

                $this->inArray[$i] = array(
                    $list[$i]['userID'],
                    $backgroundColor,
                    $component->getButton("okuButton", $this->dil['okumakicinTikla']   , "message", $list[$i]['userID']),
                    self::getUser($list[$i]['userID']),
                    $contactDB->getTotalMessageLenght($list[$i]['userID']),
                    $contactDB->getLastMessageDate($list[$i]['userID'])

                );
               // $table->setRows($arrayRows, false, true, false, true);
            }

        }

        $this->arrayHead = array($this->dil['oku'],  $this->dil['kullanici'],  
        $this->dil['toplamMesajSayisi'],  
        $this->dil['sonMesajTarihi'],   "");
        $this->baslik =  $this->dil['mesajlar'];

    }

    public function setupPage()
    {
        self::setBaslik($this->baslik);
        self::createTable($this->arrayHead, $this->inArray, $this->jscode, false, true, false, false, false, false);
        $arrayValue = array(
            array(
                'id' => 0,
                'deger' => $this->dil['tumu']
            )
        );
        self::setPopupmenu(
            "durumSec",
            $this->dil['durumsec'],
            "",
            $arrayValue,
            "id",
            "deger",
            true,
            $this->dil['okunmamisMesajlar'],
            $this->dil['durumsec']
        );

       /* $message = new message();

    $message->setINMESSAGE($contactDB->getAllMessageUserID(Cookie::get('messageUserID')));

    $message->getAllMesage();

    $table->JSCODE("", "", '
        
    ', $message->getResult());

        //  self::setPopupwindow($this->name, null);//null ise product gelir
        /*self::setPopupmenu(
            $this->id,
            $this->popupname,
            $this->desc,
            $this->listid,
            $this->key,
            $this->value,
            $this->buttonEnabled = true,
            $this->bosYazi = '',
            $this->buttonText
        );*/
    }

    public function getUser($userID)
    {
        $user = new user($userID);
        return "<b>" . $user->getUser_displayname() . "</b><br>" . $user->getUser_login();
    }
}





?>
