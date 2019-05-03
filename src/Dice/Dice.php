<?php

namespace Heln\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{
    /**
     * @var integer $sides  The number of sides on each dice.
     * @var integer $dices  The number of dices.
     * @var array   $lastRoll  The last rolled dices.
     */
    private $sides;
    private $dices;
    protected $lastRoll = [];


    /**
     * Access the last roll.
     *
     * @return array
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }

    /**
     * Randomize a number between 1 and 6.
     *
     * @return int
     */
    public function random()
    {
        return rand(1, $this->sides);
    }

    /**
     * Set lastRoll as random number and return it as an array.
     *
     * @return array
     */
    public function roll()
    {
        $this->lastRoll = [];
        for ($i = 0; $i < $this->dices; $i++) {
            array_push($this->lastRoll, $this->random());
        }
        return $this->lastRoll;
    }

    /**
     * Get the number of dices.
     *
     * @return int
     */
    public function dices()
    {
        return $this->dices;
    }

    /**
     * Get the number of sides on dices.
     *
     * @return int
     */
    public function sides()
    {
        return $this->sides;
    }

    /**
     * Get the sum of the dices.
     *
     * @return int
     */
    public function sum()
    {
        if (in_array(1, $this->lastRoll)) {
            return 0;
        }
        return array_sum($this->lastRoll);
    }

    /**
     * Constructor to initiate the object with dice sides.
     * Set sides to 6 as default.
     * Set dices to 2 as default
     */
    public function __construct(int $sides = 6, int $dices = 2)
    {
        $this->sides = $sides;
        $this->dices = $dices;
    }
}
