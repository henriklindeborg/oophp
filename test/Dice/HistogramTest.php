<?php

namespace Heln\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class HistogramTest extends TestCase
{
    /**
     * Testing method for getting minimum value of dice.
     */
    public function testGettingMinValueOfDice()
    {
        $dice = new Histogram();
        $this->assertInstanceOf("\Heln\Dice\Histogram", $dice);

        $res = $dice->getSerie();
        $this->assertIsArray($res);
    }

    /**
     * Testing method for injecting data to member variables.
     */
    public function testInjectingData()
    {
        $dice = new Histogram();
        $this->assertInstanceOf("\Heln\Dice\Histogram", $dice);

        $dice->injectData($dice);
        $res = $dice->getSerie();
        $this->assertIsArray($res);
    }

    /**
     * Testing method for injecting data to member variables.
     */
    public function testGettingHistogramAsText()
    {
        $dice = new Histogram();
        $this->assertInstanceOf("\Heln\Dice\Histogram", $dice);

        $dice->roll();
        $dice->injectData($dice);
        $res = $dice->getAsText();
        $this->assertIsString($res);
    }


}
