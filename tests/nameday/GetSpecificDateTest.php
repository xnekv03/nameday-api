<?php declare(strict_types=1);

namespace Nameday;

use Carbon\Carbon;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GetSpecificDateTest extends TestCase
{

    protected $availableCountries;

    public function setUp(): void
    {
        parent::setUp();
        $countries = file_get_contents(__DIR__ . '/data/countries.config');
        $this->availableCountries = json_decode((string)$countries);
    }

    public function testSimpleCall()
    {
        foreach ($this->availableCountries as $code) {
            $randomDate = Carbon::today()->addDays(random_int(1, 99));
            $url = 'https://api.abalin.net/get/namedays?day='
                . $randomDate->day . '&month=' . $randomDate->month . '&country=' . $code->countrycode;
            $specificDay = file_get_contents($url);

            $result = (new Nameday())->specificDay($randomDate->day, $randomDate->month, $code->countrycode);

            $this->assertSame($result, $specificDay);
        }
    }

    /**
     * @dataProvider data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function testSpecificDateCallWithParameters($day, $month, $countryCode, string $expectedException)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedException);
        (new Nameday())->specificDay($day, $month, $countryCode);
    }

    public function data()
    {
        return [
            [4, 5, 'some onsense', 'Invalid parameter Country'],
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
