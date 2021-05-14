<?php

namespace tests;

use App\NameDay;

class SomeTest extends BaseTest
{

    /** */
    public function testik()
    {
            self::assertSame('abc', 'abc');
            self::assertSame('abc', $this->nd->metoda());
    }
}
