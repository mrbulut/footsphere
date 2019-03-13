<?php

use log\FileLogger;


/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 08.02.2019
 * Time: 16:23
 */


class FileLoggerTest extends \PHPUnit\Framework\TestCase
{
    private $mock;


    public function test_openLogFileMethodTest()
    {


        $mock = Mockery::mock(new FileLogger());

        $mock->shouldReceive('setLogFile')->once()->andReturn('asdsad');

        var_dump($mock->setLogFile());
    }


}


