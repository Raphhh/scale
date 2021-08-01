<?php

namespace Scale;

use PHPUnit\Framework\TestCase;

class GuitarBoardTest extends TestCase
{
    /**
     *
     */
    public function testChangeTuning()
    {
        $guitarBoard = new GuitarBoard(
            new Scalor(),
            ['e', 'b',],
            4
        );
        $this->assertSame(
            [
                0 => [
                    0 => ['d♯♯', 'e', 'f♭'],
                    1 => ['e♯', 'f', 'g♭♭'],
                    2 => ['e♯♯', 'f♯', 'g♭'],
                    3 => ['f♯♯', 'g', 'a♭♭'],
                    4 => ['g♯', 'a♭'],
                ],
                1 => [
                    0 => ['a♯♯', 'b', 'c♭'],
                    1 => ['b♯', 'c', 'd♭♭'],
                    2 => ['b♯♯', 'c♯', 'd♭'],
                    3 => ['c♯♯', 'd', 'e♭♭'],
                    4 => ['d♯', 'e♭', 'f♭♭'],
                ],
            ],
            $guitarBoard->getNotes()
        );

        $guitarBoard->changeTuning(['e♭', 'b♭']);
        $this->assertSame(
            [
                0 => [
                    0 => ['d♯', 'e♭', 'f♭♭'],
                    1 => ['d♯♯', 'e', 'f♭'],
                    2 => ['e♯', 'f', 'g♭♭'],
                    3 => ['e♯♯', 'f♯', 'g♭'],
                    4 => ['f♯♯', 'g', 'a♭♭'],
                ],
                1 =>[
                    0 => ['a♯', 'b♭', 'c♭♭'],
                    1 => ['a♯♯', 'b', 'c♭'],
                    2 => ['b♯', 'c', 'd♭♭'],
                    3 => ['b♯♯', 'c♯', 'd♭'],
                    4 => ['c♯♯', 'd', 'e♭♭'],
                ],
            ],
            $guitarBoard->getNotes()
        );
    }

    /**
     *
     */
    public function testGetNotes()
    {
        $guitarBoard = new GuitarBoard(
            new Scalor(),
            ['e', 'b',],
            4
        );
        $this->assertSame(
            [
                0 => [
                    0 => ['d♯♯', 'e', 'f♭'],
                    1 => ['e♯', 'f', 'g♭♭'],
                    2 => ['e♯♯', 'f♯', 'g♭'],
                    3 => ['f♯♯', 'g', 'a♭♭'],
                    4 => ['g♯', 'a♭'],
                ],
                1 => [
                    0 => ['a♯♯', 'b', 'c♭'],
                    1 => ['b♯', 'c', 'd♭♭'],
                    2 => ['b♯♯', 'c♯', 'd♭'],
                    3 => ['c♯♯', 'd', 'e♭♭'],
                    4 => ['d♯', 'e♭', 'f♭♭'],
                ],
            ],
            $guitarBoard->getNotes()
        );

        $this->assertSame(
            [
                0 => [
                    0 => ['e', 'f♭'],
                    1 => ['e♯', 'f'],
                    2 => ['f♯', 'g♭'],
                    3 => ['g'],
                    4 => ['g♯', 'a♭'],
                ],
                1 => [
                    0 => ['b', 'c♭'],
                    1 => ['b♯', 'c'],
                    2 => ['c♯', 'd♭'],
                    3 => ['d'],
                    4 => ['d♯', 'e♭'],
                ],
            ],
            $guitarBoard->getNotes(true)
        );

        $this->assertSame(
            [
                0 => [
                    0 => ['d♯♯', 'e'],
                    1 => ['f', 'g♭♭'],
                    2 => ['e♯♯', 'f♯', 'g♭'],
                    3 => ['f♯♯', 'g', 'a♭♭'],
                    4 => ['g♯', 'a♭'],
                ],
                1 => [
                    0 => ['a♯♯', 'b'],
                    1 => ['c', 'd♭♭'],
                    2 => ['b♯♯', 'c♯', 'd♭'],
                    3 => ['c♯♯', 'd', 'e♭♭'],
                    4 => ['d♯', 'e♭', 'f♭♭'],
                ],
            ],
            $guitarBoard->getNotes(false, true)
        );

        $this->assertSame(
            [
                0 => [
                    0 => ['e'],
                    1 => ['f'],
                    2 => ['f♯', 'g♭'],
                    3 => ['g'],
                    4 => ['g♯', 'a♭'],
                ],
                1 => [
                    0 => ['b'],
                    1 => ['c'],
                    2 => ['c♯', 'd♭'],
                    3 => ['d'],
                    4 => ['d♯', 'e♭'],
                ],
            ],
            $guitarBoard->getNotes(true, true)
        );
    }

