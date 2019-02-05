<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 11:40
 */
include_once ROOT_PATH . "/src/entities/concrete/CustomerConcrete.php";
include_once ROOT_PATH."/src/entities/abstract/Container.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/abstract/IDatabaseTableDao.php";
include_once ROOT_PATH."/src/data/concrete/UserDal.php";

class CustomerDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private static $Rows;

    public function __construct($UserId = null)
    {
       $this->Rows = parent::CreateTable(Container::getInstance(new Customer()));

        if ($UserId == null)
            $this->user = new UserDal();
    }

    public function getProductWaitingCustomers(){
        return $this->selectAll(
            array(
                self::$Rows[8] => 'Waiting'
            )
        );
    }

    public function getProductNoCompoleteCustomers(){
        return $this->selectAll(
            array(
                self::$Rows[8] => 'NoCompolete'
            )
        );
    }

    public function getProductCompoleteCustomers(){
        return $this->selectAll(
            array(
                self::$Rows[8] => 'Compolete'
            )
        );
    }

    public function getProductFixCustomers(){
        return $this->selectAll(
            array(
                self::$Rows[8] => 'Fix'
            )
        );
    }


    public function getCustomerToId($id)
    {
        if ($id) {
            return $this->select(
                array(
                    'ID' => $id
                )
            );
        } else
            return false;
    }

    public function getCustomerToUserId($UserId)
    {
        if ($UserId) {
            return $this->select(
                array(
                    $this->Rows[1] => $UserId
                )
            );
        } else
            return false;
    }


    public function updateCustomer(Customer $customer)
    {
        if ($customer) {
            $result = array();
            foreach ($customer as $key => $value) {
                if ($value) {
                    $result[$key] = $value;
                }
            }

            return $this->update(
                $result,
                array(
                    $this->Rows[0] => $this->user->getUserId()
                )
            );


        } else
            return false;
    }

    public function addCustomer(Customer $customer)
    {
        if ($customer) {
            $result = array();
            foreach ($customer as $key => $value) {
                if ($value) {
                    $result[$key] = $value;
                }
            }

            if(!self::getCustomer($customer)){
                return $this->insert(
                    $result
                );

            }else{
                return false;
            }

        } else
            return false;
    }

    public function getCustomer(Customer $customer){
        if ($customer) {
            $result = array();
            foreach ($customer as $key => $value) {
                if ($value) {
                    $result[$key] = $value;
                }
            }

            return $this->select(
                $result
            );


        } else
            return false;
    }


}