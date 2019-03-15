<?php
include_once 'IModel.php';
include_once ROOT_PATH . '/src/entities/concrete/CustomerConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/UserConcrete.php';
include_once ROOT_PATH . '/src/entities/concrete/ProducerConcrete.php';
include_once ROOT_PATH . '/src/bussines/concrete/UserManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/CustomerManager.php';
include_once ROOT_PATH . '/src/bussines/concrete/ProducerManager.php';


class UserModel implements IModel
{
    private $UserManager;
    private $CustomerManager;
    private $ProducerManager;
    private $User, $Customer, $CustomerWhere, $Producer, $ProducerWhere;
    private $UserId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param mixed $UserId
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
    }

    public function __destruct()
    {
       self::ResetObject();
    }

    public function __construct($UserId = null)
    {
        if ($UserId)
            $this->UserId = $UserId;
        else {
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $this->UserId = $current_user->ID;
            }
        }
        $this->Customer = new Customer();
        $this->CustomerWhere = new Customer();
        $this->User = new User();
        $this->Producer = new Producer();
        $this->ProducerWhere = new Producer();
        $this->User = new User();

    }

    function ResetObject() {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    // about User
    public function getRole()
    {
        self::customerSetup();


        return $this->CustomerManager->getRole();
    }

    // about User
    public function getLanguage()
    {
        self::customerSetup();

        return $this->CustomerManager->getLanguages();
    }


    public function getUser($UserId=null)
    {
        self::userSetup();
        if($UserId)
            return $this->UserManager->getUser($UserId);
        else
            return $this->UserManager->getUser($this->UserId);


    }

    // about User

    // about Customer
    public function addCustomer($array = array())
    {

        self::customerSetup();
        $this->User->ResetObject();
        $this->Customer->ResetObject();
        $this->User->setUserEmail($array['email']);
        $this->User->setUserName($array['username']);
        $this->User->setUserPass($array['password']);
        $this->User->setDisplayName($array['display_name']);
        $UserId = $this->UserManager->createUser($this->User, "subscriber");
        if ($UserId) {
            $this->Customer->setUserId($UserId);
            $this->CustomerManager->addCustomer($this->Customer);
        }
    }

    public function updateCustomer($array)
    {
        self::customerSetup();

        $this->User->ResetObject();
        $this->Customer->ResetObject();

        foreach ($array as $key => $value) {
            $this->User->ResetObject();
            $this->Customer->ResetObject();
            if ($key == "email") {
                $this->User->setUserEmail($value);
            } else if ($key == "display_name") {
                $this->User->setDisplayName($value);
            } else if ($key == "password") {
                $this->User->setUserPass($value);
            } else if ($key == "Length") {
                $this->Customer->setLength($value);
            } else if ($key == "Weight") {
                $this->Customer->setWeight($value);
            } else if ($key == "Age") {
                $this->Customer->setAge($value);
            } else if ($key == "FootSize") {
                $this->Customer->setFootSize($value);
            } else if ($key == "ExtraInfo") {
                $this->Customer->setExtraInfo($value);
            } else if ($key == "FootImage") {
                $this->Customer->setFootImage($value);
            } else if ($key == "FootImage2") {
                $this->Customer->setFootImage2($value);
            } else if ($key == "FootImage3") {
                $this->Customer->setFootImage3($value);
            } else if ($key == "FootsphereFilePath") {
                $this->Customer->setFootsphereFilePath($value);
            } else if ($key == "Status") {
                $this->Customer->setBespokeStatus($value);
            } else if ($key == "Language") {
                $this->CustomerManager->setLanguages($value);
            } else if ($key == "ExtraFilePath") {
                $this->CustomerManager->updateExtraFile($value);
            } else if ($key == "Products") {
                $this->CustomerManager->updateProduct($value);
            }

            if ($this->Customer) {
                $this->CustomerWhere->setUserId($this->UserId);
                $this->CustomerManager->updateCustomer($this->Customer, $this->CustomerWhere);
            }
            if ($this->User) {
                $this->UserManager->updateUser($this->User, $this->UserId);
            }

        }

    }

    public function deleteCustomer()
    {
        self::customerSetup();

        $result = $this->UserManager->deleteUser($this->UserId);
        if ($result) {
            $this->CustomerWhere->ResetObject();
            $this->CustomerWhere->setUserId($this->UserId);
            return $this->CustomerManager->deleteCustomer($this->CustomerWhere);
        }
    }

    public function getCustomer()
    {
        self::customerSetup();

        $resultArray = array();
        $this->CustomerWhere->ResetObject();
        $this->CustomerWhere->setUserId($this->UserId);
        $data = $this->CustomerManager->getCustomerList($this->CustomerWhere);
        foreach ($data as $key => $value) {
            $resultArray[$key] = $value;
        }
        $data = $this->UserManager->getUser($this->UserId);
        foreach ($data as $key => $value) {
            $resultArray[$key] = $value;
        }
        return $resultArray[0];
    }

    public function deleteExtraFileCustomer($filePath)
    {
        self::customerSetup();

        return $this->CustomerManager->deleteExtraFile($filePath);
    }

    public function deleteProductCustomer($array = array())
    {
        self::customerSetup();

        return $this->CustomerManager->deleteProduct($array);
    }

    public function setCustomerStatusAutomatic()
    {
        self::customerSetup();

        return $this->CustomerManager->setCustomerStatusAutomatic();
    }

    public function getWaitingCustomerForProduct()
    {
        self::customerSetup();

        return $this->CustomerManager->getProductWaitingCustomers();
    }
    // about Customer

    // about Producer
    public function getAllProducer()
    {
        self::producerSetup();

        return $this->ProducerManager->getProducerAll();
    }

    public function addProducer($array = array())
    {
        self::producerSetup();

        $Id=  $this->ProducerManager->createProducer(
            $array['username'],
            $array['email'],
            $array['password'],
            $array['OfferLimit']);

        if($Id){
            return self::updateProducer($array,$Id);
        }
    }

    public function getProducer($UserId=null)
    {
        self::producerSetup();
        if($UserId)
            return $this->ProducerManager->getProducerByUserId($UserId)[0];

        else
                return $this->ProducerManager->getProducerByUserId($this->UserId)[0];

    }

    public function updateProducer($array = array(),$Id)

    {
        self::producerSetup();

        $this->User->ResetObject();
        $this->Producer->ResetObject();

        foreach ($array as $key => $value) {
            if($value){
                $this->User->ResetObject();
                $this->Producer->ResetObject();
                if ($key == "email") {
                    $this->User->setUserEmail($value);
                } else if ($key == "display_name") {
                    $this->User->setDisplayName($value);
                } else if ($key == "password") {
                    $this->User->setUserPass($value);
                } else if ($key == "CompanyName") {
                    $this->Producer->setCompanyName($value);
                } else if ($key == "PhoneNumber") {
                    $this->Producer->setPhoneNumber($value);
                } else if ($key == "PhoneNumber2") {
                    $this->Producer->setPhoneNumber2($value);
                } else if ($key == "Address") {
                    $this->Producer->setAddress($value);
                } else if ($key == "PaymentInformantion") {
                    $this->Producer->setPaymentInformantion($value);
                } else if ($key == "CargoInformantion") {
                    $this->Producer->setCargoInformantion($value);
                } else if ($key == "OfferLimit") {
                    $this->Producer->setOfferLimit($value);
                }



                if ($this->Producer) {
                    $this->ProducerManager->updateProducerByUserId($this->Producer,$Id);
                }
                if ($this->User) {
                    $this->UserManager->updateUser($this->User, $Id);
                }
            }

        }
    }

    public function removeProducer($UserId)
    {
        self::producerSetup();

        return $this->ProducerManager->removeProducer($UserId);
    }

    public function addProductToProducer($array = array())
    {
        self::producerSetup();

        return $this->ProducerManager->addProduct($this->UserId, $array);
    }

    public function deleteProductToProducer($ProductNo = null)
    {
        self::producerSetup();

        return $this->ProducerManager->deleteProduct($this->UserId, $ProductNo);
    }
    // about Producer


    private function customerSetup()
    {
        $this->CustomerManager = new CustomerManager($this->UserId);
        $this->UserManager = new UserManager();
    }

    private function producerSetup()
    {
        $this->ProducerManager = new ProducerManager($this->UserId);
        $this->UserManager = new UserManager();

    }

    private function userSetup()
    {
        $this->UserManager = new UserManager();

    }

}