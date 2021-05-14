<?php

declare(strict_types=1);

namespace Test;


use App\NameDay;
use Carbon\Carbon;

class GetTomorrowNamedayTest extends BaseTest
{
    /** @test */
    public function getTomorrowBasicCall()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 28));
        $response = (new NameDay())->tomorrow();
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('day', $response['data']);
        self::assertArrayHasKey('month', $response['data']);
        self::assertArrayHasKey('name_sk', $response['data']);
        self::assertArrayHasKey('name_fi', $response['data']);
        self::assertArrayHasKey('name_hu', $response['data']);
        self::assertSame('Vilma', $response['data']['name_sk']);
        self::assertSame('Oiva, Oivi', $response['data']['name_fi']);
        self::assertSame(29, $response['data']['day']);
        self::assertSame(5, $response['data']['month']);
    }

    /** @test */
    public function getTomorrowWithCountry()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 28));
        $response = (new NameDay())->tomorrow('ee');
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('day', $response['data']);
        self::assertArrayHasKey('month', $response['data']);
        self::assertArrayHasKey('name_ee', $response['data']);
        self::assertArrayNotHasKey('name_sk', $response['data']);
        self::assertArrayNotHasKey('name_fi', $response['data']);
        self::assertArrayNotHasKey('name_hu', $response['data']);
        self::assertSame('Laido, Leido, Leidur, Luulik', $response['data']['name_ee']);
        self::assertSame(29, $response['data']['day']);
        self::assertSame(5, $response['data']['month']);
    }

    /** @test */
    public function getTomorrowWithAllCountriesCountryCode()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 28));
        foreach (getAllSupportedCountries() as $item) {
            $response = (new Nameday())->tomorrow($item['countrycode']);
            self::assertArrayHasKey('data', $response);
            self::assertArrayHasKey('day', $response['data']);
            self::assertArrayHasKey('month', $response['data']);
            self::assertArrayHasKey('name_' . $item['countrycode'], $response['data']);
            self::assertCount(3, $response['data']);
            self::assertSame(29, $response['data']['day']);
            self::assertSame(5, $response['data']['month']);
        }
    }

    /** @test */
    public function getTomorrowWithAllCountriesAlpha3()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 2));
        foreach (getAllSupportedCountries() as $item) {
            $response = (new Nameday())->tomorrow($item['alpha3']);
            self::assertArrayHasKey('data', $response);
            self::assertArrayHasKey('day', $response['data']);
            self::assertArrayHasKey('month', $response['data']);
            self::assertArrayHasKey('name_' . $item['countrycode'], $response['data']);
            self::assertCount(3, $response['data']);
            self::assertSame(3, $response['data']['day']);
            self::assertSame(9, $response['data']['month']);
        }
    }

    /** @test */
    public function getTomorrowWithAllCountriesWithName()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 2));
        foreach (getAllSupportedCountries() as $item) {
            $response = (new Nameday())->tomorrow($item['name']);
            self::assertArrayHasKey('data', $response);
            self::assertArrayHasKey('day', $response['data']);
            self::assertArrayHasKey('month', $response['data']);
            self::assertArrayHasKey('name_' . $item['countrycode'], $response['data']);
            self::assertCount(3, $response['data']);
            self::assertSame(3, $response['data']['day']);
            self::assertSame(9, $response['data']['month']);
        }
    }
}
