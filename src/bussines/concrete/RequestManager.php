<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 14.02.2019
 * Time: 16:55
 */


include_once ROOT_PATH . "/src/bussines/abstract/IRequestService.php";
include_once ROOT_PATH . "/src/data/concrete/RequestDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/RequestConcrete.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";
include_once ROOT_PATH . "/src/bussines/abstract/IManager.php";


class RequestManager implements IRequestService,IManager
{
    private $Logger;
    private $RequestDal;
    private $UserDal;
    private $UserId;
    private $Request;
    private $RequestWhere;
    private $RequestObjectData;

       //$ProductsAndPrices; // urunId:Price, urunId2:Price, urunId3:Price,
    // $StatusValue = array("Continue", "Accepted", "Checked", "UnChecked");
    // $TypeValue = array("Shoes", "Slipper");


    public function __construct($UserID = null)
    {
        $this->RequestDal = new RequestDal();
        $this->UserDal = new UserDal($UserID);
        $this->Logger = new Logger(new FileLogger());
        $this->UserId = $this->UserDal->getUser()->getID();
        $this->Request = new Request();
        $this->RequestWhere = new Request();
        //  $this->Request->setUserId($this->UserDal->getUserId());
        //  $this->RequestObjectData = self::getMessagesList($this->Message);
    }


    function getAllRequest()
    {
        return $this->RequestDal->selectAll();
    }

    public function createRequest($UserId, $ProducerNo, $RequestID,
                           $Products, $Type)
    {
        $this->Request->ResetObject();
        $this->Request->setUserID($UserId);
        $this->Request->setProducerNo($ProducerNo);
        $this->Request->setRequestNo($RequestID);
        $this->Request->setProductsAndPrices($Products);
        $this->Request->setType($Type);
        return self::addRequest($this->Request);


    }


    function getRequestByProducerNo($ProducerNo)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setProducerNo($ProducerNo);
        return self::getRequestList($this->RequestWhere);
        // TODO: Implement getRequestByProducerNo() method.
    }

    function getRequestById($Id)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setID($Id);
        return self::getRequestList($this->RequestWhere)[0];
    }

    function getRequestByUserId($UserId)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setUserID($UserId);
        return self::getRequestList($this->RequestWhere)[0];
    }


    function getRequestByRequestNoAndProducerNo($requestno,$ProducerNo)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setRequestNo($requestno);
        $this->RequestWhere->setProducerNo($ProducerNo);

        return self::getRequestList($this->RequestWhere);
    }

    function getRequestByUserIdAndProducerNo($UserId, $ProducerNo)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setUserID($UserId);
        $this->RequestWhere->setProducerNo($ProducerNo);
        return self::getRequestList($this->RequestWhere)[0];
    }

    function setRequestByUserId($UserId, $Status)
    {
        $this->Request->ResetObject();
        $this->Request->setStatus($Status);
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setUserID($UserId);
        return self::updateRequest($this->Request,$this->RequestWhere);
    }


    function removeRequest($RequestID)
    {
        $this->Request->ResetObject();
        $this->Request->setRequestNo($RequestID);
        return self::deleteRequest($this->Request);
    }

    function getRequestStatus($ID)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setID($ID);
        return self::getRequestList($this->RequestWhere)[0]['Status'];
    }

    function setRequestStatusByID($ID, $Status)
    {
        $this->Request->ResetObject();
        $this->Request->setStatus($Status);
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setID($ID);
        return self::updateRequest($this->Request,$this->RequestWhere);
    }

    function getRequestStatusByRequestNo($RequestNo)
    {
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setRequestNo($RequestNo);
        return self::getRequestList($this->RequestWhere)[0]['Status'];
    }

    function setRequestStatusByRequestNo($RequestNo, $Status)
    {
        $this->Request->ResetObject();
        $this->Request->setStatus($Status);
        $this->RequestWhere->ResetObject();
        $this->RequestWhere->setRequestNo($RequestNo);
        return self::updateRequest($this->Request,$this->RequestWhere);
    }

    function getProducerStatistics($ProducerNo)
    {
        return $this->RequestDal->getProducerStatistics($ProducerNo);
    }

    private function addRequest(Request $Request)
    {
        $this->RequestDal->settingQuery($Request);
        try {
            if ($Request) {
                $result = $this->RequestDal->insertToObject();
                if ($result) {
                    $this->Logger->Log("Request Oluşturuldu.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Request Oluşturulamadı.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }

        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı." . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }

    }

    private function getRequestList(Request $Request)
    {
        $this->RequestDal->settingQuery(null, $Request);
        try {
            if ($Request) {
                $result = $this->RequestDal->getToObject();
                if ($result) {
                    $this->Logger->Log("Request verileri getirildi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Request verileri getiremedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function deleteRequest(Request $Request)
    {
        $this->RequestDal->settingQuery(null, $Request);
        try {
            if ($Request) {
                $result = $this->RequestDal->deleteToObject();
                if ($result) {
                    $this->Logger->Log("Request Silindi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Request Silinemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function updateRequest(Request $Request, Request $RequestWhere)
    {
        $this->RequestDal->settingQuery($Request, $RequestWhere);
        try {
            if ($Request) {
                $result = $this->RequestDal->updateToObject();
                if ($result) {
                    $this->Logger->Log("Request Güncellendi..".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Request Güncellenemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }
}