<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 06.03.2019
 * Time: 16:34
 */



class generalpage
{
    private static $below;
    private static $mid;
    private static $bottom;
    private static $result;


    public function __construct()
    {

    }
    /**
     * @return mixed
     */
    public static function getBelow()
    {
        return self::$below;
    }

    /**
     * @param mixed $below
     */
    public static function setBelow($below)
    {
        self::$below = $below;
    }

    /**
     * @return mixed
     */
    public static function getMid()
    {
        return self::$mid;
    }

    /**
     * @param mixed $mid
     */
    public static function setMid($mid)
    {
        self::$mid = $mid;
    }

    /**
     * @return mixed
     */
    public static function getBottom()
    {
        return self::$bottom;
    }

    /**
     * @param mixed $bottom
     */
    public static function setBottom($bottom)
    {
        self::$bottom = $bottom;
    }

    /**
     * @return mixed
     */
    public static function getResult()
    {
        return self::getBelow()."<br>"
            .self::getMid()."<br>"
            .self::getBottom()."<br>"
            ;
    }

    /**
     * @param mixed $result
     */
    public static function setResult($result)
    {
        self::$result = $result;
    }




}