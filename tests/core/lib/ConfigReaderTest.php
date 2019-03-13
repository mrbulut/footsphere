<?php



/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.02.2019
 * Time: 09:07
 */


include_once '../../../src/core/lib/ConfigReader.php';

class ConfigReaderTest extends \PHPUnit\Framework\TestCase
{

    /*
     * @test
     *
     */

    private $ConfigReader;
    private $TestData;
    public function setUp()
    {
        $this->ConfigReader = new ConfigReader();
        $this->TestData = "data";

    }

    public function tearDown()
    {
        unset($this->ConfigReader);
    }



    public function test_ReadMethod()
    {

        $GLOBALS['testData'] = array(
            'test' => $this->TestData);

        $returnData = $this->ConfigReader->Read('test/data','testData');

        $this->assertEquals($this->TestData,$returnData);

    }

}