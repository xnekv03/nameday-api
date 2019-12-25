<?php declare(strict_types=1);

namespace Nameday;

use InvalidArgumentException;

class YesterdayCallTest extends BaseTest
{

    /**
     *
     *
     * @test
     */
    public function basicYesterdayCall()
    {
        $yesterday = file_get_contents($this->baseUrl . 'yesterday');
        $result = $this->nameday->yesterday();
        $this->assertEquals($result, $yesterday);
    }

    /**
     *
     *
     * @test
     */
    public function yesterdayCallWithAllCountryCodes()
    {

        foreach ($this->availableCountries as $item) {
            $tomorrow = file_get_contents($this->baseUrl . 'yesterday?country=' . $item->code);

            $result = $this->nameday->yesterday($item->name);
            $this->assertSame($result, $tomorrow);

            $result = $this->nameday->yesterday($item->code);
            $this->assertSame($result, $tomorrow);
        }
    }

    /**
     * @dataProvider data
     */
    public function testYesterdayCallWithParameters($parameter)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid parameter Country');
        $this->nameday->yesterday($parameter);
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
