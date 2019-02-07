<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 07.02.2019
 * Time: 10:48
 */

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    /*
     * @test
     */
    public function test(){

        $c=25;
        $this->assertEquals($c,23);
    }
}