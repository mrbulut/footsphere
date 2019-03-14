<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:35
 */
include_once ROOT_PATH . "/src/data/abstract/MysqliDb.php";
include_once ROOT_PATH . "/src/data/config.php";

abstract class DatabaseTableDao extends MysqliDb
{
    /**
     * @param String $TableName
     * @param array $RowsType
     */
    private $IEntity = IEntity::class;

    private $Extension = 'a_fs_';

    private $database;

    private $TableName;

    private $Rows;

    private $value;

    private $Object;

    private $ObjectWhere;

    // Databasede ana 4 işlemi(get,insert,update,delete) yapmak için sorgu ve girdileri oluşturuyor.
    public function settingQuery($Object = null, $Objectwhere = null,
                                 $TableName = null)
    {
        if ($Object) {
            $this->Object = self::ClassConverter($Object);

        }

        if ($Objectwhere) {
            $this->ObjectWhere = self::ClassConverter($Objectwhere);
        }

        if ($TableName) {
            $this->TableName = $this->Extension . $TableName;
        }

    }

    public function getToObject()
    {

        if ($this->ObjectWhere) {

            return self::selectAll(
                $this->ObjectWhere
            );
        } else
            return false;
    }

    public function insertToObject()
    {

        if ($this->Object) {

            return self::insert(
                $this->Object
            );

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


        $this->database = MySqliDb::getInstance();
        self::createRowsAndTableName($TableName);



        if (!$this->database->tableExists($this->TableName)) {

            $id = 'ID';
            if ($this->Rows[0] == "option_id") {
                $id = "option_id";
            }
            $sql =
                "CREATE TABLE " . $this->TableName . " (
 			" . $id . " INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 			" . $this->value . ")";


            $this->database->rawQuery($sql);
        }

        return $this->Rows;
    }


    public function insert($array = array())
    {

        $id = $this->database->insertMysqliDb($this->TableName, $array);
        if ($id)
            return $id;
        else
            return false;
    }

    public function update($array = array(), $where = array())
    {
        self::where($where);
        $id = $this->database->updateMysqliDb($this->TableName, $array);
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
        if ($this->database->deleteMysqliDb($this->TableName))
            return true;
        else
            return false;

    }


    public function where($where = array(), $order = array())
    {


        if ($where) {
            foreach ($where as $key => $value) {
                $this->database->whereMysqliDb($key, $value);
            }
        }
        if ($order) {
            foreach ($order as $key => $value) {
                $this->database->orderBy($key, $value);
            }
        }
    }

    public function createRowsAndTableName($TableName)
    {

        if($TableName=="a_fs_Message"){
            include_once ROOT_PATH . "/src/entities/concrete/MessageConcrete.php";
            $this->IEntity = new Message();
        }else if($TableName=="a_fs_Product"){
            include_once ROOT_PATH . "/src/entities/concrete/ProductConcrete.php";
            $this->IEntity = new Product();
        }else if($TableName=="a_fs_Customer"){
            include_once ROOT_PATH . "/src/entities/concrete/CustomerConcrete.php";
            $this->IEntity = new Customer();
        }else if($TableName=="a_fs_Producer"){
            include_once ROOT_PATH . "/src/entities/concrete/ProducerConcrete.php";
            $this->IEntity = new Producer();
        }else if($TableName=="wp_users" || $TableName=="a_fs_Users"){
            include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";
            $this->IEntity = new User();
        }else if($TableName=="a_fs_Request"){
            include_once ROOT_PATH . "/src/entities/concrete/RequestConcrete.php";
            $this->IEntity = new Request();
        }else if($TableName=="wp_options" || $TableName=="a_fs_Options"){
            include_once ROOT_PATH . "/src/entities/concrete/OptionsConcrete.php";
            $this->IEntity = new Options();
        }

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
        if($this->Rows >1){
            for ($i = 1; $i < count($this->Rows); $i++) {

                if ($i == (count($this->Rows) - 1)) {
                    $this->value = $this->value . "" . $this->Rows[$i] . " " . "TEXT";

                } else {

                    $this->value = $this->value . "" . $this->Rows[$i] . " " . "TEXT" . ",";
                }

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


}