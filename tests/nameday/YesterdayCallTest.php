<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class YesterdayCallTest extends TestCase
{

    /** @test
     */
    public function basicYesterdayCall()
    {
        $yesterday = file_get_contents('https://api.abalin.net/get/yesterday');
        $result = (new Nameday())->yesterday();
        $this->assertEquals($result, $yesterday);
    }

    /** @test
     */
    public function yesterdayCallWithAllCountryCodes()
    {
        $countries = file_get_contents(__DIR__ . '/data/supportedCountries.json');
        $availableCountries = json_decode((string)$countries);

        foreach ($availableCountries as $item) {
            $tomorrow = file_get_contents('https://api.abalin.net/get/yesterday?country=' . $item->code);

            $result = (new Nameday())->yesterday($item->name);
            $this->assertSame($result, $tomorrow);

            $result = (new Nameday())->yesterday($item->code);
            $this->assertSame($result, $tomorrow);
        }
    }

    /**
     * @dataProvider data
     */
    public function testYesterdayCallWithParameters($parameter)
    {
        $result = new Nameday();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter Country');
        $result->yesterday($parameter);
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
