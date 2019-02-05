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

    public function addRequest(Request $request)
    {
        if ($request) {
            return $this->insert(
                array(
                    self::$Rows[1] => $request->UserId,
                    self::$Rows[2] => $request->ProducerNo,
                    self::$Rows[3] => $request->RequestNo,
                    self::$Rows[4] => $request->ProductsAndPrices,
                    self::$Rows[5] => $request->Status,
                    self::$Rows[6] => $request->Type
                )
            );
        } else
            return false;
    }

    public function getTheRequestStatusToId($Id)
    {
        if ($Id) {
            return $this->select(
                array(
                    self::$Rows[0] => $Id
                )
            );
        } else
            return false;
    }

    public function setTheRequestStatusToId($Id, $Status)
    {
        if ($Id) {
            return $this->update(
                array(
                    self::$Rows[0] => $Id,
                )
                ,
                array(
                    self::$Rows[5] => $Status
                )
            );
        } else
            return false;
    }


    public function getTheRequestStatusToRequestId($RequestId)
    {
        if ($RequestId) {
            return $this->select(
                array(
                    self::$Rows[3] => $RequestId
                )
            );
        } else
            return false;
    }

    public function getTheRequestStatusToProducerId($ProducerNo)
    {
        if ($ProducerNo) {
            return $this->select(
                array(
                    self::$Rows[2] => $ProducerNo
                )
            );
        } else
            return false;
    }


    public function setTheRequestStatusToRequestId($RequestId, $Status)
    {
        if ($RequestId) {
            return $this->update(
                array(
                    self::$Rows[3] => $RequestId
                ),
                array(
                    self::$Rows[5] => $Status
                )
            );
        } else
            return false;
    }


    public function getAllRequestsToContinue()
    {
        return $this->selectAll(
            array(
                self::$Rows[5] => 'DevamEdiyor'
            )
        );
    }

    public function getAllRequests()
    {
        return $this->selectAll();
    }

    public function getTheRequestStatusToUserIdAndProducerIdAndRequestId($UserId = null, $ProducerNo = null, $RequestId = null)
    {

        if ($RequestId)
            $this->where(array(self::$Rows[3] => $RequestId));

        if ($UserId && $ProducerNo) {
            return $this->select(
                array(
                    self::$Rows[1] => $UserId,
                    self::$Rows[2] => $ProducerNo
                )
            );
        } else
            return false;
    }

    public function deleteRequest($Id)
    {
        if ($Id) {
            return $this->delete(
                array(
                    self::$Rows[0] => $Id
                )
            );
        } else
            return false;
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

            $ârray['$all'] = count($all);
            $ârray['$pass'] = count($pass);
            $ârray['$refuse'] = count($refuse);

        }

        if ($ârray)
            return $ârray;
        else
            return null;
    }


}