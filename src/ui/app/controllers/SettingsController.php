<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.03.2019
 * Time: 11:59
 */

include_once ROOT_PATH . '/src/ui/app/models/OptionsModel.php';


class settingsController extends Controller
{


    private static $sendData = array();

    private $optionModel;


    public function __construct()
    {
        parent::__construct();
        $this->userRole = $_SESSION['role'];
        $this->optionModel = new OptionsModel();
    }

    public function home($data = false)
    {


        if(isset($_POST['settingsUpdate'])){
            if(isset($_POST['komisyonorani'])){
                $this->optionModel->setCommissionArea($_POST['komisyonorani']);
            }

            if(isset($_POST['ureticiteklifsiniri'])){
                $this->optionModel->setProducerRequestLimit($_POST['ureticiteklifsiniri']);
            }

            if(isset($_POST['ureticiurunlimiti'])){
                $this->optionModel->setProducerModelLimit($_POST['ureticiurunlimiti']);
            }

            if(isset($_POST['isteksuresi'])){
                $this->optionModel->setRequestTimeArea($_POST['isteksuresi']);
            }
        }

        if($this->userRole == "operationmanager"){

            $this->sendData['komisyonorani'] = $this->optionModel->getCommissionArea();
            $this->sendData['isteksuresi'] = $this->optionModel->getRequestTimeArea();
            $this->sendData['ureticiurunlimiti'] = $this->optionModel->getProducerModelLimit();
            $this->sendData['ureticiteklifsiniri'] = $this->optionModel->getProducerRequestLimit();

            Controller::$view->view("settings/settings",$this->sendData);

        }
    }

    public function existsMethods($str)
    {
        if (method_exists($this, $str))
            return true;
        else
            return false;
    }


}