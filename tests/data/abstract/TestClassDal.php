<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.02.2019
 * Time: 13:58
 */

include_once "../../../tests/entities/concrete/TestClassConcrete.php";
include_once "../../../src/data/abstract/DatabaseTableDao.php";
include_once "../../../src/data/abstract/IDatabaseTableDao.php";

class TestClassDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private $Rows;

    /**
     * @return mixed
     */

    public function getRows()
    {
        return $this->Rows;
    }

    /**
     * @param mixed $Rows
     */
    public function setRows($Rows): void
    {
        $this->Rows = $Rows;
    }

    public function __construct()
    {
        echo "bua";
        $this->Rows = parent::CreateTable(new TestClassConcrete());
    }

    public function CreateTable(IEntity $IEntity, $TableName = null)
    {

    }


}