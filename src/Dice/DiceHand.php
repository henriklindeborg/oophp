<?php

namespace Heln\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class DiceHand extends Dice
{
    /**
     * @var int $values   The values of the rolls.
     */
    protected $values = 0;

    /**
     * Reset values.
     *
     */
    public function resetPoints()
    {
        $this->values = 0;
    }

    /**
     * Add the current points to values.
     *
     */
    public function addPoints($sum)
    {
        if ($sum > 0) {
            $this->values += $sum;
        } else {
            $this->resetPoints();
        }
    }

    /**
     * Get the sum of values.
     *
     * @return int
     */
    public function sumRound()
    {
        return $this->values;
    }
}
