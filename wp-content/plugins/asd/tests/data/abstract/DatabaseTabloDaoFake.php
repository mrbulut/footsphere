<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.02.2019
 * Time: 13:54
 */
include_once '../../../tests/data/abstract/TestClassDal.php';
include_once '../../../tests/entities/concrete/TestClassConcrete.php';

class DatabaseTabloDaoFake extends MysqliDbFake
{
    private $IEntity = IEntity::class;

    private $Extension = 'a_fs_';

    private $database;

    private $TableName;

    private $Rows;

    private $value;

    private  $Object;

    private  $ObjectWhere;

    public function getToObject()
    {

        if ($this->ObjectWhere) {
            return self::select(
                $this->result
            );
        } else
            return false;
    }

    public function insertToObject()
    {

        if ($this->Object) {
            if (!self::getToObject($this->Object)) {
                return self::insert(
                    $this->Object
                );
            }
        } else
            return false;
    }

    public function updateToObject()
    {
        if ($this->Object) {
            if (self::getToObject($this->ObjectWhere)) {

                return self::update(
                    $this->Object,
                    $this->ObjectWhere
                );
            }
        } else
            return false;
    }

    public function deleteToObject()
    {
        if ($this->ObjectWhere) {
            if (self::getToObject($this->ObjectWhere)) {
                return self::delete(
                    $this->ObjectWhere
                );
            }
        } else
            return false;
    }



    public function CreateTable(IEntity $IEntity, $TableName = null)
    {
        $this->database = MysqliDbFake::getInstance();
        $this->IEntity = $IEntity;
        $this->_instance = $this->IEntity;

        self::createRowsAndTableName($TableName);


        if (!$this->database->tableExist($this->TableName)) {
            $id = 'ID';
            if ($this->Rows[0] == "option_id") {
                $id = "option_id";
            }
            $sql =
                "CREATE TABLE " . $this->TableName . " (
 			" . $id . " INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 			" . $this->value . ")";


            $this->database->rawQueryy($sql);
        }

        return $this->Rows;

    }



    public function settingQuery($Object = null, $Objectwhere = null)
    {
        if($Object){
            $this->Object = self::ClassConverter($Object);

        }

        if($Objectwhere){
            $this->ObjectWhere = self::ClassConverter($Objectwhere);
        }

    }





    public function createRowsAndTableName($TableName)
    {
        $i = 0;
        foreach ($this->IEntity as $key => $value) {
            $this->Rows[$i] = $key;
            $i++;
        }

        if ($TableName == null) {
            $this->TableName = $this->Extension . get_class($this->IEntity);
        } else {
            $this->TableName = $TableName;
        }

        self::createRows();

    }

    private function createRows()
    {
        //  will to begin from 1 because id  be first
        for ($i = 1; $i < count($this->Rows); $i++) {

            if ($i == (count($this->Rows) - 1)) {
                $this->value = $this->value . "" . $this->Rows[$i] . " " . "TEXT";

            } else {

                $this->value = $this->value . "" . $this->Rows[$i] . " " . "TEXT" . ",";
            }

        }
    }

    private function ClassConverter($Object)
    {
        $result = array();
        foreach ($Object as $key => $value) {
            if ($value) {
                $result[$key] = $value;
            }
        }
        return $result;
    }


    public function insert($array = array())
    {
        $id = $this->database->insert($this->TableName, $array);
        if ($id)
            return $id;
        else
            return false;
    }

    public function update($array = array(), $where = array())
    {
        self::where($where);
        $id = $this->database->update($this->TableName, $array);
        if ($id)
            return $id;
        else
            return false;
    }

    public function select($where = array())
    {
        self::where($where);
        return $this->database->getOne($this->TableName);
    }

    public function selectAll($where = array(), $howManyData = null)
    {

        self::where($where);
        return $this->database->get($this->TableName, $howManyData);
    }

    public function delete($where = array())
    {
        self::where($where);
        if ($this->database->delete($this->TableName))
            return true;
        else
            return false;

    }


    public function where($where = array(), $order = array())
    {


        if ($where) {
            foreach ($where as $key => $value) {
                $this->database->where($key, $value);

            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                $this->database->orderBy($key, $value);
            }
        }
    }





}