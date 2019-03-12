<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 06.02.2019
 * Time: 10:24
 */
//require_once('abstract/FileLoggerTest.php');
//include_once ROOT_PATH."/src/entities/abstract/Container.php";

use log\ILogger;
use log\Logger;


class LoggerTest extends \PHPUnit\Framework\TestCase
{

    private $FakeFileLogger;
    private $Mock;

    public function setUp()
    {
        $this->FakeFileLogger = Mockery::mock('log\FileLogger');
        $this->Mock = Mockery::mock(ILogger::class);
    }

    public function tearDown()
    {
        unset($this->FakeFileLogger);
        unset($this->Mock);
    }

    public function test_FileLoggerClassGiven_ThenRun()
    {

        //WHEN

        $this->Mock->allows()->Log("deneme", "WARNING")->andReturns($this->FakeFileLogger);

        //THEN

        var_dump($this->Mock->Log("deneme", "WARNING"));

    }

    public function test_openLogFileMethodTest()
    {

        $this->Mock->allows()->openLogFile()->andReturn($this->FakeFileLogger);
        var_dump($this->Mock->openLogFile());
    }


}

