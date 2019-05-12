<?php

namespace Heln\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHistogram2Test extends TestCase
{
    /**
     * Testing method for getting sides of dice.
     */
    public function testGettingMaxSides()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Heln\Dice\DiceHistogram2", $dice);

        $res = $dice->getHistogramMax();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing method for getting sides of dice.
     */
    public function testRoll()
    {
        $dice = new DiceHistogram2();
        $this->assertInstanceOf("\Heln\Dice\DiceHistogram2", $dice);

        $res = $dice->roll();
        $exp = 0;
        $this->assertGreaterThan($exp, $res);
    }
}
