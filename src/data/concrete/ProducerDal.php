<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 11:10
 */
include_once ROOT_PATH . "/src/entities/concrete/ProducerConcrete.php";
include_once ROOT_PATH."/src/entities/abstract/Container.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/abstract/IDatabaseTableDao.php";

/**
 * Producer constructor.
 * @param $CompanyName
 * @param $PhoneNumber
 * @param $PhoneNumber2
 * @param $Address
 * @param $PaymentInformantion
 * @param $CargoInformantion
 * @param $OfferLimit --  x-y
 */
class ProducerDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private $Rows;


    public function __construct($UserId = null)
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Producer()),"a_fs_Producer");
    }






}