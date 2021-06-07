<?php

namespace Xnekv03\ApiNameday\Tests;

use GuzzleHttp\Exception\InvalidArgumentException;
use Xnekv03\ApiNameday\ApiNamedayClass;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertSame;

class SearchByNameTest extends BaseTest
{
    /**
     * @dataProvider invalidNameDataProvider
     * @test
     */
    public function invalidName(string $name)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->nd->searchByName($name, 'cz');
    }

    public function invalidNameDataProvider()
    {
        return [
            [''],
            [' '],
            ['x'],
            ['xx'],
            [' xx'],
            ['xx '],
        ];
    }

    /**
     * @dataProvider invalidCountryDataProvider
     * @test
     */
    public function invalidCountry(string $name, string $country)
    {
        $this->expectException(InvalidArgumentException::class);
        (new ApiNamedayClass())->searchByName($name, $country);
    }

    public function invalidCountryDataProvider()
    {
        return [
            ['Jan', 'Jan Hammer - Crockett\'s Theme'],
            ['Jan', 'https://www.youtube.com/watch?v=TRCQmNMOqUY'],
            ['Jan', ''],
            ['Jan', 'h'],
            ['Jan', ' '],
            ['Jan', '   '],
            ['Jan', 'Cry Me A River '],
        ];
    }

    /**
     * @dataProvider simpleCallDataProvider
     * @test
     */
    public function simpleCall(string $name, string $country, array $expected)
    {
        $response = $this->nd->searchByName($name, $country);

        assertArrayHasKey('calendar', $response);
        assertArrayHasKey('results', $response);
        assertSame($country, $response[ 'calendar' ]);
        assertSame(
            $expected,
            $response[ 'results' ]
        );
    }

    public function simpleCallDataProvider()
    {
        return [
            [
                'jfdshjsbfcdohsbhbfdo',
                'cz',
                [],
            ],
            [
                'Jan',
                'cz',
                [
                    [
                        'day' => 24,
                        'month' => 5,
                        'name' => 'Jana',
                    ],
                    [
                        'day' => 24,
                        'month' => 6,
                        'name' => 'Jan',
                    ],
                    [
                        'day' => 6,
                        'month' => 7,
                        'name' => 'Upálení mistra Jana Husa',
                    ],
                ],
            ],
            [
                'Zita',
                'sk',
                [
                    [
                        'day' => 2,
                        'month' => 4,
                        'name' => 'Zita',
                    ],
                ],
            ],
            [
                'John',
                'us',
                [
                    [
                        'day' => 24,
                        'month' => 6,
                        'name' => 'Hans, Giovanna, Giovanni, Ian, Ivan, Jan, Jana, Jean, Jeanette, Jeannette,'
                            . ' Johan, John, Johnnie, Johnny, Juan, Juana, Juanita, Sean, Shana, Shane, Shanna, Yancy',
                    ],
                    [
                        'day' => 11,
                        'month' => 11,
                        'name' => 'Chandler, Dallas, Jalen, Johnathan, Johnathon, '
                            . 'Jon, Jonatan, Jonathan, Jonathon, Jonte, Jorel, Jorrell, Lincoln',
                    ],
                ],
            ],
        ];
    }
}
