<?php

namespace Heln\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class HistogramTrait2Test extends TestCase
{
    /**
     * Testing method for getting minimum value of dice.
     */
    public function testGettingMinValueOfDice()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Heln\Dice\DiceHistogram2", $dice);

        $res = $dice->getHistogramMin();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing method for histogram serie.
     */
    public function testGettingHistogramSerie()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Heln\Dice\DiceHistogram2", $dice);

        $res = $dice->getHistogramSerie();
        $this->assertIsArray($res);
    }
}
