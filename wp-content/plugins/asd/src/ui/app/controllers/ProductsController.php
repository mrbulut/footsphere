<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 11:59
 */


include_once ROOT_PATH . '/src/ui/app/models/ProductModel.php';

class productsController extends Controller
{

    private static $sendData = array();

    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        parent::__construct();
        self::createColumns();
    }


    public function home($data = false)
    {
        //$this->sendData = "gönderilen data";
        self::listing();
        if (!$data) {
        } else {

        }
    }

    public function listing()
    {
        $result = '';
        if ($this->userRole == "producer") {
            $productArray = $this->productModel->getAllProduct();
        } else if ($this->userRole == "operationmanager") {

            $productArray = $this->productModel->getAllProduct(
                array("ProducerNo" => $GLOBALS['userId'])
            );

        } else {
            $productArray = null;
        };
        if ($productArray) {
            $result = self::prepareProductsArray($productArray);
        }

        $this->sendData['products'] = $result;
        Controller::$view->view("product/productlist", $this->sendData);
    }

    private static function prepareProductsArray($productArray)
    {
        $returnlast =" ";

        foreach ($productArray as $key => $value) {
            $result = null;
            $ImageArray = "";
            foreach ($value as $key2 => $value2) {

                if($key2=="Image2" || $key2=="Image" || $key2=="Image3"){
                    $ImageArray = $ImageArray . '  <img src="'.$value2.'" class="img-rounded">';
                }else{
                    $result = $result . "<td>" . $value2 . "</td>";

                }

            }

            $result = "<td>" . $ImageArray . "</td>" . $result;


            $returnlast =  $returnlast . "<tr>" .$result .'
                    <td align="center">
                        <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
                        <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
                    </td>  </tr> ' ;
        }
        return $returnlast;
    }

    public function showing()
    {
        Controller::$view->view("product/product", $this->sendData);
    }


    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


    public function createProduct($array)
    {
        $this->productModel->createProduct($array);
    }

    public function createColumns()
    {


        $columTitleNameArray = array(
            $GLOBALS['string']['backend_comp_urunGorsel'],
            $GLOBALS['string']['backend_comp_urunBasligiText'],
            $GLOBALS['string']['backend_comp_urunAciklamasiText'],
            $GLOBALS['string']['backend_comp_turuText'],
            $GLOBALS['string']['backend_comp_tabanMalzemeText'],
            $GLOBALS['string']['backend_comp_kapanisTuru'],
            $GLOBALS['string']['backend_comp_astarMalzemesi'],
            $GLOBALS['string']['backend_comp_ustMalzeme'],
            $GLOBALS['string']['backend_comp_sezon'],
            $GLOBALS['string']['backend_comp_icTabanturu'],
            $GLOBALS['string']['backend_comp_icTabanMalzemesi'],
            $GLOBALS['string']['durum'],

        );
        $columNameTitles = null;
        foreach ($columTitleNameArray as $key => $value) {
            $columNameTitles = $columNameTitles . "<th>" . $value . "</th>";
        }

        $this->sendData['columns'] = $columNameTitles;
    }


}