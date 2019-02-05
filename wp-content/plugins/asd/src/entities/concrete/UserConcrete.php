<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 12:05
 */
include_once ROOT_PATH . "/src/entities/abstract/IEntity.php";

class User implements IEntity
{
    protected $ID;
    protected $user_pass;
    protected $user_email;
    protected $user_registered;
    protected $display_name;
    protected $user_role;
    protected $user_name;

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * User constructor.
     * @param $ID
     * @param $user_pass
     * @param $user_email
     * @param $user_registered
     * @param $display_name
     * @param $user_role
     */
    public function __construct(){
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
    public function getUserPass()
    {
        return $this->user_pass;
    }

    /**
     * @param mixed $user_pass
     */
    public function setUserPass($user_pass)
    {
        $this->user_pass = $user_pass;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * @param mixed $user_email
     */
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * @return mixed
     */
    public function getUserRegistered()
    {
        return $this->user_registered;
    }

    /**
     * @param mixed $user_registered
     */
    public function setUserRegistered($user_registered)
    {
        $this->user_registered = $user_registered;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @param mixed $display_name
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
    }

    /**
     * @return mixed
     */
    public function getUserRole()
    {
        return $this->user_role;
    }

    /**
     * @param mixed $user_role
     */
    public function setUserRole($user_role)
    {
        $this->user_role = $user_role;
    }




}