<?php
namespace Scale;

use InvalidArgumentException;

class Scalor
{
    const NOTES = [
        ['a', 'a'],
        ['a♯', 'b♭'],
        ['b', 'b'],
        ['c', 'c'],
        ['c♯', 'd♭'],
        ['d', 'd'],
        ['d♯', 'e♭'],
        ['e', 'e'],
        ['f', 'f'],
        ['f♯', 'g♭'],
        ['g', 'g'],
        ['g♯', 'a♭'],
    ];

    const INTERVAL_MAPPING = [
        'T' => 0,
        '2m' => 1,
        '2' => 2,
        '3m' => 3,
        '3' => 4,
        '4' => 5,
        '5m' => 6,
        '5' => 7,
        '6m' => 8,
        '6' => 9,
        '7m' => 10,
        '7' => 11,
    ];

    /**
     * @var array
     */
    private $indexedNotes;

    public function __construct() {
        $this->indexedNotes = $this->indexNotes(self::NOTES);
    }

    /**
     * @param $key
     * @param array $intervals
     * @return array
     */
    public function filterNotes($key, array $intervals) {
        $notes = $this->getChromaticNotesFromKey($key);
        $result = [];
        foreach ($intervals as $interval) {
            $isMinor = strpos($interval, 'm') === 1;
            $result[$interval] = $notes[$this->convertIntervalName($interval)][$isMinor ? 1 : 0];
        }
        return $result;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getChromaticNotesFromKey($key) {
        if (!array_key_exists($key, $this->indexedNotes)) {
            throw new InvalidArgumentException(sprintf('key not supported: %s', $key));
        }
        return $this->indexedNotes[$key];
    }

    /**
     * @param $name
     * @return int
     */
    private function convertIntervalName($name) {
        if (!array_key_exists($name, self::INTERVAL_MAPPING)) {
            throw new InvalidArgumentException(sprintf('interval not supported: %s', $name));
        }
        return self::INTERVAL_MAPPING[$name];
    }

    /**
     * @param array $notes
     * @return array
     */
    private function indexNotes(array $notes)
    {
        $result = [];
        foreach ($notes as $keys) {
            foreach ($keys as $key) {
                $result[$key] = [];
                foreach ($notes as $subnotes) {
                    if ($result[$key] || in_array($key, $subnotes, true)) {
                        $result[$key][] = $subnotes;
                    }
                }
                foreach ($notes as $subnotes) {
                    if (in_array($key, $subnotes, true)) {
                        break;
                    }
                    $result[$key][] = $subnotes;
                }
            }
        }
        return $result;
    }
}
