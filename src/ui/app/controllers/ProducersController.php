<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 05.03.2019
 * Time: 11:10
 */

include_once ROOT_PATH . '/src/ui/app/models/UserModel.php';

class producersController extends Controller
{


    private static $sendData = array();

    private $userModel;


    public function __construct()
    {
        parent::__construct();

        self::createColumns();

        $this->userRole = $_SESSION['role'];
    }

    public function home($data = false)
    {
        $id = explode("-",$data)[0];

        if (!$data) {
            $this->userModel = new UserModel($id);

            if ($this->userRole == "operationmanager") {
                $productArray = $this->userModel->getAllProducer();
                self::listing($productArray);


            }else{
                header("Location: /wp-admin/admin.php?page=footsphere&Producers&home&".$GLOBALS['userId']."-edit");

            }
        } else {
            self::showing($data);
        }



        if(isset($_POST['editProducer'])){
            $this->userModel->updateProducer(
                array(
                    "UserId=" => $_POST['userId'],
                    "email" => $_POST['mail'],
                    "display_name" => $_POST['Adi'],
                    "CompanyName" => $_POST['sirketAdi'],
                    "PhoneNumber" => $_POST['tel'],
                    "PhoneNumber2" => $_POST['tel2'],
                    "Address" => $_POST['adres'],
                    "PaymentInformantion" => $_POST['odemeBilgi'],
                    "CargoInformantion" => $_POST['kargoBilgi'],
                    "OfferLimit" => $_POST['maxminBaslik']
                ),
                $_POST['userId']
            );

        }



        if(isset($_POST['deleteProducer'])){
            $this->userModel->removeProducer($_POST['userId']);
        }







        if(isset($_POST['createProducer'])){

            $this->userModel->addProducer(
                array(
                    "username" => $_POST['username'],
                    "email" => $_POST['mail'],
                    "password" => $_POST['password'],
                    "display_name" => $_POST['Adi'],
                    "CompanyName" => $_POST['sirketAdi'],
                    "PhoneNumber" => $_POST['tel'],
                    "PhoneNumber2" => $_POST['tel2'],
                    "Address" => $_POST['adres'],
                    "PaymentInformantion" => $_POST['odemeBilgi'],
                    "CargoInformantion" => $_POST['kargoBilgi'],
                    "OfferLimit" => $_POST['maxminBaslik']
                )
            );
        }

    }

    private function listing($PArray)
    {
        $result = '';


            $result = self::prepareProducerArray($PArray);
            $this->sendData['products'] = $result;
            Controller::$view->view("producer/producerlist", $this->sendData);


    }


    public function showing($data)
    {

        $data = explode("-",$data);
        $id = $data[0];
        $proces = $data[1];

        if($this->userRole=="producer"){

            $cap = false;

            if($id!=$GLOBALS['userId'] )$cap=true;

            if($proces=="create")$cap=true;

            if($cap)die();

        }

        $this->sendData['userId'] = $id;








        if($proces=="create"){
            self::createCreatePage($id);
        }else if ($proces=="edit" || $proces=="delete"){
            self::createEditAndDeletePage($id,$proces);
        }


        Controller::$view->view("producer/producer", $this->sendData);
    }


