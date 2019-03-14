<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 05.03.2019
 * Time: 11:09
 */


include_once ROOT_PATH . '/src/ui/app/models/MessageModel.php';

class messagesController extends Controller
{

    private static $sendData = array();

    private $messageModel;




    public function __construct()
    {
        parent::__construct();

    }


    public function home($data = false)
    {
        parent::__construct();
        self::createColumns();
        $this->messageModel = new MessageModel($data);
        $this->sendData['data'] = $data;
        if (!$data) {
            if ($this->userRole == "operationmanager") {
                $productArray = $this->messageModel->getAllMessage();
                self::listing($productArray);


            }else{
              header("Location: /wp-admin/admin.php?page=footsphere&Messages&home&".$GLOBALS['userId']);

            }
        } else {
            self::showing($data);
        }


        if(isset($_POST['sendingButton'])){
            echo "girdi";
            $this->messageModel->writeMessage($_POST['messageBox']);
        }

        if(isset($_POST['readButton'])){
            $this->messageModel->setTheUserMessagesRead($data);
        }






    }


    private function listing($PArray)
    {
        $result = '';

        if ($PArray){
            $result = self::prepareMessagesArray($PArray);


            $this->sendData['products'] = $result;
            Controller::$view->view("message/messagelist", $this->sendData);
       }

    }

    private  function prepareMessagesArray($productArray)
    {
        $returnlast =" ";


        $userIdArray = array();


        foreach ($productArray as $key => $value) {
            if($value['UserId']){
                $userIdArray[$value['UserId']] = $value;
            }
        }

        foreach ($userIdArray as $key => $value){
            $result = self::fixColumn($value);

            $returnlast =  $returnlast . $result;
        }

        return $returnlast;
    }


    private static function fixColumn($value)
    {
        $userIdArray = array();
        $i = 0;

        $result = null;
        $userId = $value['UserId'];
        if ( $value['Status'] == "Unread"){
            $status = $GLOBALS['string']['okunmamis'];
        }else{
            $status = $GLOBALS['string']['okunmus'];
        }
        $readButton = '<form method="POST" role="form" action="/wp-admin/admin.php?page=footsphere&Messages&home&'.$userId.'"> 
 <button name="readButton" id="readButton" class="btn btn-info btn-xs" type="submit">


'.$GLOBALS['string']['oku'].'</button>
 </form>
';


        if(strlen($value['Message'])>50){
            $message= substr($value['Message'],0,50)."...";
        }
        else{
            $message  = $value['Message'];
        }
        $result =
        "<td>" . $readButton . "</td>".
        "<td>" . $status . "</td>".
        "<td>" . $message. "</td>".
        "<td>" . $value['Date'] . "</td>";
        return  "<tr>" .$result .'
                      </tr> ' ;;
    }

    public function showing($data)
    {

        $data = explode("-",$data);
        $id = $data[0];
        $proces = $data[1];

        if($this->userRole!="operationmanager"){

            if($id!=$GLOBALS['userId']){
                die();
            }
        }
        $this->messageModel = new MessageModel($id);
        $Messages  = $this->messageModel->getAllMessageForUser();

        $in =  ' <div class="incoming_msg">
                    <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                    <div class="received_msg">
                        <div class="received_withd_msg">';
        $out =  ' <div class="outgoing_msg"> <div class="sent_msg">';

        $return = '';
        foreach ($Messages as $key => $value){
            $message = $value['Message'];
            $date= $value['Date'];
            $WhoIsMessage = $value['WhoIsMessage'];

            $result = '';
            if($this->userRole=="operationmanager"){
                if($WhoIsMessage=="editor"){
                    $result  = $in . '<p>' .$message.'</p>';
                }else{
                    $result  = $out . '<p>' .$message.'</p>';
                }
            }else{
                if($WhoIsMessage=="administrator"){
                    $result  = $in . '<p>' .$message.'</p>';
                }else{
                    $result  = $out . '<p>' .$message.'</p>';
                }
            }


            $return = $return.$result . " <span class=\"time_date\">".$date."</span> </div> </div>";
        }







        $this->sendData['messages'] = $return;




        Controller::$view->view("message/message", $this->sendData);
    }

    private function createColumns()
    {


        $columTitleNameArray = array(
            "",
            $GLOBALS['string']['durum'],
            $GLOBALS['string']['shortmessage'],
            $GLOBALS['string']['date']

        );
        $columNameTitles = null;
        foreach ($columTitleNameArray as $key => $value) {
            $columNameTitles = $columNameTitles . "<th>" . $value . "</th>";
        }


        $this->sendData['columns'] = $columNameTitles;

        $this->productFeaturesArray = array(
            "Type" => array(
                $GLOBALS['string']['ayakkabi'],
                $GLOBALS['string']['terlik']
            ),
            "BaseMaterial" => array(
                $GLOBALS['string']['kaucuk'],
                $GLOBALS['string']['PU'],
                $GLOBALS['string']['termo']
            ),
            "ClosureType" => array(
                $GLOBALS['string']['gecme'],
                $GLOBALS['string']['cirtcirtli'],
                $GLOBALS['string']['bagcikli']
            ),
            "TopMeterial" => array(
                $GLOBALS['string']['deri'],
                $GLOBALS['string']['sunideri'],
                $GLOBALS['string']['kumas']
            ),
            "Season" => array(
                $GLOBALS['string']['ilkbahar'],
                $GLOBALS['string']['yaz'],
                $GLOBALS['string']['sonbahar'],
                $GLOBALS['string']['kis']
            ),
            "liningMeterial" => array(
                $GLOBALS['string']['deri'],
                $GLOBALS['string']['kumas']
            ),
            "InsideBaseType" => array(
                $GLOBALS['string']['sabit'],
                $GLOBALS['string']['degistirilebilir']
            ),
            "InsideBaseMeterial" => array(
                $GLOBALS['string']['deri'],
                $GLOBALS['string']['sunger'],
                $GLOBALS['string']['hafizalisunger']
            ),

            "Status" => array(
                $GLOBALS['string']['beklemede'],
                $GLOBALS['string']['onaylandi'],
                $GLOBALS['string']['onaylanmadi']
            )
        );
    }


    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}