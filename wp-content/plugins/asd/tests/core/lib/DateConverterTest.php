<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.02.2019
 * Time: 09:58
 */

include_once '../../../src/core/lib/DateConverter.php';

class DateConverterTest extends \PHPUnit\Framework\TestCase
{
    private $DateConverter;
    private $testDateBack;
    private $testDateForward;
    private $result;

    public function setUp()
    {
        $this->DateConverter = new DateConverter();
        $this->testDateBack =    "2019-02-10 21:00:00";
        $this->testDateForward = "2019-02-10 00:00:00";
        $this->result          =  "25830506.35" ;

    }

    public function tearDown()
    {
        unset($this->DateConverter);
        unset($this->testDateForward);
        unset($this->testDateBack);
        unset($this->result);

    }


    public function test_DateToMinuteMethod()
    {
        $returnData = $this->DateConverter->DateToMinute($this->testDateBack,$this->testDateForward);

        $this->assertEquals($returnData,$this->result);
    }

}