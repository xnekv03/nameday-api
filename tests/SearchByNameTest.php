<?php

namespace Xnekv03\ApiNameday\Tests;

use Xnekv03\ApiNameday\ApiNamedayClass;

class SearchByNameTest extends BaseTest
{
    /**
     * @dataProvider invalidNameDataProvider
     *
     * @test
     */
    public function invalidName(string $name)
    {
        $this->expectException(\Exception::class);
        $this->nd->searchByName($name, 'cz');
    }

    public function invalidNameDataProvider()
    {
        return [
            [''],
            [' '],
            ['x'],
            ['xx'],
            [' xx'],
            ['xx '],
        ];
    }

    /**
     * @dataProvider invalidCountryDataProvider
     *
     * @test
     */
    public function invalidCountry(string $name, string $country)
    {
        $this->expectException(\Exception::class);
        (new ApiNamedayClass())->searchByName($name, $country);
    }

    public function invalidCountryDataProvider()
    {
        return [
            ['Jan', 'Jan Hammer - Crockett\'s Theme'],
            ['Jan', 'https://www.youtube.com/watch?v=TRCQmNMOqUY'],
            ['Jan', ''],
            ['Jan', 'h'],
            ['Jan', ' '],
            ['Jan', '   '],
            ['Jan', 'Cry Me A River '],
        ];
    }
}
