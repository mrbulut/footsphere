<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 12:41
 */
include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";

class Options implements IEntity
{
    public $option_id;
    public $option_name;
    public $option_value;
    public $auto_load;



    public function __construct()
    {

    }
    /**
     * @return mixed
     */
    public function getOptionId()
    {
        return $this->option_id;
    }

    /**
     * @param mixed $option_id
     */
    public function setOptionId($option_id)
    {
        $this->option_id = $option_id;
    }

    /**
     * @return mixed
     */
    public function getAutoLoad()
    {
        return $this->auto_load;
    }

    /**
     * @param mixed $auto_load
     */
    public function setAutoLoad($auto_load)
    {
        $this->auto_load = $auto_load;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->UserID;
    }

    /**
     * @param mixed $UserID
     */
    public function setUserID($UserID)
    {
        $this->UserID = $UserID;
    }

    /**
     * @return mixed
     */
    public function getOptionName()
    {
        return $this->option_name;
    }

    /**
     * @param mixed $option_name
     */
    public function setOptionName($option_name)
    {
        $this->option_name = $option_name;
    }

    /**
     * @return mixed
     */
    public function getOptionValue()
    {
        return $this->option_value;
    }

    /**
     * @param mixed $option_value
     */
    public function setOptionValue($option_value)
    {
        $this->option_value = $option_value;
    }


}