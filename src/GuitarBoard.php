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

    public function __construct(Scalor $scalor, array $tuning = ['e', 'b', 'g', 'd', 'a', 'e'], $boardLength = 24)
    {
        $this->scalor = $scalor;
        $this->boardLength = $boardLength;
        $this->changeTuning($tuning);
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
    }

    /**
     * @return array
     */
    public function getNotes($simplifyAccidental = false, $simplifyTemperament = false)
    {
        $result = [];
        foreach ($this->tuning as $stringPosition => $stringNote) {
            $notes = $this->scalor->getChromaticNotesFromKey($stringNote, $simplifyAccidental, $simplifyTemperament);
            $notePosition = 0;
            for ($i = 0; $i <= $this->boardLength; ++$i) {
                $result[$stringPosition][$i] = $notes[$notePosition];
                if (++$notePosition >= count($notes)) {
                    $notePosition = 0;
                }
            }
        }
        return $result;
    }

    /**
     * @param string $key
     * @param array $intervals
     * @param bool $simplifyAccidental
     * @param bool $simplifyTemperament
     * @return array
     */
    public function getScaledNotes($key, array $intervals, $simplifyAccidental = false, $simplifyTemperament = false)
    {
        $scale = array_flip($this->scalor->filterNotes($key, $intervals, $simplifyAccidental, $simplifyTemperament));

        $result = [];
        foreach ($this->getNotes() as $stringPosition => $notes) {
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
