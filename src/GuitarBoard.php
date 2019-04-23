<?php

namespace Scale;

class GuitarBoard
{
    /**
     * @var array
     */
    private $tuning = [];
    /**
     * @var Scalor
     */
    private $scalor;
    /**
     * @var int
     */
    private $boardLength;
    /**
     * @var array
     */
    private $notes = [];

    public function __construct(Scalor $scalor, array $tuning = ['e', 'b', 'g', 'd', 'a', 'e'], $boardLength = 24)
    {
        $this->scalor = $scalor;
        $this->boardLength = $boardLength;
        $this->changeTuning($tuning);
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return array
     */
    public function getTuning()
    {
        return $this->tuning;
    }

    /**
     * @param array $tuning
     * @return $this
     */
    public function changeTuning(array $tuning)
    {
        $this->tuning = $tuning;
        $this->notes = [];
        foreach ($this->tuning as $stringPosition => $stringNote) {
            $notes = $this->scalor->getChromaticNotesFromKey($stringNote);
            $notePosition = 0;
            for ($i = 0; $i <= $this->boardLength; ++$i) {
                $this->notes[$stringPosition][$i] = $notes[$notePosition];
                if (++$notePosition >= count($notes)) {
                    $notePosition = 0;
                }
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @param array $intervals
     * @return array
     */
    public function filterFingerBoards($key, array $intervals)
    {
        $scale = array_flip($this->scalor->filterNotes($key, $intervals));

        $result = [];
        foreach ($this->notes as $stringPosition => $notes) {
            foreach ($notes as $position => $names) {
                foreach ($names as $name) {
                    if (array_key_exists($name, $scale)) {
                        $result[$stringPosition][] = [
                            'position' => $position,
                            'interval' => (string)$scale[$name],
                            'note' => $name,
                        ];
                        break;
                    }
                }
            }
        }
        return $result;
    }
}
