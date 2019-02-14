<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 14.02.2019
 * Time: 16:55
 */


include_once ROOT_PATH . "/src/bussines/abstract/IRequestService.php";
include_once ROOT_PATH . "/src/data/concrete/RequestDal.php";
include_once ROOT_PATH . "/src/data/concrete/UserDal.php";
include_once ROOT_PATH . "/src/entities/concrete/RequestConcrete.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/FileLogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/abstract/ILogger.php";
include_once ROOT_PATH . "/src/core/crosscuttingconcerns/log/Logger.php";

class RequestManager implements IRequestService
{

}