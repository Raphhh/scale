<?php
namespace Scale;

use PHPUnit\Framework\TestCase;

class ScalorTest extends TestCase
{
    /**
     * @param $key
     * @param array $intervals
     * @param array $scale
     * @dataProvider provideTestFilterNotes
     */
    public function testFilterNotes($key, array $intervals, array $scale)
    {
        $scalor = new Scalor();
        $this->assertSame(
            array_combine($intervals, $scale),
            $scalor->filterNotes($key, $intervals)
        );
    }

    public function provideTestFilterNotes()
    {
        return [
            'C dia' => [
                'key' => 'c',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'scale' => ['c', 'd', 'e', 'f', 'g', 'a', 'b'],
            ],
            'cm dia' => [
                'key' => 'c',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'scale' => ['c', 'd', 'e♭', 'f', 'g', 'a♭', 'b♭'],
            ],
            'cm penta' => [
                'key' => 'c',
                'intervals' => ['T', '3m', '4', '5', '7'],
                'scale' => ['c', 'e♭', 'f', 'g', 'b'],
            ],
            'C chromatic' => [
                'key' => 'c',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5m', '5', '6m', '6', '7m', '7'],
                //note: we have only the descending scale
                'scale' => ['c', 'd♭', 'd', 'e♭', 'e', 'f', 'g♭', 'g', 'a♭', 'a', 'b♭', 'b'],
            ],

            'C♭ dia' => [
                'key' => 'c♭',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'scale' => ['c♭', 'd♭', 'e♭', 'f♭', 'g♭', 'a♭', 'b♭'],
            ],

            'C♯ dia' => [
                'key' => 'c♯',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'scale' => ['c♯', 'd♯', 'e♯', 'f♯', 'g♯', 'a♯', 'b♯'],
            ],

            'A dia' => [
                'key' => 'a',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'scale' => ['a', 'b', 'c♯', 'd', 'e', 'f♯', 'g♯',],
            ],
            'am dia' => [
                'key' => 'a',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'scale' => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
            ],
            'am penta' => [
                'key' => 'a',
                'intervals' => ['T', '3m', '4', '5', '7'],
                'scale' => ['a', 'c', 'd', 'e', 'g♯'],
            ],

            'a♭m dia' => [
                'key' => 'a♭',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'scale' => ['a♭', 'b♭', 'c♭', 'd♭', 'e♭', 'f♭', 'g♭'],
            ],

            'a♯m dia' => [
                'key' => 'a♯',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'scale' => ['a♯', 'b♯', 'c♯', 'd♯', 'e♯', 'f♯', 'g♯'],
            ],
        ];
    }
}
