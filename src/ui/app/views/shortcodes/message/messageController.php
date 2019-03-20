<?php
/**
 * Created by PhpStorm.
 * User: iksmtr
 * Date: 20.03.2019
 * Time: 11:01
 */

include_once ROOT_PATH . '/src/ui/app/models/MessageModel.php';

class messageController
{
    public static $data;
    public static $userRole;
    public  $messageModel;

    public function __construct()
    {
        $this->messageModel = new MessageModel($GLOBALS['userId']);

        if(isset($_POST['sendingButton'])){
            $this->messageModel->writeMessage($_POST['messageBox']);
        }
        self::showing();


    }

















    /**
     * @return mixed
     */
    public static function getData()
    {
        return self::$data;
    }

    /**
     * @param mixed $data
     */
    public static function setData($data)
    {
        self::$data = $data;
    }

    private  function showing()
    {


        $Messages  = $this->messageModel->getAllMessageForUser();

;        $in =  ' <div class="incoming_msg">
                    <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                    <div class="received_msg">
                        <div class="received_withd_msg">';
        $out =  ' <div class="outgoing_msg"> <div class="sent_msg">';

        $return = '';
        if($Messages){
            foreach ($Messages as $key => $value){
                $message = $value['Message'];
                $date= $value['Date'];
                $WhoIsMessage = $value['WhoIsMessage'];

                $result = '';

                    if($WhoIsMessage==0){
                        $result  = $in . '<p>' .$message.'</p>';
                    }else{
                        $result  = $out . '<p>' .$message.'</p>';
                    }



                $return = $return.$result . " <span class=\"time_date\">".$date."</span> </div> </div>";
            }
        }








        self::$data['messages'] = $return;
    }

}