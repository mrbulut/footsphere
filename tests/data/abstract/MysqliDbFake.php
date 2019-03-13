<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.02.2019
 * Time: 15:20
 */

class MysqliDbFake
{
    protected static $_instance;


    public function __construct()
    {

        self::$_instance = $this;
    }


    public function where()
    {

    }

    public function orderBy()
    {

    }

    public function delete()
    {

    }

    public function getOne()
    {

    }

    public function get()
    {

    }


    public static function getInstance()
    {
        if (isset(self::$_instance)) {
            return self::$_instance;
        } else {
            return new MysqliDbFake();
        }
    }

    public function tableExist($tablename)
    {

    }

    public function rawQueryy($sql)
    {

    }


}