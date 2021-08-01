<?php
namespace Scale;

use InvalidArgumentException;
use OutOfRangeException;

class Scalor
{
    const NOTES = [
        ['g♯♯', 'a', 'b♭♭'],
        ['a♯', 'b♭', 'c♭♭'],
        ['a♯♯', 'b', 'c♭'],
        ['b♯', 'c', 'd♭♭'],
        ['b♯♯', 'c♯', 'd♭'],
        ['c♯♯', 'd', 'e♭♭'],
        ['d♯', 'e♭', 'f♭♭'],
        ['d♯♯', 'e', 'f♭'],
        ['e♯', 'f', 'g♭♭'],
        ['e♯♯', 'f♯', 'g♭'],
        ['f♯♯', 'g', 'a♭♭'],
        ['g♯', 'a♭'],
    ];

    /**
     * @see https://en.wikipedia.org/wiki/Interval_(music)
     * @see https://en.wikipedia.org/wiki/Chord_names_and_symbols_(popular_music)
     *
     * Warning: special notations:
     *  - m = minor
     *  - d = diminished
     *  - a = augmented
     */
    const INTERVAL_MAPPING = [
        'T' => 0,
        '2d' => 0,
        '2m' => 1,
        '2' => 2,
        '2a' => 2,
        '3d' => 2,
        '3m' => 3,
        '3' => 4,
        '3a' => 5,
        '4d' => 4,
        '4' => 5,
        '4a' => 6,
        '5d' => 6,
        '5' => 7,
        '5a' => 8,
        '6d' => 7,
        '6m' => 8,
        '6' => 9,
        '6a' => 10,
        '7d' => 9,
        '7m' => 10,
        '7' => 11,
        '7a' => 12,
    ];

    const MAIN_SCALES = [
        'dia' => [ //see https://en.wikipedia.org/wiki/Major_scale
            'M' => ['T', '2', '3', '4', '5', '6', '7'],
            'm' => ['T', '2', '3m', '4', '5', '6m', '7m'],
        ],
        'penta' => [ //see https://en.wikipedia.org/wiki/Pentatonic_scale
            'M' => ['T', '3', '4', '5', '6'],
            'm' => ['T', '3m', '4', '5', '7m'],
        ],
        'blues' => [ //see https://en.wikipedia.org/wiki/Blues_scale
            'M' => ['T', '3m', '3', '4', '5', '6', '7m', '7'],
            'm' => ['T', '3m', '4', '5d', '5', '7m'],
        ],
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
     * @param bool $simplifyAccidental
     * @param bool $simplifyTemperament
     * @return array
     */
    public function filterNotes($key, array $intervals, $simplifyAccidental = false, $simplifyTemperament = false) {
        $notes = $this->getChromaticNotesFromKey($key);
        $dia = $this->getDiaNotesFromKey($key);
        $result = [];

        foreach ($intervals as $interval) {
            $result[$interval] = $this->conformNote(
                $notes[$this->convertIntervalName($interval)],
                $dia[$this->convertIntervalToDegree($interval)],
                $simplifyAccidental,
                $simplifyTemperament
            );
        }

        return $result;
    }

    /**
     * @param $key
     * @param bool $simplifyAccidental
     * @param bool $simplifyTemperament
     * @return mixed
     */
    public function getChromaticNotesFromKey($key, $simplifyAccidental = false, $simplifyTemperament = false) {
        if (!array_key_exists($key, $this->indexedNotes)) {
            throw new InvalidArgumentException(sprintf('key not supported: %s', $key));
        }
        $result = $this->indexedNotes[$key];
        if ($simplifyAccidental) {
            foreach ($result as $index => $notes) {
                $result[$index] = $this->removeAccidentals($notes);
            }
        }
        if ($simplifyTemperament) {
            foreach ($result as $index => $notes) {
                $result[$index] = $this->removeTemperaments($notes);
            }
        }
        return $result;
    }

    /**
     * @param $key
     * @return array
     */
    private function getDiaNotesFromKey($key) {
        $key = $this->getPureNote($key);
        $notes = str_split('abcdefg');
        $result = [];
        $degree = 1;
        foreach($notes as $note) {
            if ($result || $note === $key) {
                $result[$degree++] = $note;
            }
        }
        $missing = count($notes) - count($result);
        for ($i = 0; $i < $missing; ++$i) {
            $result[$degree++] = $notes[$i];
        }
        return $result;
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

    /**
     * @param string[] $notes
     * @param string $pure
     * @param bool $simplifyAccidental
     * @param bool $simplifyTemperament
     * @return string
     */
    private function conformNote(array $notes, $pure, $simplifyAccidental, $simplifyTemperament)
    {
        foreach ($notes as $note) {
            if (strpos($note, $pure) === 0) {
                if ($simplifyAccidental) {
                    $note = $this->simplifyAccidental($note);
                }
                if ($simplifyTemperament) {
                    $note = $this->simplifyTemperament($note);
                }
                return $note;
            }
        }
        throw new OutOfRangeException('no note found from pure note ' . $pure);
    }

    /**
     * @param string $note
     * @return string
     */
    private function getPureNote($note)
    {
        return str_replace(['♯', '♭'], '', $note);
    }

    /**
     * @param string $interval
     * @return string
     */
    private function convertIntervalToDegree($interval)
    {
        if ($interval === 'T') {
            return 1;
        }
        return str_replace(['m', 'd', 'a'], '', $interval);
    }

    /**
     * @param array $notes
     * @return array
     */
    private function removeAccidentals(array $notes)
    {
        $result = [];
        foreach ($notes as $note) {
            $result[] = $this->simplifyAccidental($note);
        }
        return array_values(array_unique($result));
    }

    /**
     * @param $note
     * @return string
     */
    private function simplifyAccidental($note)
    {
        return [
                'a♯♯' => 'b',
                'a♭♭' => 'g',
                'b♯♯' => 'c♯',
                'b♭♭' => 'a',
                'c♯♯' => 'd',
                'c♭♭' => 'b♭',
                'd♯♯' => 'e',
                'd♭♭' => 'c',
                'e♯♯' => 'f♯',
                'e♭♭' => 'd',
                'f♯♯' => 'g',
                'f♭♭' => 'e♭',
                'g♯♯' => 'a',
                'g♭♭' => 'f',
            ][$note] ?? $note;
    }

    /**
     * @param array $notes
     * @return array
     */
    private function removeTemperaments(array $notes)
    {
        $result = [];
        foreach ($notes as $note) {
            $result[] = $this->simplifyTemperament($note);
        }
        return array_values(array_unique($result));
    }

    /**
     * @param $note
     * @return string
     */
    private function simplifyTemperament($note)
    {
        return [
            'b♯' => 'c',
            'c♭' => 'b',
            'e♯' => 'f',
            'f♭' => 'e',
        ][$note] ?? $note;
    }
}
