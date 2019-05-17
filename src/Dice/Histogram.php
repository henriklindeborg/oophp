<?php

namespace Heln\Dice;

/**
 * Generating histogram data.
 */
class Histogram extends DiceHistogram2
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $history = array_count_values($this->serie);
        $string = "";
        for ($i = $this->min; $i < $this->max; $i++) {
            if (!isset($history[$i])) {
                $history[$i] = 0;
            }
        }
        ksort($history);
        foreach ($history as $key => $item) {
            $string .= "$key: ";
            $string .= str_repeat("*", $item);
            $string .= "<br>";
        }
        return $string;
    }

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = array_merge(self::getSerie(), $object->getHistogramSerie());
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
