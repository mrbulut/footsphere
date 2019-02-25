<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 12.02.2019
 * Time: 09:54
 */


include_once ROOT_PATH . "/src/bussines/abstract/ICustomerService.php";
include_once ROOT_PATH . "/src/data/concrete/CustomerDal.php";
include_once ROOT_PATH . "/src/data/concrete/OptionsDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/CustomerConcrete.php";
include_once ROOT_PATH . "/src/bussines/abstract/ICustomerService.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";
include_once ROOT_PATH . "/src/bussines/abstract/IManager.php";

class CustomerManager implements ICustomerService,IManager
{

    private $Logger;
    private $CustomerDal;
    private $OptionsDal;
    private $UserDal;
    private $UserId;
    private $Customer;
    private $CustomerWhere;
    private $CustomerObjectData;

    public function __construct($UserID = null)
    {
        $this->CustomerDal = new CustomerDal();
        $this->UserDal = new UserDal($UserID);
        $this->Logger = new Logger(new FileLogger());
        $this->UserId = $this->UserDal->getUser()->getID();
        $this->Customer = new Customer();
        $this->CustomerWhere = new Customer();
        $this->Customer->setUserId($this->UserDal->getUserId());
        $this->CustomerObjectData = self::getCustomerList($this->Customer);

    }

