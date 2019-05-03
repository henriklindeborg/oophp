<?php

namespace Heln\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandSettingPointsTest extends TestCase
{
    /**
     * Testing method for reseting values (points).
     */
    public function testResetingPoints()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Heln\Dice\DiceHand", $dice);

        $dice->resetPoints();
        $res = $dice->sumRound();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing method for adding to values (points) > 0.
     */
    public function testAddPointsMoreThenZero()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Heln\Dice\DiceHand", $dice);

        $dice->addPoints(40);
        $res = $dice->sumRound();
        $exp = 40;
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing method for adding to values (points) <= 0.
     */
    public function testAddPointsLessThenOrZero()
    {
        $dice = new DiceHand();
        $this->assertInstanceOf("\Heln\Dice\DiceHand", $dice);

        $dice->addPoints(40);
        $dice->addPoints(0);
        $res = $dice->sumRound();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }
}
