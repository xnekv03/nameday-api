<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TomorrowCallTest extends TestCase
{

    /** @test
     */
    public function basicTomorrowCall()
    {
        $tomorrow = file_get_contents('https://api.abalin.net/get/tomorrow');
        $result = (new Nameday())->tomorrow();
        $this->assertEquals($result, $tomorrow);
    }

    /** @test
     */
    public function tomorrowCallWithAllCountryCodes()
    {

        $countries = file_get_contents(__DIR__ . '/data/supportedCountries.json');
        $availableCountries = json_decode((string)$countries);

        foreach ($availableCountries as $item) {
            $tomorrow = file_get_contents('https://api.abalin.net/get/tomorrow?country=' . $item->code);

            $result = (new Nameday())->tomorrow($item->name);
            $this->assertSame($result, $tomorrow);

            $result = (new Nameday())->tomorrow($item->code);
            $this->assertSame($result, $tomorrow);
        }
    }

    /**
     * @dataProvider data
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
