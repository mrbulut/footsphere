<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 01.02.2019
 * Time: 17:06
 */

include_once ROOT_PATH . "/src/entities/concrete/RequestConcrete.php";
include_once ROOT_PATH."/src/entities/abstract/Container.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH."/src/data/concrete/UserDal.php";
/*
     * $this->Rows[0] => $Id;
     * $this->Rows[1] => $UserId;
     * $this->Rows[2] => $ProducerNo;
     * $this->Rows[3] => $RequestNo;
     * $this->Rows[4] => $ProductsAndPrices; // urunId:Price, urunId2:Price, urunId3:Price,
     * $this->Rows[5] => $Status; // DevamEdiyor, KabulEdildi, Onaylandi, Reddedildi.
     * $this->Rows[6] => $Type; // ayakkabi,terlik
  */

class RequestDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private static $Rows;

    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Request()));
    }


    //DevamEdiyor, KabulEdildi, Onaylandi, Reddedildi.
    public function getProducerStatistics($ProducerNo)
    {

        if ($ProducerNo) {
            $all = $this->select(
                array(
                    self::$Rows[2] => $ProducerNo
                )
            );
            $pass = $this->select(
                array(
                    self::$Rows[2] => $ProducerNo,
                    self::$Rows[5] => 'Onaylandi'
                )
            );
            $refuse = $this->select(
                array(
                    self::$Rows[2] => $ProducerNo,
                    self::$Rows[5] => 'Reddedildi'
                )
            );

            $array['all'] = count($all);
            $array['pass'] = count($pass);
            $array['refuse'] = count($refuse);

        }

        if ($array)
            return $array;
        else
            return null;
    }


}