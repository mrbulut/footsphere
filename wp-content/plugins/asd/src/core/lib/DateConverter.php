<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 31.01.2019
 * Time: 16:33
 */

class DateConverter
{
    public function MiliSecondToMinute($Date)
    {
        if ($Date != null) {
            $time = ceil(self::DateToMilisecond($Date) - time());
            return $time/3600;
        }
        require false;
    }

    public function MiliSecondToHour($Date)
    {
        if ($Date != null) {
            $time = ceil(self::DateToMilisecond($Date) - time());
            return $time/60;
        }
        require false;
    }

    public function DateToMilisecond($Date){
        return strtotime($Date);
    }
}
