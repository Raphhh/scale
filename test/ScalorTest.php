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
            'c scale' => [
                'key' => 'c',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'scale' => ['c', 'd', 'e', 'f', 'g', 'a', 'b'],
            ],
            'c m scale' => [
                'key' => 'c',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'scale' => ['c', 'd', 'e♭', 'f', 'g', 'a♭', 'b♭'],
            ],
            'cm penta scale' => [
                'key' => 'c',
                'intervals' => ['T', '3m', '4', '5', '7'],
                'scale' => ['c', 'e♭', 'f', 'g', 'b'],
            ],
            'a scale' => [
                'key' => 'a',
                'intervals' => ['T', '2', '3', '4', '5', '6', '7'],
                'scale' => ['a', 'b', 'c♯', 'd', 'e', 'f♯', 'g♯',],
            ],
            'a m scale' => [
                'key' => 'a',
                'intervals' => ['T', '2', '3m', '4', '5', '6m', '7m'],
                'scale' => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
            ],
            'am penta scale' => [
                'key' => 'a',
                'intervals' => ['T', '3m', '4', '5', '7'],
                'scale' => ['a', 'c', 'd', 'e', 'g♯'],
            ],
        ];
    }
}
