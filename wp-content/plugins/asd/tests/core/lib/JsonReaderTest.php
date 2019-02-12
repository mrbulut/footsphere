<?php



/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.02.2019
 * Time: 09:07
 */


include_once '../../../src/core/lib/JsonReader.php';

class ConfigReaderTest extends \PHPUnit\Framework\TestCase
{

    /*
     * @test
     *
     */

    private $JsonReader;
    private $route;
    private $result;
    public function setUp()
    {
        $this->JsonReader = new JsonReader();
        $this->route = "examp.json";
        $this->result = "data";

    }

    public function tearDown()
    {
        unset($this->JsonReader);
    }



    public function test_ReadMethod()
    {


        $data = $this->JsonReader->jsonRead($this->route)['test'];

        $this->assertEquals($data,$this->result);
    }

}