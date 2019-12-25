<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;

class TodayCallTest extends BaseTest
{

    /**
     *
     *
     * @test
     */
    public function basicTodayCall()
    {

        $today = file_get_contents($this->baseUrl . 'today');
        $result = $this->nameday->today();
        $this->assertEquals($result, $today);
    }

    /**
     *
     *
     * @test
     */
    public function todayCallWithAllCountryCodes()
    {

        foreach ($this->availableCountries as $item) {
            $today = file_get_contents($this->baseUrl . 'today?country=' . $item->code);

            $result = $this->nameday->today($item->name);
            $this->assertSame($result, $today);

            $result = $this->nameday->today($item->code);
            $this->assertSame($result, $today);
        }
    }

    /**
     * @dataProvider data
     */
    public function testTodayCallWithParameters($parameter)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter Country');
        $this->nameday->today($parameter);
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
