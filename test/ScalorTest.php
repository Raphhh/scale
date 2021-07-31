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
                'intervals' => Scalor::MAIN_SCALES['dia']['M'],
                'scale' => ['c', 'd', 'e', 'f', 'g', 'a', 'b'],
            ],
            'cm dia' => [
                'key' => 'c',
                'intervals' => Scalor::MAIN_SCALES['dia']['m'],
                'scale' => ['c', 'd', 'e♭', 'f', 'g', 'a♭', 'b♭'],
            ],
            'C penta' => [
                'key' => 'c',
                'intervals' => Scalor::MAIN_SCALES['penta']['M'],
                'scale' => ['c', 'e', 'f', 'g', 'a'],
            ],
            'cm penta' => [
                'key' => 'c',
                'intervals' => Scalor::MAIN_SCALES['penta']['m'],
                'scale' => ['c', 'e♭', 'f', 'g', 'b♭'],
            ],
            'cm blues' => [
                'key' => 'c',
                'intervals' => Scalor::MAIN_SCALES['blues']['m'],
                'scale' => ['c', 'e♭', 'f', 'g♭', 'g', 'b♭'],
            ],
            'C chromatic' => [
                'key' => 'c',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                //note: we have only the descending scale
                'scale' => ['c', 'd♭', 'd', 'e♭', 'e', 'f', 'g♭', 'g', 'a♭', 'a', 'b♭', 'b'],
            ],

            'C♭ dia' => [
                'key' => 'c♭',
                'intervals' => Scalor::MAIN_SCALES['dia']['M'],
                'scale' => ['c♭', 'd♭', 'e♭', 'f♭', 'g♭', 'a♭', 'b♭'],
            ],
            'C♭ penta' => [
                'key' => 'c♭',
                'intervals' => Scalor::MAIN_SCALES['penta']['M'],
                'scale' => ['c♭', 'e♭', 'f♭', 'g♭', 'a♭'],
            ],
            'C♭ chromatic' => [
                'key' => 'c♭',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['c♭', 'd♭♭', 'd♭', 'e♭♭', 'e♭', 'f♭', 'g♭♭', 'g♭', 'a♭♭', 'a♭', 'b♭♭', 'b♭'],
            ],

            'C♯ dia' => [
                'key' => 'c♯',
                'intervals' => Scalor::MAIN_SCALES['dia']['M'],
                'scale' => ['c♯', 'd♯', 'e♯', 'f♯', 'g♯', 'a♯', 'b♯'],
            ],
            'C♯ penta' => [
                'key' => 'c♯',
                'intervals' => Scalor::MAIN_SCALES['penta']['M'],
                'scale' => ['c♯', 'e♯', 'f♯', 'g♯', 'a♯'],
            ],
            'C♯ chromatic' => [
                'key' => 'c♯',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['c♯', 'd', 'd♯', 'e', 'e♯', 'f♯', 'g', 'g♯', 'a', 'a♯', 'b', 'b♯'],
            ],

            'A dia' => [
                'key' => 'a',
                'intervals' => Scalor::MAIN_SCALES['dia']['M'],
                'scale' => ['a', 'b', 'c♯', 'd', 'e', 'f♯', 'g♯',],
            ],
            'am dia' => [
                'key' => 'a',
                'intervals' => Scalor::MAIN_SCALES['dia']['m'],
                'scale' => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
            ],
            'am penta' => [
                'key' => 'a',
                'intervals' => Scalor::MAIN_SCALES['penta']['m'],
                'scale' => ['a', 'c', 'd', 'e', 'g'],
            ],
            'A chromatic' => [
                'key' => 'a',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['a', 'b♭', 'b', 'c', 'c♯', 'd', 'e♭', 'e', 'f', 'f♯', 'g', 'g♯'],
            ],

            'a♭m dia' => [
                'key' => 'a♭',
                'intervals' => Scalor::MAIN_SCALES['dia']['m'],
                'scale' => ['a♭', 'b♭', 'c♭', 'd♭', 'e♭', 'f♭', 'g♭'],
            ],
            'a♭m penta' => [
                'key' => 'a♭',
                'intervals' => Scalor::MAIN_SCALES['penta']['m'],
                'scale' => ['a♭', 'c♭', 'd♭', 'e♭', 'g♭'],
            ],
            'A♭ chromatic' => [
                'key' => 'a♭',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['a♭', 'b♭♭', 'b♭', 'c♭', 'c', 'd♭', 'e♭♭', 'e♭', 'f♭', 'f', 'g♭', 'g'],
            ],

            'a♯m dia' => [
                'key' => 'a♯',
                'intervals' => Scalor::MAIN_SCALES['dia']['m'],
                'scale' => ['a♯', 'b♯', 'c♯', 'd♯', 'e♯', 'f♯', 'g♯'],
            ],
            'a♯m penta' => [
                'key' => 'a♯',
                'intervals' => Scalor::MAIN_SCALES['penta']['m'],
                'scale' => ['a♯', 'c♯', 'd♯', 'e♯', 'g♯'],
            ],
            'A♯ chromatic' => [
                'key' => 'a♯',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['a♯', 'b', 'b♯', 'c♯', 'c♯♯', 'd♯', 'e', 'e♯', 'f♯', 'f♯♯', 'g♯', 'g♯♯'],
            ],
        ];
    }
}
