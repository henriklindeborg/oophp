<?php

namespace Heln\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Heln\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $dice->dices();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $dice = new Dice(10);
        $this->assertInstanceOf("\Heln\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 10;
        $this->assertEquals($exp, $res);

        $res = $dice->dices();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use both arguments.
     */
    public function testCreateObjectBothArguments()
    {
        $dice = new Dice(10, 5);
        $this->assertInstanceOf("\Heln\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 10;
        $this->assertEquals($exp, $res);

        $res = $dice->dices();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }
}
