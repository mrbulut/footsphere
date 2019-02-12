<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 06.02.2019
 * Time: 10:24
 */
namespace log;

require_once('abstract/FileLogger.php');
include_once ROOT_PATH."/src/entities/abstract/Container.php";
/*
include_once ROOT_PATH."/src/core/crosscuttingconcerns/log/Logger.php";
$ad = new Logger(new FileLogger());
$ad->Log("hello",FileLogger::WARNING) ;
 */
class Logger
{
    private $ILogger;

    public function __construct(ILogger $ILogger)
    {
        $this->ILogger = $ILogger;
    }

    public function Log($message,$type){
        $this->ILogger->Log($message,$type);
    }


}