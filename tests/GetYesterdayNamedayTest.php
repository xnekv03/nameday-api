<?php

declare(strict_types=1);

namespace Xnekv03\ApiNameday\Tests;

use Carbon\Carbon;
use Xnekv03\ApiNameday\ApiNamedayClass;

class GetYesterdayNamedayTest extends BaseTest
{
    /** @test */
    public function getYesterdayBasicCall()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 29));
        $response = (new ApiNamedayClass())->yesterday();

        self::assertArrayHasKey('day', $response);
        self::assertArrayHasKey('month', $response);
        self::assertArrayHasKey('nameday', $response);
        self::assertSame('Spas, Spaska', $response['nameday']['bg']);
        self::assertSame(28, $response['day']);
        self::assertSame(5, $response['month']);
    }

    /** @test */
    public function getYesterdayWithCountry()
    {
        Carbon::setTestNow(Carbon::create(2021, 9, 3));
        $response = (new ApiNamedayClass())->yesterday('ee');
      self::assertArrayHasKey('day', $response);
      self::assertArrayHasKey('month', $response);
      self::assertArrayHasKey('nameday', $response);
      self::assertSame('Maive, Maivi, Taive, Taivi', $response['nameday']['ee']);
      self::assertSame(2, $response['day']);
      self::assertSame(9, $response['month']);
    }
}