    private  function createEditAndDeletePage($id, $proces)
    {
        $this->userModel = new UserModel();
        $product = $this->userModel->getProducer($id);
        $userInfo = $this->userModel->getUser($id);

        if ($proces == "edit")
            $this->sendData['editButton'] = '<button type="submit" id="editProducer" name="editProducer" class="btn btn-success">' . $GLOBALS['string']['degistir'] . '</button>';
        else
            $this->sendData['editButton'] = '<button type="submit" id="deleteProducer" name="deleteProducer" class="btn btn-warning">' . $GLOBALS['string']['sil'] . '</button>';


        foreach ($product as $key => $value) {

            $this->sendData['Adi'] =$userInfo->getDisplayName();
            $this->sendData['mail'] =$userInfo->getUserEmail();
            $this->sendData['sirketAdi'] = $product['CompanyName'];
            $this->sendData['menu_producer_urunler']= $product['Products'];
            $this->sendData['maxminBaslik']= $product['OfferLimit'];
            $this->sendData['tel']= $product['PhoneNumber'];
            $this->sendData['tel2']= $product['PhoneNumber2'];
            $this->sendData['adres']= $product['Address'];
            $this->sendData['odemeBilgi']= $product['PaymentInformantion'];
            $this->sendData['kargoBilgi']= $product['CargoInformantion'];



            $disabled="disabled";
            if($this->userRole == "operationmanager"){
                $disabled='';
            }



            $maxmixdata =  $product['OfferLimit'];
            $maxmixhead =  $GLOBALS['string']['maxminBaslik'];


            $username =  $userInfo->getUserName();
            $unamehead=  $GLOBALS['string']['kullaniciAdi'];


            $this->sendData['maxminlayer'] = '
           <div class="form-group"><label for="maxminBaslik" class="loginFormElement">
                        '.$maxmixhead.'</label>
                    <input class="form-control" id="maxminBaslik" name="username"type="text"
                           value="'.$maxmixdata.'" '.$disabled.'>
                </div>
        ';


            $this->sendData['username'] = '
           <div class="form-group"><label for="username" class="loginFormElement">
                        '.$unamehead.'</label>
                    <input class="form-control" id="username" name="username"type="text"
                           value="'.$username.'" '.$disabled.'>
                </div>
        ';





        }







    }

    private  function createCreatePage($id)
    {
        $this->sendData['editButton'] = '
            <button type="submit" id="createProducer" name="createProducer" class="btn btn-primary">'.$GLOBALS['string']['ureticiEkle'].'</button>
            ';

        $maxmixhead =  $GLOBALS['string']['maxminBaslik'];

        $unamehead=  $GLOBALS['string']['kullaniciAdi'];


        $this->sendData['maxminlayer'] = '
           <div class="form-group"><label for="maxminBaslik" class="loginFormElement">
                        '.$maxmixhead.'</label>
                    <input class="form-control" id="maxminBaslik" name="maxminBaslik" type="text"
                           value="">
                </div>
        ';


        $this->sendData['username'] = '
           <div class="form-group"><label for="username" class="loginFormElement">
                        '.$unamehead.'</label>
                    <input class="form-control" id="username" name="username" type="text"
                           value="" >
                </div>
        ';



    }


    private  function prepareProducerArray($Parray)
    {
        $returnlast =" ";

        foreach ($Parray as $key => $value) {
            $result = null;
            $userInfo = $this->userModel->getUser($value['UserId']);
            $userEmail= $userInfo->getUserEmail();
            $userName= $userInfo->getDisplayName();



            $ID = $value['UserId'];
            $editButton = '<a href="/wp-admin/admin.php?page=footsphere&Producers&home&'.$ID.'-edit" class="btn btn-warning"><em class="fa fa-pencil"></em></a>';
            $deleteButton = '<a href="/wp-admin/admin.php?page=footsphere&Producers&home&'.$ID.'-delete" class="btn btn-danger"><em class="fa fa-trash"></em></a>';


            $result =
                "<td>" . $userName . "</td>".
                "<td>" . $userEmail . "</td>".
                "<td>" . $value['CompanyName'] . "</td>".
                "<td>" . $value['Products'] . "</td>".
                "<td>" . $value['OfferLimit'] . "</td>".
                "<td>" . $value['PhoneNumber'] . "</td>".
                "<td>" . $value['PhoneNumber2'] . "</td>".
                "<td>" . $value['Address'] . "</td>".
                "<td>" . $value['PaymentInformantion'] . "</td>".
                "<td>" . $value['CargoInformantion'] . "</td>";


            $returnlast =  $returnlast . "<tr>" .$result .'
                    <td align="center">
                        '.$editButton.'
                        '.$deleteButton.'
                    .</td>  </tr> ' ;


        }
        return $returnlast;
    }

    private function createColumns()
    {


        $columTitleNameArray = array(

            $GLOBALS['string']['Adi'],
            $GLOBALS['string']['mail'],
            $GLOBALS['string']['sirketAdi'],
            $GLOBALS['string']['menu_producer_urunler'],
            $GLOBALS['string']['maxminBaslik'],
            $GLOBALS['string']['tel'],
            $GLOBALS['string']['tel']."-2",
            $GLOBALS['string']['adres'],
            $GLOBALS['string']['odemeBilgi'],
            $GLOBALS['string']['kargoBilgi'],
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