    /**
     * @param $key
     * @param array $intervals
     * @param array $fingerboards
     * @dataProvider provideTestGetScaledNotes
     */
    public function testGetScaledNotes(
        $key,
        array $intervals,
        array $fingerboards,
        $simplifyAccidental,
        $simplifyTemperament
    ) {
        $guitarBoard = new GuitarBoard(
            new Scalor(),
            ['e', 'b',],
            5
        );
        $this->assertSame(
            $fingerboards,
            $guitarBoard->getScaledNotes($key, $intervals, $simplifyAccidental, $simplifyTemperament)
        );
    }

    public function provideTestGetScaledNotes()
    {
        return [
            'all' => [
                'key' => 'c♭',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'finger_boards' => [
                    0 => [
                        [
                            'position' => 0,
                            'interval' => '4',
                            'note' => 'f♭',
                        ],
                        [
                            'position' => 2,
                            'interval' => '5',
                            'note' => 'g♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '6m',
                            'note' => 'a♭♭',
                        ],
                        [
                            'position' => 5,
                            'interval' => '7m',
                            'note' => 'b♭♭',
                        ],
                    ],
                    1 => [
                        [
                            'position' => 0,
                            'interval' => 'T',
                            'note' => 'c♭',
                        ],
                        [
                            'position' => 2,
                            'interval' => '2',
                            'note' => 'd♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '3m',
                            'note' => 'e♭♭',
                        ],
                        [
                            'position' => 5,
                            'interval' => '4',
                            'note' => 'f♭',
                        ],
                    ],
                ],
                'simplify_accidental' => false,
                'simplify_temperament' => false,
            ],
            'simplify_accidental' => [
                'key' => 'c♭',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'finger_boards' => [
                    0 => [
                        [
                            'position' => 0,
                            'interval' => '4',
                            'note' => 'f♭',
                        ],
                        [
                            'position' => 2,
                            'interval' => '5',
                            'note' => 'g♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '6m',
                            'note' => 'g',
                        ],
                        [
                            'position' => 5,
                            'interval' => '7m',
                            'note' => 'a',
                        ],
                    ],
                    1 => [
                        [
                            'position' => 0,
                            'interval' => 'T',
                            'note' => 'c♭',
                        ],
                        [
                            'position' => 2,
                            'interval' => '2',
                            'note' => 'd♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '3m',
                            'note' => 'd',
                        ],
                        [
                            'position' => 5,
                            'interval' => '4',
                            'note' => 'f♭',
                        ],
                    ],
                ],
                'simplify_accidental' => true,
                'simplify_temperament' => false,
            ],
            'simplify_temperament' => [
                'key' => 'c♭',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'finger_boards' => [
                    0 => [
                        [
                            'position' => 0,
                            'interval' => '4',
                            'note' => 'e',
                        ],
                        [
                            'position' => 2,
                            'interval' => '5',
                            'note' => 'g♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '6m',
                            'note' => 'a♭♭',
                        ],
                        [
                            'position' => 5,
                            'interval' => '7m',
                            'note' => 'b♭♭',
                        ],
                    ],
                    1 => [
                        [
                            'position' => 0,
                            'interval' => 'T',
                            'note' => 'b',
                        ],
                        [
                            'position' => 2,
                            'interval' => '2',
                            'note' => 'd♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '3m',
                            'note' => 'e♭♭',
                        ],
                        [
                            'position' => 5,
                            'interval' => '4',
                            'note' => 'e',
                        ],
                    ],
                ],
                'simplify_accidental' => false,
                'simplify_temperament' => true,
            ],
            'simplify_accidental' => [
                'key' => 'c♭',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'finger_boards' => [
                    0 => [
                        [
                            'position' => 0,
                            'interval' => '4',
                            'note' => 'e',
                        ],
                        [
                            'position' => 2,
                            'interval' => '5',
                            'note' => 'g♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '6m',
                            'note' => 'g',
                        ],
                        [
                            'position' => 5,
                            'interval' => '7m',
                            'note' => 'a',
                        ],
                    ],
                    1 => [
                        [
                            'position' => 0,
                            'interval' => 'T',
                            'note' => 'b',
                        ],
                        [
                            'position' => 2,
                            'interval' => '2',
                            'note' => 'd♭',
                        ],
                        [
                            'position' => 3,
                            'interval' => '3m',
                            'note' => 'd',
                        ],
                        [
                            'position' => 5,
                            'interval' => '4',
                            'note' => 'e',
                        ],
                    ],
                ],
                'simplify_accidental' => true,
                'simplify_temperament' => true,
            ],
        ];
    }
}
