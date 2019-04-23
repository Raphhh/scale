<?php

namespace Scale;

class BoardFactory
{
    /**
     * @var Scalor
     */
    private $scalor;

    public function __construct(Scalor $scalor = null)
    {
        $this->scalor = $scalor ?: new Scalor();
    }

    /**
     * @param array $tuning
     * @param int $boardLength
     * @return GuitarBoard
     */
    public function createGuitarBoard(array $tuning = ['e', 'b', 'g', 'd', 'a', 'e'], $boardLength = 24)
    {
        return new GuitarBoard($this->scalor, $tuning, $boardLength);
    }
}
