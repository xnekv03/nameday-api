<?php

declare(strict_types=1);

namespace Xnekv03\ApiNameday\Tests;

use Carbon\Carbon;
use Xnekv03\ApiNameday\ApiNamedayClass;

class GetTomorrowNamedayTest extends BaseTest
{
    /** @test */
    public function getTomorrowBasicCall()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 27));
        $response = (new ApiNamedayClass())->tomorrow();

        self::assertArrayHasKey('day', $response);
        self::assertArrayHasKey('month', $response);
        self::assertArrayHasKey('nameday', $response);
        self::assertSame('Spas, Spaska', $response['nameday']['bg']);
        self::assertSame(28, $response['day']);
        self::assertSame(5, $response['month']);
    }

    /** @test */
    public function getTomorrowWithCountry()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 1));
        $response = (new ApiNamedayClass())->tomorrow('ee');
        self::assertArrayHasKey('day', $response);
        self::assertArrayHasKey('month', $response);
        self::assertArrayHasKey('nameday', $response);
        self::assertSame('Maive, Maivi, Taive, Taivi', $response['nameday']['ee']);
        self::assertSame(2, $response['day']);
        self::assertSame(9, $response['month']);
    }
}
