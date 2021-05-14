<?php

declare(strict_types=1);

namespace tests;

use App\NameDay;
use Carbon\Carbon;

class GetYesterdayNamedayTest extends BaseTest
{
    /** @test */
    public function getYesterdayBasicCall()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 29));
        $response = (new NameDay())->yesterday();
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('day', $response[ 'data' ]);
        self::assertArrayHasKey('month', $response[ 'data' ]);
        self::assertArrayHasKey('name_sk', $response[ 'data' ]);
        self::assertArrayHasKey('name_fi', $response[ 'data' ]);
        self::assertArrayHasKey('name_hu', $response[ 'data' ]);
        self::assertSame('Viliam', $response[ 'data' ][ 'name_sk' ]);
        self::assertSame('Alma', $response[ 'data' ][ 'name_fi' ]);
        self::assertSame(28, $response[ 'data' ][ 'day' ]);
        self::assertSame(5, $response[ 'data' ][ 'month' ]);
    }

    /** @test */
    public function getYesterdayWithCountry()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 29));
        $response = (new NameDay())->yesterday('ee');
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('day', $response[ 'data' ]);
        self::assertArrayHasKey('month', $response[ 'data' ]);
        self::assertArrayHasKey('name_ee', $response[ 'data' ]);
        self::assertArrayNotHasKey('name_sk', $response[ 'data' ]);
        self::assertArrayNotHasKey('name_fi', $response[ 'data' ]);
        self::assertArrayNotHasKey('name_hu', $response[ 'data' ]);
        self::assertSame('Roman, Roome, Roomet, Roomo', $response[ 'data' ][ 'name_ee' ]);
        self::assertSame(28, $response[ 'data' ][ 'day' ]);
        self::assertSame(5, $response[ 'data' ][ 'month' ]);
    }
        /** @test */
    public function getYesterdayWithAllCountriesCountryCode()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 29));
        foreach (getAllSupportedCountries() as $item) {
            $response = (new Nameday())->yesterday($item['countrycode']);
            self::assertArrayHasKey('data', $response);
            self::assertArrayHasKey('day', $response[ 'data' ]);
            self::assertArrayHasKey('month', $response[ 'data' ]);
            self::assertArrayHasKey('name_' . $item['countrycode'], $response[ 'data' ]);
            self::assertCount(3, $response[ 'data' ]);
            self::assertSame(28, $response[ 'data' ][ 'day' ]);
            self::assertSame(5, $response[ 'data' ][ 'month' ]);
        }
    }

    /** @test */
    public function getYesterdayWithAllCountriesAlpha3()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 3));
        foreach (getAllSupportedCountries() as $item) {
            $response = (new Nameday())->yesterday($item['alpha3']);
            self::assertArrayHasKey('data', $response);
            self::assertArrayHasKey('day', $response[ 'data' ]);
            self::assertArrayHasKey('month', $response[ 'data' ]);
            self::assertArrayHasKey('name_' . $item['countrycode'], $response[ 'data' ]);
            self::assertCount(3, $response[ 'data' ]);
            self::assertSame(2, $response[ 'data' ][ 'day' ]);
            self::assertSame(9, $response[ 'data' ][ 'month' ]);
        }
    }

    /** @test */
    public function getYesterdayWithAllCountriesWithName()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 3));
        foreach (getAllSupportedCountries() as $item) {
            $response = (new Nameday())->yesterday($item['name']);
            self::assertArrayHasKey('data', $response);
            self::assertArrayHasKey('day', $response[ 'data' ]);
            self::assertArrayHasKey('month', $response[ 'data' ]);
            self::assertArrayHasKey('name_' . $item['countrycode'], $response[ 'data' ]);
            self::assertCount(3, $response[ 'data' ]);
            self::assertSame(2, $response[ 'data' ][ 'day' ]);
            self::assertSame(9, $response[ 'data' ][ 'month' ]);
        }
    }
}
