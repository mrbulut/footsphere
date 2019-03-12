<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 16:33
 */

class DateConverter
{
    public function __construct()
    {

    }

    public function DateToMinute($Date,$time=null)
    {
        if(!$time){
            $time = time();
        }
        if ($Date != null) {
            $time = ceil($Date - $time);
            return $time/60;
        }
        require false;
    }

    public function DateToHour($Date)
    {
        if ($Date != null) {
            $time = ceil(self::DateToMilisecond($Date) - time());
            return $time/3600;
        }
        require false;
    }

    public function DateToMilisecond($Date){
        return strtotime($Date);
    }
}
