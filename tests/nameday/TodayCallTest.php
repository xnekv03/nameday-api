<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TodayCallTest extends TestCase
{

    /** @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function basicTodayCall()
    {
        $today = file_get_contents('https://api.abalin.net/get/today');
        $result = (new Nameday())->today();
        $this->assertEquals($result, $today);
    }

    /** @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function todayCallWithAllCountryCodes()
    {

        $countries = file_get_contents(__DIR__ . '/data/countries.config');
        $availableCountries = json_decode((string)$countries);

        foreach ($availableCountries as $code) {
            $today = file_get_contents('https://api.abalin.net/get/today?country=' . $code->countrycode);
            $result = (new Nameday())->today($code->countrycode);
            $this->assertSame($result, $today);
        }
    }

    /**
     * @dataProvider data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testTodayCallWithParameters($parameter)
    {
        $result = new Nameday();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter Country');
        $result->today($parameter);
    }

    public function data()
    {
        return [
            ['xxxx'],
            ['x'],
            ['1234'],
            [''],
        ];
    }
}
