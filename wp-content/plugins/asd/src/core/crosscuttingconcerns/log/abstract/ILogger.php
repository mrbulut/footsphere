<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 06.02.2019
 * Time: 12:10
 */

namespace log;

interface ILogger
{
     function Log($message,$type);
}