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


      $this->Rows[4] => $ProductsAndPrices; // urunId:Price, urunId2:Price, urunId3:Price,

  */

class RequestDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private  static $Rows;


    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Request()));
    }


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
                    self::$Rows[5] => 'Checked'
                )
            );
            $refuse = $this->select(
                array(
                    self::$Rows[2] => $ProducerNo,
                    self::$Rows[5] => 'UnChecked'
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