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

    private $productFeaturesArray;

    public function __construct()
    {
        self::fileupload_processing("image");
        self::fileupload_processing("image2");
        self::fileupload_processing("image3");
        $this->productModel = new ProductModel();
        parent::__construct();
        self::createColumns();

       $this->userRole = $_SESSION['role'];


    }




    public function home($data = false)
    {
        //$this->sendData = "gönderilen data";
       // self::listing();

        if(isset($_POST['editProduct'])){
            $this->productModel->updateProduct(
                array(
                    "PName" => $_POST['PName'],
                    "DescProduct" => $_POST['DescProduct'],
                    "Type" => $_POST['Type'],
                    "BaseMaterial" => $_POST['BaseMaterial'],
                    "ClosureType" => $_POST['ClosureType'],
                    "TopMeterial" => $_POST['TopMeterial'],
                    "liningMeterial" => $_POST['liningMeterial'],
                    "Season" => $_POST['Season'],
                    "InsideBaseType" => $_POST['InsideBaseType'],
                    "InsideBaseMeterial" => $_POST['InsideBaseMeterial'],
                    "Image" => $this->sendData['image']['filedest'],
                    "Image2" => $this->sendData['image2']['filedest'],
                    "Image3" => $this->sendData['image3']['filedest'],
                ),
                $_POST['urunId']
            );
        }

        if(isset($_POST['createProduct'])){

            $this->productModel->createProduct(
                array(
                    "PName" => $_POST['PName'],
                    "DescProduct" => $_POST['DescProduct'],
                    "Type" => $_POST['Type'],
                    "BaseMaterial" => $_POST['BaseMaterial'],
                    "ClosureType" => $_POST['ClosureType'],
                    "TopMeterial" => $_POST['TopMeterial'],
                    "liningMeterial" => $_POST['liningMeterial'],
                    "Season" => $_POST['Season'],
                    "InsideBaseType" => $_POST['InsideBaseType'],
                    "InsideBaseMeterial" => $_POST['InsideBaseMeterial'],
                    "Image" => $this->sendData['image']['filedest'],
                    "Image2" => $this->sendData['image2']['filedest'],
                    "Image3" => $this->sendData['image3']['filedest'],
                    "Status" => "Waiting",
                    "ProducerNO" => $GLOBALS['userId']

                )
            );
        }

        if(isset($_POST['deleteProduct'])){
            $this->productModel->removeProduct( $_POST['urunId']);
        }

        if ($this->userRole == "producer") {
            $productArray = $this->productModel->getAllProduct(
                array("ProducerNo" => $GLOBALS['userId'])
            );
        } else if ($this->userRole == "operationmanager") {
            $productArray = $this->productModel->getAllProduct();
        } else {
            $productArray = null;
        };



        if($productArray){
            if (!$data) {
                self::listing($productArray);

            } else {
                self::showing($data);

            }
        }

    }

    private function listing($PArray)
    {

        $result = '';
        if ($this->userRole == "producer") {
            $PArray = $this->productModel->getAllProduct(array("ProducerNo" => $GLOBALS['userId']));
        } else if ($this->userRole == "operationmanager") {
            $PArray = $this->productModel->getAllProduct();

        } else {
            $PArray = null;
        };

        if ($PArray){
            $result = self::prepareProductsArray($PArray);


            $this->sendData['products'] = $result;
            Controller::$view->view("product/productlist", $this->sendData);
        }

    }


    private  function createEditAndDeletePage($id, $proces)
    {
        $product = $this->productModel->getAllProduct(array('IdArray'=>array($id)))[0];


        if($proces=="edit")
            $this->sendData['editButton'] = '<button type="submit" id="editProduct" name="editProduct" class="btn btn-success">'.$GLOBALS['string']['degistir'].'</button>';
        else
            $this->sendData['editButton'] = '<button type="submit" id="deleteProduct" name="deleteProduct" class="btn btn-warning">'.$GLOBALS['string']['sil'].'</button>';


        foreach ($product as $key => $value){
            if($key == "Image" || $key=="Image2" ||  $key == "Image3") {
                if($value){
                    $this->sendData[$key] =
                        '  <a class="thumb"> <img src="'.$value.'"  width="25px" class="img-rounded">
                     <span><img src="' . $value .'" width="600px" height="600px"></span></a>'
                    ;
                }


            }else{
                $this->sendData[$key] = $product[$key];

            }
        }

        self::fillSelectMenus($product);







    }

    private  function createCreatePage($id)
    {
        $this->sendData['editButton'] = '
            <button type="submit" id="createProduct" name="createProduct" class="btn btn-primary">'.$GLOBALS['string']['yeniUrunEkle'].'</button>
            ';
        $this->sendData['userId'] = $GLOBALS['userId'];

        $this->sendData['Type_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['ayakkabi'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['terlik'] .'</option>';

        $this->sendData['BaseMaterial_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['kaucuk'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['PU'] .'</option>'.
            '<option value="3">'.$GLOBALS['string']['termo'] .'</option>';

        $this->sendData['ClosureType_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['gecme'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['cirtcirtli'] .'</option>'.
            '<option value="3">'.$GLOBALS['string']['bagcikli'] .'</option>';

        $this->sendData['TopMeterial_options']=
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['sunideri'] .'</option>'.
            '<option value="3">'.$GLOBALS['string']['kumas'] .'</option>';


        $this->sendData['Season_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['ilkbahar'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['yaz'] .'</option>'.
            '<option value="3">'.$GLOBALS['string']['sonbahar'] .'</option>'.
            '<option value="4">'.$GLOBALS['string']['kis'] .'</option>';

        $this->sendData['liningMeterial_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['kumas'] .'</option>';

        $this->sendData['InsideBaseType_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['sabit'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['degistirilebilir'] .'</option>';

        $this->sendData['InsideBaseMeterial_options'] =
            '<option></option>'.
            '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
            '<option value="2">'.$GLOBALS['string']['sunger'] .'</option>'.
            '<option value="3">'.$GLOBALS['string']['hafizalisunger'] .'</option>';

    }

    private function fillSelectMenus($product=null){


        if($product){
                if($product['Type']==2){
                    $result =
                        '<option value="1" >'.$GLOBALS['string']['ayakkabi'] .'</option>'.
                        '<option value="2" selected>'.$GLOBALS['string']['terlik'] .'</option>';
                }else{
                    $result=
                        '<option value="1" selected>'.$GLOBALS['string']['ayakkabi'] .'</option>'.
                        '<option value="2" >'.$GLOBALS['string']['terlik'] .'</option>';
                }
                $this->sendData['Type_options'] = $result;


                if($product['BaseMaterial']==3){
                    $BaseMaterial =
                        '<option value="1">'.$GLOBALS['string']['kaucuk'] .'</option>'.
                        '<option value="2">'.$GLOBALS['string']['PU'] .'</option>'.
                        '<option value="3" selected>'.$GLOBALS['string']['termo'] .'</option>';

                }else if($product['BaseMaterial']==2){
                    $BaseMaterial =
                        '<option value="1">'.$GLOBALS['string']['kaucuk'] .'</option>'.
                        '<option value="2" selected>'.$GLOBALS['string']['PU'] .'</option>'.
                        '<option value="3" >'.$GLOBALS['string']['termo'] .'</option>';
                }else{
                    $BaseMaterial =
                        '<option value="1" selected>'.$GLOBALS['string']['kaucuk'] .'</option>'.
                        '<option value="2">'.$GLOBALS['string']['PU'] .'</option>'.
                        '<option value="3" >'.$GLOBALS['string']['termo'] .'</option>';
                }

                 $this->sendData['BaseMaterial_options'] = $BaseMaterial;


            if($product['ClosureType']==3){
                $ClosureType =
                    '<option value="1">'.$GLOBALS['string']['gecme'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['cirtcirtli'] .'</option>'.
                    '<option value="3" selected>'.$GLOBALS['string']['bagcikli'] .'</option>';

            }else if($product['BaseMaterial']==2){
                $ClosureType =
                    '<option value="1">'.$GLOBALS['string']['gecme'] .'</option>'.
                    '<option value="2" selected>'.$GLOBALS['string']['cirtcirtli'] .'</option>'.
                    '<option value="3" >'.$GLOBALS['string']['bagcikli'] .'</option>';
            }else{
                $ClosureType =
                    '<option value="1" selected>'.$GLOBALS['string']['gecme'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['cirtcirtli'] .'</option>'.
                    '<option value="3" >'.$GLOBALS['string']['bagcikli'] .'</option>';
            }

            $this->sendData['ClosureType_options'] = $ClosureType;


            if($product['TopMeterial']==3){
                $TopMeterial =
                    '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['sunideri'] .'</option>'.
                    '<option value="3" selected>'.$GLOBALS['string']['kumas'] .'</option>';

            }else if($product['TopMeterial']==2){
                $TopMeterial =
                    '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2" selected>'.$GLOBALS['string']['sunideri'] .'</option>'.
                    '<option value="3" >'.$GLOBALS['string']['kumas'] .'</option>';
            }else{
                $TopMeterial =
                    '<option value="1" selected>'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2" >'.$GLOBALS['string']['sunideri'] .'</option>'.
                    '<option value="3" >'.$GLOBALS['string']['kumas'] .'</option>';
            }

            $this->sendData['TopMeterial_options'] = $TopMeterial;


            if($product['liningMeterial']==2){
                $liningMeterial =
                    '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2" selected>'.$GLOBALS['string']['kumas'] .'</option>';
            }else{
                $liningMeterial=
                    '<option value="1" selected>'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['kumas'] .'</option>';
            }
            $this->sendData['liningMeterial_options'] = $liningMeterial;



            if($product['Season']==4){
                $Season =
                    '<option value="1">'.$GLOBALS['string']['ilkbahar'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['yaz'] .'</option>'.
                    '<option value="3">'.$GLOBALS['string']['sonbahar'] .'</option>'.
                    '<option value="4" selected>'.$GLOBALS['string']['kis'] .'</option>';

            }else if($product['Season']==3){
                $Season =
                    '<option value="1">'.$GLOBALS['string']['ilkbahar'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['yaz'] .'</option>'.
                    '<option value="3"  selected>'.$GLOBALS['string']['sonbahar'] .'</option>'.
                    '<option value="4">'.$GLOBALS['string']['kis'] .'</option>';
            }
            else if($product['Season']==2){
                $Season =
                    '<option value="1">'.$GLOBALS['string']['ilkbahar'] .'</option>'.
                    '<option value="2" selected>'.$GLOBALS['string']['yaz'] .'</option>'.
                    '<option value="3">'.$GLOBALS['string']['sonbahar'] .'</option>'.
                    '<option value="4" >'.$GLOBALS['string']['kis'] .'</option>';
            }else{
                $Season =
                    '<option value="1" selected>'.$GLOBALS['string']['ilkbahar'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['yaz'] .'</option>'.
                    '<option value="3">'.$GLOBALS['string']['sonbahar'] .'</option>'.
                    '<option value="4" >'.$GLOBALS['string']['kis'] .'</option>';
            }

            $this->sendData['Season_options'] = $Season;




            if($product['InsideBaseType']==2){
                $InsideBaseType =
                    '<option value="1">'.$GLOBALS['string']['sabit'] .'</option>'.
                    '<option value="2" selected>'.$GLOBALS['string']['degistirilebilir'] .'</option>';
            }else{
                $InsideBaseType=
                    '<option value="1" selected>'.$GLOBALS['string']['sabit'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['degistirilebilir'] .'</option>';
            }
            $this->sendData['InsideBaseType_options'] = $InsideBaseType;



            if($product['InsideBaseMeterial']==3){
                $InsideBaseMeterial =
                    '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2">'.$GLOBALS['string']['sunger'] .'</option>'.
                    '<option value="3" selected>'.$GLOBALS['string']['kumas'] .'</option>';

            }else if($product['InsideBaseMeterial']==2){
                $InsideBaseMeterial =
                    '<option value="1">'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2" selected>'.$GLOBALS['string']['sunger'] .'</option>'.
                    '<option value="3" >'.$GLOBALS['string']['hafizalisunger'] .'</option>';
            }else{
                $InsideBaseMeterial =
                    '<option value="1" selected>'.$GLOBALS['string']['deri'] .'</option>'.
                    '<option value="2" >'.$GLOBALS['string']['sunger'] .'</option>'.
                    '<option value="3" >'.$GLOBALS['string']['hafizalisunger'] .'</option>';
            }

            $this->sendData['InsideBaseMeterial_options'] = $InsideBaseMeterial;



        }
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
            if(!$cap)die();

        }




        if($proces=="create"){
            self::createCreatePage($id);
        }else if ($proces=="edit" || $proces=="delete"){
            self::createEditAndDeletePage($id,$proces);
        }




            /*

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

            */
        Controller::$view->view("product/product", $this->sendData);
    }


    private  function prepareProductsArray($productArray)
    {
        $returnlast =" ";

        $id = $_POST['hiddenValueProductId'];
        if(isset($_POST['changeButtonClickOnayla'])){
            $this->productModel->setProductStatus($id,"1");
        }

        if(isset($_POST['changeButtonClickReddet'])){
            $this->productModel->setProductStatus($id,"2");
        }



        foreach ($productArray as $key => $value) {
            $result = null;
            $ImageArray = "";

            $ImageArray = $ImageArray
                . '  <a class="thumb"> <img src="'.$value['Image'].'"  width="25px" class="img-rounded">
                     <span><img src="' . $value['Image']. '" width="600px" height="600px"></span></a>'
                . '  <a class="thumb"> <img src="'.$value['Image'].'"  width="25px" class="img-rounded">
                     <span><img src="' . $value['Image2']. '" width="600px" height="600px"></span></a>'
                . '  <a class="thumb"> <img src="'.$value['Image'].'"  width="25px" class="img-rounded">
                     <span><img src="' . $value['Image3']. '" width="600px" height="600px"></span></a>';

            $ID = $value['ID'];
            $editButton = '<a href="/wp-admin/admin.php?page=footsphere&Products&home&'.$ID.'-edit" class="btn btn-warning"><em class="fa fa-pencil"></em></a>';
            $deleteButton = '<a href="/wp-admin/admin.php?page=footsphere&Products&home&'.$ID.'-delete" class="btn btn-danger"><em class="fa fa-trash"></em></a>';
            if($this->userRole=="operationmanager")
            {
                $changeButton = '<button type="button" onclick="hiddenValueProductId('.$ID.');" id="statusButton" name="statusButton" class="btn btn-info btn-xs" data-toggle="modal" data-target="#openStatusDialog" >'.$GLOBALS['string']['degistir'].'</button>';

                $producerNo =    $value['ProducerNO'];
                $produerColumn = ' <td align="center"><a href="/wp-admin/admin.php?page=footsphere&Producer&home&'.$producerNo.'-edit" class="btn btn-warning"><em class="fa fa-external-link"></em></a></td>'
                ;
            }

            $result =
                "<td>" . $ImageArray . "</td>".
                "<td>" . $value['PName'] . "</td>".
                "<td>" . $value['DescProduct'] . "</td>".
                "<td>" .  $this->productFeaturesArray['Type'][$value['Type']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['BaseMaterial'][$value['BaseMaterial']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['ClosureType'][$value['ClosureType']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['liningMeterial'][$value['liningMeterial']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['TopMeterial'][$value['TopMeterial']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['Season'][$value['Season']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['InsideBaseType'][$value['InsideBaseType']-1] . "</td>".
                "<td>" .  $this->productFeaturesArray['InsideBaseMeterial'][$value['InsideBaseMeterial']-1] . "</td>".
                "<td align='center'>" .  $this->productFeaturesArray['Status'][$value['Status']]."<br>".$changeButton. "</td>"
                .$produerColumn;


            $returnlast =  $returnlast . "<tr>" .$result .'
                    <td align="center">
                        '.$editButton.'
                        '.$deleteButton.'
                    .</td>  </tr> ' ;


        }
        return $returnlast;
    }

    public function fileupload_processing($id)
    {
        $uploadfiles = $_FILES[$id];

        if (is_array($uploadfiles)) {

            // foreach ($uploadfiles['name'] as $key => $value) {

            // look only for uploded files
            if ($uploadfiles['error'] == 0) {

                $filetmp = $uploadfiles['tmp_name'];

                //clean filename and extract extension
                $filename = $uploadfiles['name'];

                // get file info
                // @fixme: wp checks the file extension....
                $filetype = wp_check_filetype(basename($filename), null);
                $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));
                $filename = $filetitle . '.' . $filetype['ext'];
                $upload_dir = wp_upload_dir();

                /**
                 * Check if the filename already exist in the directory and rename the
                 * file if necessary
                 */
                $i = 0;
                while (file_exists($upload_dir['path'] . '/' . $filename)) {
                    $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
                    $i++;
                }

                $filedest = $upload_dir['path'] . '/' . $filename;

                $this->sendData[$id]['filedest'] = $filedest;
                $this->sendData[$id]['filename'] = $filename;

                /**
                 * Check write permissions
                 */
                if (!is_writeable($upload_dir['path'])) {
                    //  $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
                    return;
                }

                /**
                 * Save temporary file to uploads dir
                 */
                if (!@move_uploaded_file($filetmp, $filedest)) {
                    //  $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
                    //  continue;
                }




                $attachment = array(
                    'post_mime_type' => $filetype['type'],
                    'post_title' => $filetitle,
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment($attachment, $filedest);
                $attach_data = wp_generate_attachment_metadata($attach_id, $filedest);
                wp_update_attachment_metadata($attach_id, $attach_data);

                //        $this->filedest = $this->filedest . "-+-" . "/wp-content" . $filedest;
                //       $this->fileName = $this->fileName . "-+-" . "" . $fileName;

            }
        }
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

    private function createColumns()
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

        if($this->userRole="operationmanager"){
            $columNameTitles = $columNameTitles . "<th>" . $GLOBALS['string']['üretici'] . "</th>";
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
                "" => $GLOBALS['string']['beklemede'],
                0=>$GLOBALS['string']['beklemede'],
                1=>$GLOBALS['string']['onaylandi'],
                2=>$GLOBALS['string']['onaylanmadi']
            )
        );
    }





}