<?php
/**
 * Created by PhpStorm.
 * User: iksmtr
 * Date: 20.03.2019
 * Time: 11:01
 */

include_once ROOT_PATH . '/src/ui/app/models/ProductModel.php';
include_once ROOT_PATH . '/src/ui/app/models/UserModel.php';

class productController
{
    public static $data;
    public static $userRole;
    private  $ProductToUser;
    public  $productModel;
    private $productFeaturesArray;
    public $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel($GLOBALS['userId']);
        $this->userModel = new UserModel($GLOBALS['userId']);
        $this->ProductToUser = $this->userModel->getCustomer()[0]['CanUseProducts'];

        self::definedConsts();
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
        $productArray = explode(",",$this->ProductToUser);
        $result = '';
        if($productArray){
            foreach ($productArray as $key => $value){
                if($value)
                $result = $result .self::createProduct($value) ;
            }
        }

        self::$data['products'] = $result;
    }

    private  function createSlayt($Image0,$Image1,$Image2)
    {

        $result = '';

            $result = $result   . '
             <div class="single_product images">

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="'.$Image0.'" >
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="'.$Image1.'">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="'.$Image2.'" >
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>

        <!--/ .share-links-wrapper-->


    </div><!--/ .single_product-->
            ';



        return $result;

    }

    private function  createTitle($title){
        return '
                <h1 itemprop="name" class="offset_title">'.$title.'</h1>

        ';
    }

    private function  createPrice($price){
        return '
              <p class="product_price">'.$price.$GLOBALS['PriceSymbol'].'</p>

        ';
    }

    private function createBuyButton($Id){
        return '
        <div>
            <form class="cart" action="" method="post" enctype="multipart/form-data">

                <button type="submit" name="add-to-cart" value="'.$Id.'" class="single_add_to_cart_button button alt">'.$GLOBALS['string']['addbutton'].'</button>
            </form>

        </div>

        ';
    }

    private function createDesc($descPro){
        return '
         <div class="product_meta">

            '.$descPro.'<br>
        </div>
        ';
    }

    private function createFeatures($Product){
        $result = '';


        $result  = $result . '
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_tabanMalzemeText'].'</b></span>:'.$this->productFeaturesArray['BaseMaterial'][$Product['BaseMaterial']].' <br>
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_kapanisTuru'].'</b></span>:'.$this->productFeaturesArray['ClosureType'][$Product['ClosureType']].'<br>
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_astarMalzemesi'].'</b></span>:'.$this->productFeaturesArray['TopMeterial'][$Product['TopMeterial']].'<br>
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_ustMalzeme'].'</b></span>:'.$this->productFeaturesArray['liningMeterial'][$Product['liningMeterial']].'<br>
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_sezon'].'</b></span>:'.$this->productFeaturesArray['Season'][$Product['Season']].'<br>
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_icTabanturu'].'</b></span>:'.$this->productFeaturesArray['InsideBaseType'][$Product['InsideBaseType']].'<br>
        <span class="posted_in"><b>'. $GLOBALS['string']['backend_comp_icTabanMalzemesi'].'</b></span>:'.$this->productFeaturesArray['InsideBaseMeterial'][$Product['InsideBaseMeterial']].'<br>

        ';


        return $result;
    }

    private function createProduct($Id){


        $ID = $this->productModel->getIdOfRealProduct($Id);

        $Pro = $this->productModel->getProduct($ID);

        $price = $this->productModel->getPriceById($Id)['meta_value'];
        $Image0=$Pro['Image'];
        $Image1=$Pro['Image2'];
        $Image2=$Pro['Image3'];
        $title =$Pro['PName'];
        $descPro = $Pro['DescProduct'];


        return '
        <div class="row" >
        
         <div class="single_product images">
          
          '.self::createSlayt($Image0,$Image1,$Image2).'
          
          </div>
         
          <div class="single_product_description">
          
          '.self::createTitle($title).'
          '.self::createPrice($price).'
          '.self::createBuyButton($Id).'
          '.self::createDesc($descPro).'
          '.self::createFeatures($Pro).'

          
          </div>
          
         
        
        </div>

        
        ';
    }

    private  function definedConsts()
    {
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
                "" => $GLOBALS['string']['beklemede'],
                0=>$GLOBALS['string']['beklemede'],
                1=>$GLOBALS['string']['onaylandi'],
                2=>$GLOBALS['string']['onaylanmadi']
            )
        );
    }

}