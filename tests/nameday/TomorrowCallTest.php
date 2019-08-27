<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TomorrowCallTest extends TestCase
{

    /** @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function basicTomorrowCall()
    {
        $tomorrow = file_get_contents('https://api.abalin.net/get/tomorrow');
        $result = (new Nameday())->tomorrow();
        $this->assertEquals($result, $tomorrow);
    }

    /** @test
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function tomorrowCallWithAllCountryCodes()
    {

        $countries = file_get_contents(__DIR__ . '/data/countries.config');
        $availableCountries = json_decode((string)$countries);

        foreach ($availableCountries as $code) {
            $tomorrow = file_get_contents('https://api.abalin.net/get/tomorrow?country=' . $code->countrycode);
            $result = (new Nameday())->tomorrow($code->countrycode);
            $this->assertSame($result, $tomorrow);
        }
    }

    /**
     * @dataProvider data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testTomorrowCallWithParameters($parameter)
    {
        $result = new Nameday();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter Country');
        $result->tomorrow($parameter);
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
