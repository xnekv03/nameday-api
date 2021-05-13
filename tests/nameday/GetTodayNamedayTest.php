<?php

declare(strict_types=1);

namespace Nameday;

use Carbon\Carbon;

use function PHPUnit\Framework\assertArrayNotHasKey;

class GetTodayNamedayTest extends BaseTest
{
    /** @test */
    public function getTodayBasicCall()
    {
        Carbon::setTestNow(Carbon::create(2021, 5, 28));
        $response = (new Nameday())->today();
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('day', $response[ 'data' ]);
        self::assertArrayHasKey('month', $response[ 'data' ]);
        self::assertArrayHasKey('name_sk', $response[ 'data' ]);
        self::assertArrayHasKey('name_fi', $response[ 'data' ]);
        self::assertArrayHasKey('name_hu', $response[ 'data' ]);
        self::assertSame('Viliam', $response[ 'data' ][ 'name_sk' ]);
        self::assertSame('Alma', $response[ 'data' ][ 'name_fi' ]);
        self::assertSame(28, $response[ 'data' ][ 'day' ]);
        self::assertSame(5, $response[ 'data' ][ 'month' ]);
    }

    /** @test */
//    public function getTodayWithCountry()
//    {
//        Carbon::setTestNow(Carbon::create(2021, 9, 2));
////        $namedayInstance = new Nameda
//        $response = (new Nameday())->today('ee');
//        self::assertArrayHasKey('data', $response);
//        self::assertArrayHasKey('day', $response[ 'data' ]);
//        self::assertArrayHasKey('month', $response[ 'data' ]);
//        self::assertArrayHasKey('name_ee', $response[ 'data' ]);
//        self::assertArrayNotHasKey('name_sk', $response[ 'data' ]);
//        self::assertArrayNotHasKey('name_fi', $response[ 'data' ]);
//        self::assertArrayNotHasKey('name_hu', $response[ 'data' ]);
//        self::assertSame('Maive, Maivi, Taive, Taivi', $response[ 'data' ][ 'name_ee' ]);
//        self::assertSame(2, $response[ 'data' ][ 'day' ]);
//        self::assertSame(9, $response[ 'data' ][ 'month' ]);
//
//    }
}
