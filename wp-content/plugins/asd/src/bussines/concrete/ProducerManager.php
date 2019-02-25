<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 13.02.2019
 * Time: 13:52
 */


include_once ROOT_PATH . "/src/bussines/abstract/IProducerService.php";
include_once ROOT_PATH . "/src/data/concrete/ProducerDal.php";
include_once ROOT_PATH . "/src/data/concrete/OptionsDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/ProducerConcrete.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";

include_once ROOT_PATH . "/src/bussines/abstract/IManager.php";

class ProducerManager implements IProducerService,IManager
{

    private $Logger;
    private $ProducerDal;
    private $UserDal;
    private $UserId;
    private $Producer;
    private $ProducerWhere;
    private $ProducerObjectData;

    public function __construct($UserID = null)
    {
        $this->ProducerDal = new ProducerDal();
        $this->UserDal = new UserDal($UserID);
        $this->Logger = new Logger(new FileLogger());
        $this->UserId = $this->UserDal->getUser()->getID();
        $this->Producer = new Producer();
        $this->ProducerWhere = new Producer();
        $this->Producer->setUserId($this->UserId);
        $this->ProducerObjectData = self::getProducerList($this->Producer);

    }

    function getProducerProducts()
    {
        return $this->ProducerObjectData[0]['Products'];
    }

    function addProduct($UserId, $array = array())
    {
        $result = '';
        foreach ($array as $key => $value) {
            $result = $result . $value . ",";
        }


        $result = explode(",", self::getProducerProducts() . $result);
        $result = array_unique($result);
        $resultUnique = '';

        foreach ($result as $key => $value) {
            if ($value != '') {
                $resultUnique = $resultUnique . $value . ",";
            }
        }

        $this->Producer->ResetObject();
        $this->Producer->setProducts($resultUnique);
        $this->ProducerWhere->ResetObject();
        $this->ProducerWhere->setUserId($UserId);
        self::updateProducer($this->Producer, $this->ProducerWhere);
    }

    function deleteProduct($UserId, $ProductNo)
    {
        $this->ProducerWhere->ResetObject();
        $this->ProducerWhere->setUserId($UserId);

        $result = '';
        $products = explode(",", self::getProducerProducts());
        foreach ($products as $key => $value) {
            if ($value != $ProductNo && $value != '')
                $result = $result . $value . ",";
        }

        $this->Producer->ResetObject();
        $this->Producer->setProducts($result);
        self::updateProducer($this->Producer, $this->ProducerWhere);
    }

    function getProducerByUserId($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        $this->ProducerWhere->ResetObject();
        $this->ProducerWhere->setUserId($this->UserId);
        return self::getProducerList($this->ProducerWhere);

    }

    function getProducerAll()
    {
        return $this->ProducerDal->selectAll();
    }

    function updateProducerByUserId(Producer $producer, $UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        $this->ProducerWhere->ResetObject();
        $this->ProducerWhere->setUserId($this->UserId);
        return self::updateProducer($producer, $this->ProducerWhere);

    }

    function createProducer($Name, $Email, $Pass, $OfferLimit)
    {

        $user = new User();
        $user->setUserName($Name);
        $user->setUserEmail($Email);
        $user->setUserPass($Pass);
        $ID = $this->UserDal->createUser($user, "editor");
        $this->Producer->ResetObject();
        $this->Producer->setUserId($ID);
        $this->Producer->setOfferLimit($OfferLimit);
        return self::addProducer($this->Producer);
        //  return $this->ProducerDal->addProducer($user,$OfferLimit);
    }

    function removeProducer($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        $this->UserDal->setUserId($this->UserId);
        if ($this->UserDal->deleteUser($this->UserId)) {
            $this->ProducerWhere->ResetObject();
            $this->ProducerWhere->setUserId($this->UserId);
            return self::deleteProducer($this->ProducerWhere);
        }

    }

    private function getProducerList(Producer $producer)
    {
        $this->ProducerDal->settingQuery(null, $producer);
        try {
            if ($producer) {
                $result = $this->ProducerDal->getToObject();
                if ($result) {
                    $this->Logger->Log("üretici verileri getirildi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("üretici verileri getiremedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function addProducer(Producer $producer)
    {
        $this->ProducerDal->settingQuery($producer);
        try {
            if (!self::getProducerList($producer)) {

                    $result = $this->ProducerDal->insertToObject();
                    if ($result) {
                        $this->Logger->Log("üretici  Oluşturuldu.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                        return $result;
                    } else {
                        $this->Logger->Log("üretici  Oluşturulamadı.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                        return false;
                    }


            }
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function updateProducer(Producer $producer, Producer $producerWhere)
    {
        $this->ProducerDal->settingQuery($producer, $producerWhere);
        try {
            if ($producer) {
                $result = $this->ProducerDal->updateToObject();
                if ($result) {
                    $this->Logger->Log("üretici  Güncellendi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("üretici  Güncellenemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    private function deleteProducer(Producer $producer)
    {
        $this->ProducerDal->settingQuery(null, $producer);
        try {
            if ($producer) {
                $result = $this->ProducerDal->deleteToObject();
                if ($result) {
                    $this->Logger->Log("üretici  Silindi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("üretici  Silinmedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }
}