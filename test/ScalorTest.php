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

    /**
     * @param $key
     * @param array $intervals
     * @param array $scale
     * @param $simplifyAccidental
     * @param $simplifyTemperament
     * @dataProvider provideTestFilterNotesWithSimplifications
     */
    public function testFilterNotesWithSimplifications(
        $key,
        array $intervals,
        array $scale,
        $simplifyAccidental,
        $simplifyTemperament
    ) {
        $scalor = new Scalor();
        $this->assertSame(
            array_combine($intervals, $scale),
            $scalor->filterNotes($key, $intervals, $simplifyAccidental, $simplifyTemperament)
        );
    }

    public function provideTestFilterNotesWithSimplifications()
    {
        return [
            'all' => [
                'key' => 'c♭',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['c♭', 'd♭♭', 'd♭', 'e♭♭', 'e♭', 'f♭', 'g♭♭', 'g♭', 'a♭♭', 'a♭', 'b♭♭', 'b♭'],
                'simplify_accidental' => false,
                'simplify_temperament' => false,
            ],
            'simplify_accidental' => [
                'key' => 'c♭',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['c♭', 'c', 'd♭', 'd', 'e♭', 'f♭', 'f', 'g♭', 'g', 'a♭', 'a', 'b♭'],
                'simplify_accidental' => true,
                'simplify_temperament' => false,
            ],
            'simplify_temperament' => [
                'key' => 'c♭',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['b', 'd♭♭', 'd♭', 'e♭♭', 'e♭', 'e', 'g♭♭', 'g♭', 'a♭♭', 'a♭', 'b♭♭', 'b♭'],
                'simplify_accidental' => false,
                'simplify_temperament' => true,
            ],
            'both' => [
                'key' => 'c♭',
                'intervals' => ['T', '2m', '2', '3m', '3', '4', '5d', '5', '6m', '6', '7m', '7'],
                'scale' => ['b', 'c', 'd♭', 'd', 'e♭', 'e', 'f', 'g♭', 'g', 'a♭', 'a', 'b♭'],
                'simplify_accidental' => true,
                'simplify_temperament' => true,
            ],
        ];
    }

    /**
     * @param $key
     * @param array $result
     * @param $simplifyAccidental
     * @param $simplifyTemperament
     * @dataProvider provideTestGetChromaticNotesFromKey
     */
    public function testGetChromaticNotesFromKey($key, array $result, $simplifyAccidental, $simplifyTemperament)
    {
        $scalor = new Scalor();
        $this->assertSame(
            $result,
            $scalor->getChromaticNotesFromKey($key, $simplifyAccidental, $simplifyTemperament)
        );
    }

    public function provideTestGetChromaticNotesFromKey()
    {
        return [
            'all' => [
                'key' => 'c',
                'result' => [
                    ['b♯', 'c', 'd♭♭'],
                    ['b♯♯', 'c♯', 'd♭'],
                    ['c♯♯', 'd', 'e♭♭'],
                    ['d♯', 'e♭', 'f♭♭'],
                    ['d♯♯', 'e', 'f♭'],
                    ['e♯', 'f', 'g♭♭'],
                    ['e♯♯', 'f♯', 'g♭'],
                    ['f♯♯', 'g', 'a♭♭'],
                    ['g♯', 'a♭'],
                    ['g♯♯', 'a', 'b♭♭'],
                    ['a♯', 'b♭', 'c♭♭'],
                    ['a♯♯', 'b', 'c♭'],
                ],
                'simplify_accidental' => false,
                'simplify_temperament' => false,
            ],
            'simplify_accidental' => [
                'key' => 'c',
                'result' => [
                    ['b♯', 'c'],
                    ['c♯', 'd♭'],
                    ['d'],
                    ['d♯', 'e♭'],
                    ['e', 'f♭'],
                    ['e♯', 'f'],
                    ['f♯', 'g♭'],
                    ['g'],
                    ['g♯', 'a♭'],
                    ['a'],
                    ['a♯', 'b♭'],
                    ['b', 'c♭'],
                ],
                'simplify_accidental' => true,
                'simplify_temperament' => false,
            ],
            'simplify_temperament' => [
                'key' => 'c',
                'result' => [
                    ['c', 'd♭♭'],
                    ['b♯♯', 'c♯', 'd♭'],
                    ['c♯♯', 'd', 'e♭♭'],
                    ['d♯', 'e♭', 'f♭♭'],
                    ['d♯♯', 'e'],
                    ['f', 'g♭♭'],
                    ['e♯♯', 'f♯', 'g♭'],
                    ['f♯♯', 'g', 'a♭♭'],
                    ['g♯', 'a♭'],
                    ['g♯♯', 'a', 'b♭♭'],
                    ['a♯', 'b♭', 'c♭♭'],
                    ['a♯♯', 'b'],
                ],
                'simplify_accidental' => false,
                'simplify_temperament' => true,
            ],
            'both' => [
                'key' => 'c',
                'result' => [
                    ['c'],
                    ['c♯', 'd♭'],
                    ['d'],
                    ['d♯', 'e♭'],
                    ['e'],
                    ['f'],
                    ['f♯', 'g♭'],
                    ['g'],
                    ['g♯', 'a♭'],
                    ['a'],
                    ['a♯', 'b♭'],
                    ['b'],
                ],
                'simplify_accidental' => true,
                'simplify_temperament' => true,
            ],
        ];
    }
}
