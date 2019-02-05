<?php
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/component.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/user.php");
require_once(ABSPATH . "wp-content/plugins/footsphere/classes/popupwindow.php");

class message
{
    private $first;
    private $last;
    private $onclick;
    private $result;
    private $jsCode;
    private $messageALL;
    private $messageTextArea;
    private $component;
private $dil ; 

private $deneme;
    function __construct()
    {


        wp_enqueue_style('message');
        wp_enqueue_script('message'); //CSS VE JS Dosyalari aktifleşitiriyor.

        $this->component = new component();

        $this->first = '
        
        ';

        $this->last = '
        <script>
        
        jQuery(#messagelistbox).animate({scrollTop: document.body.scrollHeight},"fast");

        </script>
        ';

        require_once(ABSPATH."/wp-content/plugins/footsphere/languages/languages.php");
        $lang = new languages(0);
        $this->dil = $lang->getDil();
        $this->messageTextArea = $this->component->getTextarea("messageBox", $this->dil['backend_contact_messageTextAreaAciklama'], 100, false);
  
   
        echo "200dolar = " . $lang->usdToLocal(200);
       
     
        /// "dsad" .$this->dil['gonderYazisi'];


    }

    public function setINMESSAGE($arrayValue)
    {
        $result = '
        ';



        for ($i = 0; $i < count($arrayValue); $i++) {
            $backgroundcolor = 'white';
            if ($arrayValue[$i]['mesajSahibi'] == "white") {
                $messagesahibi = "darker";
                $messagesahibiAD = $this->dil['backend_contact_messageSen'];
            } else {
                $backgroundcolor = "pink";
                $messagesahibi = "darker";
                $messagesahibiAD =$this->dil['backend_contact_messageYetkili'];
            }
            $message = $arrayValue[$i]['mesaji'];
            $date = $arrayValue[$i]['date'];
            $messagestatus = $arrayValue[$i]['Status'];

            $result = $result . '
            <div style="background-color:' . $backgroundcolor . ';" class="container ' . $messagesahibi . '">
            <h5 class="mesajSahibi">' . $messagesahibiAD . '</h5>
            <p>' . $message . '</p>
            <span class="time-right">' . $date . '</span>
            </div>
            ';

        }

        $this->messageALL = $result;

    }

    public function userInfo($userID)
    {
        /*
        <a class="thumb"><h5>Kullanıcı bilgisini görüntüle</h5>
        <span>
        
        <div style="background-color:red; width=:40%;">
        <h1>Adı : '.$user->getUser_displayname().'<br></h1> 
        <h1>Email : '.$user->getUser_email().' <br></h1>
        <h1>Kullanıcının dili : '.$bespokeDB->getLangueages($userID).' <br></h1>
        <h1>Satın aldığı ürün : asdasd</h1> <br> <br>

        </div>

        </span></a></span>
         */
        $bespokeDB = new bespokeDB();
        $user = new user($userID);
        $rol = $user->getUser_role();
        $baslik ='';
        $icerik='';

        
       
        if ($rol == "editor") {
            $baslik = $this->dil['backend_contact_messageUreticiBilgi'];
            $icerik = 
            $user->getUser_displayname()."<br>".
            $user->getUser_email()."<br>".
            $user->getUser_languages()."<br>"
            ;

        } else {
           
            $baslik = $this->dil['backend_contact_messageKullaniciBilgi'];
            $icerik = 
            $user->getUser_displayname()."<br>".
            $user->getUser_email()."<br>".
            $user->getUser_languages()."<br>"
            ;

        }
        
        $array = array(
            array(
                'type' => "text",
                'id' => "kAdi",
                'name' => $icerik,
                'exs' => '',
                'key' => '',
                'value' => '',
                'button' => false
            )
        );
        $this->component->setPopupwindow($baslik, $array);
      //  $popupwindow = new popupwindow("Kullanıcı bilgileri");

      //  $popupwindow->setRows("text", "kadi", "Kullanıcı adı: <b>".$user->getUser_displayname()."</b>");
       // $popupwindow->setRows("text", "kadi", "email: <b>".$user->getUser_email()."</b>");
//$popupwindow->setRows("text", "kadi", "dili: <b>".$bespokeDB->getLangueages($userID)."</b>");
       // $popupwindow->setRows("text", "kadi", "satın aldığı ürün:<b>".$user->getUser_displayname()."</b>");




        return $this->component->getPopupwindow();
    }

    public function getAllMesage($userID = 0, $operator = false)
    {

        $bespokeDB = new bespokeDB();

        if ($operator) {
            $popup = self::userInfo($userID);
            $action = 'admin.php?page=contact';

        } else {
            $popup = '';
            $action = '';
        }
        $result = $result . '
  
<div id="messagelistbox" name="messagelistbox" style="overflow: auto; width: 100%;  height: 650px; position: relative;" >

' . $this->messageALL . '
</div>

<div>

<form method="POST" action="' . $action . '" >
' . $this->messageTextArea . '
<input type="hidden" value="' . $userID . '" name="hiddenValueUser" id="hiddenValueUser" name="O_" />
<button class="button button-primary" name="gonderButton" type="submit" class="btn">'.$this->dil['gonderYazisi'].'</button>
<button class="button button-primary" type="submit" class="btn cancel">'.$this->dil['kapatYazisi'].'</button>
</form>
</div>
<label class="prompt" for="content" id="content-prompt-text"> ' . $popup . '</label><br>

</div>

        ';

        $this->result = $result;
        self::setResult($result);
    }

    public function getPopupChat()
    {

        $result = $result . '
            <button class="open-button" onclick="openForm()">Chat</button>

<div class="chat-popup" id="myForm">
  <form action="" class="form-container">
    <h1>Chat</h1>
    <div style="overflow: auto; width: 100%;  height: 650px; position: relative;" >

    ' . $this->messageALL . '
    </div>
    <div>
    ' . $this->messageTextArea . '
    <button type="submit" class="btn">Gönder</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Kapat</button>
    </div>
  </form>
</div>

            ';

        $this->result = $result;
        self::setResult($result);
    }


    private function JSCODE()
    {

        return '
       
' . self::CSSCSSCODE() . '
        ';

    }

    private function CSSCSSCODE()
    {
        return '

        ';
    }


    /**
     * Set the value of result
     *
     * @return  self
     */
    public function setResult($result)
    {
        $this->result = $this->reset . $result;

        return $this;
    }

    /**
     * Get the value of result
     */
    public function getResult()
    {
        $this->result = $this->result . ' ' . self::JSCODE() . '' . self::CSSCSSCODE();
        return $this->result;
    }
}



?>
