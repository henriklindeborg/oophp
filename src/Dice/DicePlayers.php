<?php

namespace Heln\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class DicePlayers extends DiceHand
{
    /**
     * @var array $values   The values of the rolls.
     */
    private $players = [];

    /**
     * Set the number of players
     *
     */
    public function setPlayers()
    {
        $this->players["Player"] = 0;
        $this->players["Computer"] = 0;
    }

    /**
     * Get the players.
     *
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Reset players.
     *
     */
    public function resetPlayers()
    {
        $this->players = [];
    }

    /**
     * Reset players.
     *
     */
    public function setScore($player = "Computer")
    {
        $this->players[$player] += $this->sumRound();
    }
}
