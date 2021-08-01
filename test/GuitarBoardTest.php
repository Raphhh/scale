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
     * @dataProvider provideTestFilterFingerBoards
     */
    public function testFilterFingerBoards($key, array $intervals, array $fingerboards)
    {
        $guitarBoard = new GuitarBoard(
            new Scalor(),
            ['e', 'b',],
            5
        );
        $this->assertSame($fingerboards, $guitarBoard->filterFingerBoards($key, $intervals));
    }

    public function provideTestFilterFingerBoards()
    {
        return [
            'c scale' => [
                'key' => 'c',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'finger_boards' => [
                    0 => [
                        [
                            'position' => 0,
                            'interval' => '3',
                            'note' => 'e',
                        ],
                        [
                            'position' => 1,
                            'interval' => '4',
                            'note' => 'f',
                        ],
                        [
                            'position' => 3,
                            'interval' => '5',
                            'note' => 'g',
                        ],
                        [
                            'position' => 5,
                            'interval' => '6',
                            'note' => 'a',
                        ],
                    ],
                    1 => [
                        [
                            'position' => 0,
                            'interval' => '7',
                            'note' => 'b',
                        ],
                        [
                            'position' => 1,
                            'interval' => 'T',
                            'note' => 'c',
                        ],
                        [
                            'position' => 3,
                            'interval' => '2',
                            'note' => 'd',
                        ],
                        [
                            'position' => 5,
                            'interval' => '3',
                            'note' => 'e',
                        ],
                    ],
                ],
            ],
        ];
    }
}
