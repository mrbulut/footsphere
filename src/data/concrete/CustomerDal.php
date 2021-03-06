<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 11:40
 */
include_once ROOT_PATH . "/src/entities/concrete/CustomerConcrete.php";
include_once ROOT_PATH . "/src/entities/abstract/Container.php";
include_once ROOT_PATH . "/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH . "/src/data/abstract/IDatabaseTableDao.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";

class CustomerDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private $Rows;

    public function __construct()
    {

        $this->Rows = parent::CreateTable(Container::getInstance(new Customer()), "a_fs_Customer");

    }


    public function cleaner()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public function getProducts($UserId)
    {
        return $this->select(
            array(
                'UserId' => $UserId
            )
        )['CanUseProducts'];
    }

    public function addProductToUser($proId, $UserId)
    {
        if ($UserId) {
            $products = self::getProducts($UserId) . $proId . ",";
            return $this->update(
                array(
                    'CanUseProducts' => $products
                ),
                array(
                    'UserId' => $UserId
                )
            );
        } else {
            return false;
        }
    }

    public function setCustomerStatus($UserId, $status)
    {
        if ($UserId) {
            return $this->update(
                array(
                    'BespokeStatus' => $status
                ),
                array(
                    'UserId' => $UserId
                )
            );
        } else {
            return false;
        }

    }

    public function getProductWaitingCustomers()
    {
        return $this->selectAll(
            array(
                'BespokeStatus' => 'Waiting'
            )
        );
    }

    public function getProductNoCompoleteCustomers()
    {
        return $this->selectAll(
            array(
                'BespokeStatus' => 'NoCompolete'
            )
        );
    }

    public function getProductCompoleteCustomers()
    {
        return $this->selectAll(
            array(
                'BespokeStatus' => 'Compolete'
            )
        );
    }

    public function getProductFixCustomers()
    {
        return $this->selectAll(
            array(
                'BespokeStatus' => 'Fix'
            )
        );
    }


}