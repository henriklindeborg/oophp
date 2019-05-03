<?php

namespace Heln\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DicePlayersTest extends TestCase
{
    /**
     * Testing method for setting players.
     */
    public function testSettingPlayers()
    {
        $dice = new DicePlayers();
        $this->assertInstanceOf("\Heln\Dice\DicePlayers", $dice);

        $dice->setPlayers();
        $res = $dice->getPlayers();
        $exp = [
            "Player" => 0,
            "Computer" => 0,
        ];
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing method for reseting players.
     */
    public function testResetPlayers()
    {
        $dice = new DicePlayers();
        $this->assertInstanceOf("\Heln\Dice\DicePlayers", $dice);

        $dice->setPlayers();
        $dice->resetPlayers();
        $res = $dice->getPlayers();
        $exp = [];
        $this->assertEquals($exp, $res);
    }

    /**
     * Testing method for adding score to player.
     */
    public function testAddScoreToPlayer()
    {
        $dice = new DicePlayers();
        $this->assertInstanceOf("\Heln\Dice\DicePlayers", $dice);

        $dice->resetPoints();
        $dice->addPoints(40);
        $dice->setPlayers();
        $dice->setScore();
        $res = $dice->getPlayers();
        $exp = [
            "Player" => 0,
            "Computer" => 40,
        ];
        $this->assertEquals($exp, $res);
    }
}
