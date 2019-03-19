<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 05.03.2019
 * Time: 11:08
 */


include_once ROOT_PATH . '/src/ui/app/models/RequestModel.php';
include_once ROOT_PATH . '/src/ui/app/models/OptionsModel.php';
include_once ROOT_PATH . '/src/ui/app/models/UserModel.php';

class requestsController extends Controller
{

    private static $sendData = array();

    private $requestModel;
    private $optionsModel;


    public function __construct()
    {
        parent::__construct();
        $this->sendData['Type'] = array(
            $GLOBALS['string']['ayakkabi'],
            $GLOBALS['string']['terlik']
        );
        $this->userRole = $_SESSION['role'];

        $this->optionsModel = new OptionsModel();

        $this->sendData['StatusArray']= array(
            "" => $GLOBALS['string']['requestStatusDevam'],
            0=>$GLOBALS['string']['requestStatusDevam'],
            1=>$GLOBALS['string']['requestStatusKabul'],
            2=>$GLOBALS['string']['requestStatusChecked'],
            3=>$GLOBALS['string']['requestStatusUnChecked']
        );


    }



    public function home($data = false)
    {
        $this->requestModel = new RequestModel($data);

        if (!$data) {
            self::listing();
        } else {
            self::showing($data);
        }

    }


    private  function fixColumn($value)
    {

        $result = '';

        if($this->userRole =="operationmanager"){
            $userId = $value['UserID'];
            $this->optionsModel = new OptionsModel($userId);


            $requestNo = $value['RequestNo'];
            $productType = $this->sendData['Type'][$value['Type']] ;
            $status = $this->sendData['StatusArray'][$value['Status']];
            $productAndPrice = $value['ProductsAndPrices'];
            $producerNo = '<a href="/wp-admin/admin.php?page=footsphere&Producers&home&'.$value['ProducerNo'].'-edit" class="btn btn-warning"><em class="fa fa-external-link"></em></a>';
            $date = $this->optionsModel->getTheRequestTime($value['Type']);

            $inceleButton = '<a href="/wp-admin/admin.php?page=footsphere&Requests&home&'.$value['ID'].'-edit" 
         class="btn btn-primary">'.$GLOBALS['string']['incele'].'</a>';


            $result =
                "<td>" . $inceleButton . "</td>".
                "<td>" . $requestNo . "</td>".
                "<td>" . $productType . "</td>".
                "<td>" . $date[0] . "</td>".
                "<td>" . $userId . "</td>".
                "<td>" . $producerNo . "</td>".
                "<td>" . $status . "</td>".
                "<td>" . $productAndPrice . "</td>";

        }else {
            $option_name= explode("_",$value['option_name']);
            $date = $value['option_value'];
            $productType = $this->sendData['Type'][$option_name[3]];
            $userId = $option_name[2];
            $requestNo =$value['option_id'];
            $inceleButton = '<a href="/wp-admin/admin.php?page=footsphere&Requests&home&'.$requestNo.'-edit" class="btn btn-primary">'.$GLOBALS['string']['teklifver'].'</a>';



            $result =
                "<td>" . $inceleButton . "</td>".
                "<td>" . $requestNo . "</td>".
                "<td>" . $productType . "</td>".
                "<td>" . $date. "</td>"
              ;
        }


        return  "<tr>" .$result ."
                      </tr> ";
    }

    private function listing()
    {

        $result = '';
        if($this->userRole=="operationmanager"){

            $requests = $this->requestModel->getAllRequest();
            self::createColumnsForOperationManager();
            foreach ($requests as $key => $value){
                $result = $result . self::fixColumn($value);
            }

        }else if($this->userRole=="producer"){
            $this->optionsModel = new OptionsModel();
            self::createColumnsForProducer();
            $requests = $this->optionsModel->getAllRequest();
            foreach ($requests as $key => $value){
                $result = $result . self::fixColumn($value);
            }

        }

        $this->sendData['request'] =$result ;






        Controller::$view->view("requests/requestlist", $this->sendData);

    }



    public function showing($data)
    {

        $data = explode("-",$data);
        $id = $data[0];
        $proces = $data[1];

        if($this->userRole!="operationmanager"){

            if($id!=$GLOBALS['userId']){

            }
        }

        $this->requestModel = new RequestModel();

        if($this->userRole == "operationmanager"){
            $requests = $this->requestModel->getRequest(array("ID"=>$id));
        }else if ($this->userRole=="producer"){


            $requests = $this->requestModel->getRequest(array("RequestNo"=>$id,
                "ProducerNo"=>$GLOBALS['userId']));

        }
       $UserId = $requests['UserID'];
        $ProducerNo = $requests['ProducerNo'];
        $RequestNo = $requests['RequestNo'];
        $ProductsAndPrices = $requests['ProductsAndPrices'];
        $Status = $requests['Status'];
        $Type = $requests['Type'];

        $UserModel = new UserModel($UserId);
        $customer = $UserModel->getCustomer();

        $this->sendData['age'] = $customer[0]['Age'];
        $this->sendData['lenght'] = $customer[0]['Length'];
        $this->sendData['weight'] = $customer[0]['Weight'];
        $this->sendData['footsize'] = $customer[0]['FootSize'];
        $this->sendData['image'] = $customer[0]['FootImage'];
        $this->sendData['image2'] = $customer[0]['FootImage2'];
        $this->sendData['image3'] = $customer[0]['FootImage3'];
        $this->sendData['extrainfo'] = $customer[0]['ExtraInfo'];



        Controller::$view->view("requests/request", $this->sendData);
    }


    private function createColumnsForOperationManager()
    {


        $columTitleNameArray = array(
            "",
            $GLOBALS['string']['istekNumarasi'],
            $GLOBALS['string']['backend_comp_turuText'],
            $GLOBALS['string']['date'],
            $GLOBALS['string']['kullanici'],
            $GLOBALS['string']['üretici'],
            $GLOBALS['string']['durum'],
            $GLOBALS['string']['urun']

        );
        $columNameTitles = null;
        foreach ($columTitleNameArray as $key => $value) {
            $columNameTitles = $columNameTitles . "<th>" . $value . "</th>";
        }
        $this->sendData['columns'] = $columNameTitles;

    }


    private function createColumnsForProducer()
    {

        $columTitleNameArray = array(
            "",
            $GLOBALS['string']['istekNumarasi'],
            $GLOBALS['string']['backend_comp_turuText'],
            $GLOBALS['string']['date']

        );
        $columNameTitles = null;
        foreach ($columTitleNameArray as $key => $value) {
            $columNameTitles = $columNameTitles . "<th>" . $value . "</th>";
        }

        $this->sendData['columns'] = $columNameTitles;
    }

























    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}