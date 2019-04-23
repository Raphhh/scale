<?php

namespace Scale;

use PHPUnit\Framework\TestCase;

class GuitarBoardTest extends TestCase
{
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
