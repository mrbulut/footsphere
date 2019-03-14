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
        $this->userModel = new UserModel();

        self::createColumns();
    }

    public function home($data = false)
    {
        if (!$data) {
            if ($this->userRole == "operationmanager") {
                $productArray = $this->userModel->getAllProducer();
                self::listing($productArray);


            }else{
                header("Location: /wp-admin/admin.php?page=footsphere&Producers&home&".$GLOBALS['userId']."-edit");

            }
        } else {
            self::showing($data);
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

            $PArray = $this->productModel->getAllProduct(array("ProducerNo" => $GLOBALS['userId']));
            foreach ($PArray as $key => $value){
                if($id==$value['ID']){
                    $cap=true;
                }
            }
            if($cap)die();

        }




        if($proces=="create"){
            self::createCreatePage($id);
        }else if ($proces=="edit" || $proces=="delete"){
            self::createEditAndDeletePage($id,$proces);
        }


        Controller::$view->view("producer/producer", $this->sendData);
    }


    private  function createEditAndDeletePage($id, $proces)
    {
        $product = $this->userModel->getProducer($id);

        if ($proces == "edit")
            $this->sendData['editButton'] = '<button type="submit" id="editProducer" name="editProducer" class="btn btn-success">' . $GLOBALS['string']['degistir'] . '</button>';
        else
            $this->sendData['editButton'] = '<button type="submit" id="deleteProducer" name="deleteProducer" class="btn btn-warning">' . $GLOBALS['string']['sil'] . '</button>';


        foreach ($product as $key => $value) {

            $this->sendData[$key] = $product[$key];

        }





    }

    private  function createCreatePage($id)
    {
        $this->sendData['editButton'] = '
            <button type="submit" id="createProducer" name="createProducer" class="btn btn-primary">'.$GLOBALS['string']['ureticiEkle'].'</button>
            ';
        $this->sendData['userId'] = $GLOBALS['userId'];

    }


    private  function prepareProducerArray($Parray)
    {
        $returnlast =" ";

        $id = $_POST['hiddenValueProductId'];
        if(isset($_POST['changeButtonClickOnayla'])){
            $this->productModel->setProductStatus($id,"1");
        }

        if(isset($_POST['changeButtonClickReddet'])){
            $this->productModel->setProductStatus($id,"2");
        }


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