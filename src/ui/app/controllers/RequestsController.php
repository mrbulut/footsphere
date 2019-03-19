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
include_once ROOT_PATH . '/src/ui/app/models/ProductModel.php';

class requestsController extends Controller
{

    private static $sendData = array();

    private $requestModel;
    private $optionsModel;
    private $productModel;
    private $teklifedilenurunler;


    public function __construct()
    {
        parent::__construct();
        $this->sendData['Type'] = array(
            $GLOBALS['string']['ayakkabi'],
            $GLOBALS['string']['terlik']
        );
        $this->userRole = $_SESSION['role'];


        $this->optionsModel = new OptionsModel();
        $this->productModel = new ProductModel();

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

        if(isset($_POST['UpdateButton'])){
            $requestID = $_POST['RequestID'];
            $PandP = $_POST['hiddenValueProductAndPrices'];
            $this->requestModel->setRequestProduct($requestID,$PandP);
        }
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
                "<td>" . $date[0] ." ".$date[1] . "</td>".
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
        $ID=$requests['ID'];
        $UserId = $requests['UserID'];
        $ProducerNo = $requests['ProducerNo'];
        $ProductsAndPrices = $requests['ProductsAndPrices'];
        self::setupProducerProducts($ProducerNo,$ProductsAndPrices);
        $RequestNo = $requests['RequestNo'];
        $deleteText =$GLOBALS['string']['sil'];
        $hiddenValue = ' 
        
        <input type="hidden" id="hiddenValueProductAndPrices" name="hiddenValueProductAndPrices" value="'.$ProductsAndPrices.'">';
        $requestID = ' 
        <input type="hidden" id="deleteText" name="deleteText" value="'.$deleteText.'">
        <input type="hidden" id="RequestID" name="RequestID" value="'.$ID.'">';

        $ProductsAndPrices =explode(";", $ProductsAndPrices);
        self::showProducts($ProductsAndPrices);
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
        $this->sendData['hiddenValueProductAndPrices'] = $hiddenValue;

        $this->sendData['RequestID'] = $requestID;


        Controller::$view->view("requests/request", $this->sendData);
    }


    private  function showProducts($ProductsAndPrices)
    {
        $result = '';
        foreach ($ProductsAndPrices as $key => $value){
            $value = explode(":",$value);
            $ProductID=$value[0];
            $this->teklifedilenurunler[$key] = $ProductID;

            $ProductPriceType=$value[2];
            $ProductPriceTypeSymbol=$value[3];
            $Product = $this->productModel->getProduct($ProductID);
            $image=$Product['Image'];
            $image2=$Product['Image2'];
            $image3=$Product['Image3'];
            $PName = $Product['PName'];
            $DescProduct= $Product['DescProduct'];
            $ProductPrice=$value[1];

            $deleteText=$GLOBALS['string']['sil'];
            if($image){
                $result = $result . '
            
            <div id="'.$ProductID.'_div" name="'.$ProductID.'_div"class="profile-activity clearfix">
                            <div>

                                <img class="pull-left"  src="'.$image.'">
                                <img class="pull-left"  src="'.$image2.'">
                                <img class="pull-left"  src="'.$image3.'">

                                <b>'.$PName.'  </b>
                                '.$DescProduct.'
                                
                                <button  type="button" onclick="deleteFunction('.$ProductID.')"  class=" btn btn-sm btn-danger tools action-buttons">
                                    '.$deleteText.'
                                </button>
                                
                                <div class="time">
                                    <i class="fa fa-money" ></i>
                                     '.$ProductPrice.' '.$ProductPriceTypeSymbol.' 
                                </div>
                            </div>

                            <div class="tools action-buttons-xl">
                                <a href="#" class="red">
                                    <i class="ace-icon fa fa-times bigger-125"></i>
                                </a>
                            </div>

                        </div>
            
            ';
            }


        }

        $this->sendData['teklifedilenurunler'] = $result ;

    }


    private  function setupProducerProducts($ProducerNo,$ProductsAndPrices)
    {

        $ProductsAndPrices = explode(";",$ProductsAndPrices);

        $result = '<div class="row" >' ;
        $Products = $this->productModel->getAllProduct(array("ProducerNo" => $ProducerNo));

        foreach ($Products as $key => $value){


            $gecerli = true;
            $status = $value['Status'];

            if($status!=1){
                continue;
            }
            foreach ($ProductsAndPrices as $key2 => $value2){
                $ID = explode(":",$value2)[0];

                if($value['ID']==$ID){
                    $gecerli=false;
                }else{


                }

            }










            if($value && $gecerli){
                $image=$value['Image'];
                $sendimage="'".$image."'";
                $image2=$value['Image'];
                $sendimage2="'".$image2."'";
                $image3=$value['Image'];
                $sendimage3="'".$image3."'";

                $ID= $value['ID'];
                $Pname =$value['PName'];
                $Pname="'".$Pname."'";
                $DescProduct =$value['DescProduct'];
                $DescProduct="'".$DescProduct."'";

                $result = $result. '
                
                  <img data-dismiss="modal" 
                  data-toggle="modal" 
                  data-target="#addProduct"  
                  class="col-md-4"  
               
                 
                  onclick="openModalAddProduct('.$ID.','.$Pname.','.$DescProduct.','.$sendimage.','.$sendimage2.','.$sendimage3.')" 
              
               
                  src="'.$image.'">

                ';

            }


        }


        $this->sendData['modalProductImages'] = $result ."</div>";

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