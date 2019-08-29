<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TodayCallTest extends TestCase
{

    /** @test
     */
    public function basicTodayCall()
    {
        $today = file_get_contents('https://api.abalin.net/get/today');
        $result = (new Nameday())->today();
        $this->assertEquals($result, $today);
    }

    /** @test
     */
    public function todayCallWithAllCountryCodes()
    {

        $countries = file_get_contents(__DIR__ . '/data/supportedCountries.json');
        $availableCountries = json_decode((string)$countries);

        foreach ($availableCountries as $item) {
            $today = file_get_contents('https://api.abalin.net/get/today?country=' . $item->code);

            $result = (new Nameday())->today($item->name);
            $this->assertSame($result, $today);

            $result = (new Nameday())->today($item->code);
            $this->assertSame($result, $today);
        }
    }

    /**
     * @dataProvider data
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
