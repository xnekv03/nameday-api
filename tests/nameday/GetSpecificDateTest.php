<?php declare(strict_types=1);

namespace Nameday;

use Carbon\Carbon;
use InvalidArgumentException;

class GetSpecificDateTest extends BaseTest
{

    public function testSimpleCall()
    {
        foreach ($this->availableCountries as $item) {
            $randomDate = Carbon::today()->addDays(random_int(1, 99));
            $url = $this->baseUrl . 'namedays?day='
                . $randomDate->day . '&month=' . $randomDate->month . '&country=' . $item->code;
            $specificDay = file_get_contents($url);

            $result = $this->nameday->specificDay($randomDate->day, $randomDate->month, $item->name);
            $this->assertSame($result, $specificDay);

            $result = $this->nameday->specificDay($randomDate->day, $randomDate->month, $item->code);
            $this->assertSame($result, $specificDay);
        }
    }

    /**
     * @dataProvider data
     */

    public function testSpecificDateCallWithParameters($day, $month, $countryCode, string $expectedException)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedException);
        $this->nameday->specificDay($day, $month, $countryCode);
    }

    public function data()
    {
        return [
            [4, 5, 'some nonsense', 'Invalid parameter Country'],
            [4, 5, 's', 'Invalid parameter Country'],
            [4, 5, 'som', 'Invalid parameter Country'],
            [4, 5, '', 'Invalid parameter Country'],
            [4, 5, md5('abc'), 'Invalid parameter Country'],
            [4, 55, md5('abc'), 'Invalid date'],
            [4, 55, 'fr', 'Invalid date'],
            [44, 5, 'sk', 'Invalid date'],
            [30, 2, 'us', 'Invalid date'],
            [31, 9, 'de', 'Invalid date'],
        ];
    }
}
