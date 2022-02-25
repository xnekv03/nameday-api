<?php

declare(strict_types=1);

namespace Xnekv03\ApiNameday\Tests;

use Carbon\Carbon;
use Xnekv03\ApiNameday\ApiNamedayClass;

class GetTodayNamedayTest extends BaseTest
{
    /** @test */
    public function getTodayBasicCall()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 28));
        $response = (new ApiNamedayClass())->today();

        self::assertArrayHasKey('day', $response);
        self::assertArrayHasKey('month', $response);
        self::assertArrayHasKey('nameday', $response);
        self::assertSame('Spas, Spaska', $response['nameday']['bg']);
        self::assertSame(28, $response['day']);
        self::assertSame(5, $response['month']);
    }

    /** @test */
    public function getTodayWithCountry()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 2));
        $response = (new ApiNamedayClass())->today('ee');
        self::assertArrayHasKey('day', $response);
        self::assertArrayHasKey('month', $response);
        self::assertArrayHasKey('nameday', $response);
        self::assertSame('Maive, Maivi, Taive, Taivi', $response['nameday']['ee']);
        self::assertSame(2, $response['day']);
        self::assertSame(9, $response['month']);
    }
}