    function getCustomerList(Customer $customer)
    {
        $this->CustomerDal->settingQuery(null, $customer);
        try {
            if ($customer) {
                $result = $this->CustomerDal->getToObject();
                if ($result) {
                    $this->Logger->Log("Müşteri verileri getirildi".get_class($this)."_".__FUNCTION__.get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Müşteri verileri getiremedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı:" . $exp.get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    // return isd
    function addCustomer(Customer $customer)
    {
        $this->CustomerDal->settingQuery($customer);
        try {
            if (!self::getCustomerList($customer)) {
                $result = $this->CustomerDal->insertToObject();
                if ($result) {
                    $this->Logger->Log("Müşteri Oluşturuldu.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Müşteri Oluşturulamadı.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }

        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }

    }

    function updateCustomer(Customer $customer, Customer $customerWhere)
    {
        $this->CustomerDal->settingQuery($customer, $customerWhere);
        try {
            if ($customer) {
                $result = $this->CustomerDal->updateToObject();
                if ($result) {
                    $this->Logger->Log("Müşteri Güncellendi..".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Müşteri Güncellenemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function deleteCustomer(Customer $customer)
    {
        $this->CustomerDal->settingQuery(null, $customer);
        try {
            if ($customer) {
                $result = $this->CustomerDal->deleteToObject();
                if ($result) {
                    $this->Logger->Log("Müşteri Silindi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                    return $result;
                } else {
                    $this->Logger->Log("Müşteri Silinemedi.".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                    return false;
                }
            }
            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function getRole()
    {
        try {

            $result = $this->UserDal->getUser()->getUserRole();
            if ($result) {
                $this->Logger->Log("Rol Çekildi Silindi.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                return $result;
            } else {
                $this->Logger->Log("Rol Çekilemedi..".get_class($this)."_".__FUNCTION__, FileLogger::ERROR);
                return false;
            }

            ///
        } catch (\Exception $exp) {
            $this->Logger->Log("Sorgu çalıştırılamadı.".get_class($this)."_".__FUNCTION__, FileLogger::FATAL);
        }
    }

    function getExtraFile()
    {
        return $this->CustomerObjectData[0]['ExtraFilePath'];
    }

    function updateExtraFile($filePath)
    {

        $this->Customer->ResetObject();
        $this->CustomerWhere->ResetObject();

        $this->CustomerWhere->setUserId($this->UserId);

        $ExtraFileArray = self::getExtraFile() . $filePath . "+-+";
        $this->Customer->setExtraFilePath($ExtraFileArray);

        self::updateCustomer($this->Customer, $this->CustomerWhere);
    }

    function deleteExtraFile($filePath)
    {

        $this->Customer->ResetObject();
        $this->CustomerWhere->ResetObject();

        $this->CustomerWhere->setUserId($this->UserId);
        $ExtraFileArray = explode("+-+", self::getExtraFile());
        $result = ' ';
        foreach ($ExtraFileArray as $key => $value) {

            if ($value!=$filePath && $value != ''){
                $result = $result . $value . "+-+";
            }


        }
        $this->Customer->setExtraFilePath($result);
        self::updateCustomer($this->Customer, $this->CustomerWhere);

        // TODO: Implement deleteExtraFile() method.
    }

    function getProducts($UserId)
    {
        $this->Customer->ResetObject();
        $this->Customer->setUserId($UserId);
        return self::getCustomerList($this->Customer)[0]['CanUseProducts'];
    }

    function updateProduct($array = array())
    {
        $this->Customer->ResetObject();
        $this->CustomerWhere->ResetObject();
        $this->CustomerWhere->setUserId($this->UserId);
        $result = '';
        foreach ($array as $key => $value) {
            if ($value != '')
                $result = $result . $value . ",";
        }

        $ProductArray = self::getProducts($this->UserId) . $result;
        $this->Customer->setCanUseProducts($ProductArray);
        self::updateCustomer($this->Customer, $this->CustomerWhere);
    }

    function deleteProduct($array = array())
    {
        $this->Customer->ResetObject();
        $this->CustomerWhere->ResetObject();
        $this->CustomerWhere->setUserId($this->UserId);
        $result = '';


        $ExtraFileArray = explode(",", self::getProducts($this->UserId));


        foreach ($ExtraFileArray as $keyEx => $ValEx) {

            $isThere = false;
            foreach ($array as $key => $value) {
                if ($value == $ValEx)
                    $isThere = true;
            }
            if (!$isThere && $ValEx != '') {
                $result = $result . $ValEx . ",";
            }
        }


        $this->Customer->setCanUseProducts($result);


        self::updateCustomer($this->Customer, $this->CustomerWhere);
    }

    function getLanguages()
    {
        return $this->CustomerObjectData['Language'];
    }

    function setLanguages($lang = null)
    {
        $this->Customer->ResetObject();
        $this->CustomerWhere->ResetObject();
        $this->CustomerWhere->setUserId($this->UserId);
        $this->Customer->setLanguage($lang);
        self::updateCustomer($this->Customer, $this->CustomerWhere);
    }

    public function getProductWaitingCustomers()
    {
        return $this->CustomerDal->getProductWaitingCustomers();
    }

    public function getProductNoCompleteCustomers()
    {
        return $this->CustomerDal->getProductNoCompleteCustomers();

    }

    public function getProductCompleteCustomers()
    {
        return $this->CustomerDal->getProductCompleteCustomers();

    }

    public function getProductFixCustomers()
    {
        return $this->CustomerDal->getProductFixCustomers();

    }

    public function setCustomerStatus($UserId, $Status)
    {
        return $this->CustomerDal->setCustomerStatus($UserId, $Status);

    }

    function setCustomerStatusAutomatic()
    {
        $this->CustomerWhere->ResetObject();
        $this->CustomerWhere->setUserId($this->UserId);
        $result = self::getCustomerList($this->CustomerWhere);

        if ($result[0]['BespokeStatus'] == "NoComplete") {
            $statusChange = true;
            foreach ($result[0] as $index => $in) {
                if (
                    $index == "Length" ||
                    $index == "Weight" ||
                    $index == "Age" ||
                    $index == "FootImage" ||
                    $index == "FootImage2" ||
                    $index == "FootImage3"

                ) {
                    if ($in == '') {
                        $statusChange = false;
                    }
                }

            }

            if ($statusChange) {
                $this->Logger->Log("Müşteri durumu tamamlandıya dönüştürüldü.".get_class($this)."_".__FUNCTION__, FileLogger::NOTICE);
                $this->CustomerDal->setCustomerStatus($this->UserId, "Complete");
            }
        }


    }
}


