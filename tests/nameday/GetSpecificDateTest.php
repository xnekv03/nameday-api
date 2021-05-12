<?php

declare(strict_types=1);

namespace Nameday;

use GuzzleHttp\Exception\InvalidArgumentException;

use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

class GetSpecificDateTest extends BaseTest
{

    /**
     * @dataProvider invalidDateDataProvider
     * @test
     */
    public function invalidDate(int $day, int $month)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->namedayInstance->specificDay($day, $month, 'hu');
    }

    public function invalidDateDataProvider()
    {
        return [
            [55, 10],
            [155, 10],
            [1, 100],
            [1, 13],
            [31, 6],
            [32, 5],
        ];
    }


    /**
     * @dataProvider invalidCountryCodeProvider
     * @test
     */
    public function invalidCountryCode($countryCode)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->namedayInstance->specificDay(random_int(1, 10), random_int(1, 12), $countryCode);
    }

    public function invalidCountryCodeProvider()
    {
        return [
            ['abcde'],
            [''],
            ['s'],
            ['dsjbabsabdidsabidsabu'],
        ];
    }

    /**
     * @dataProvider simpleCallDataProvider
     * @test
     */
    public function simpleCall(int $day, int $month, string $country, string $name)
    {
        $response = $this->namedayInstance->specificDay($day, $month, $country);

        assertArrayHasKey('data', $response);
        assertArrayHasKey('day', $response[ 'data' ]);
        assertArrayHasKey('month', $response[ 'data' ]);
        assertArrayHasKey('name_' . $country, $response[ 'data' ]);
        assertSame($name, $response[ 'data' ][ 'name_' . $country ]);
        assertSame($day, $response[ 'data' ][ 'day' ]);
        assertSame($month, $response[ 'data' ][ 'month' ]);
        assertCount(
            3,
            $response[ 'data' ],
            "srray doesn't contains 3 elements"
        );
    }

    public function simpleCallDataProvider()
    {
        return [
        [1, 5, 'sk', 'Sviatok práce'],
        [23, 4, 'sk', 'Vojtech'],
        [23, 4, 'cz', 'Vojtěch'],
        [10, 5, 'us', 'Cormac, Cormick, Gordon, Job, Joby, Jobina, Max, Maximilian, Maximus, Maxine, Maxwell'],
        ];
    }
}
