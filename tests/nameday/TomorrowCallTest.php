<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;

class TomorrowCallTest extends BaseTest
{

    /** @test
     */
    public function basicTomorrowCall()
    {
        $tomorrow = file_get_contents($this->baseUrl . 'tomorrow');
        $result = $this->nameday->tomorrow();
        $this->assertEquals($result, $tomorrow);
    }

    /** @test
     */
    public function tomorrowCallWithAllCountryCodes()
    {

        foreach ($this->availableCountries as $item) {
            $tomorrow = file_get_contents($this->baseUrl . 'tomorrow?country=' . $item->code);

            $result = $this->nameday->tomorrow($item->name);
            $this->assertSame($result, $tomorrow);

            $result = $this->nameday->tomorrow($item->code);
            $this->assertSame($result, $tomorrow);
        }
    }

    /**
     * @dataProvider data
     */
    public function testTomorrowCallWithParameters($parameter)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter Country');
        $this->nameday->tomorrow($parameter);
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
