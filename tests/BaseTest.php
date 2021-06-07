<?php

namespace Xnekv03\ApiNameday\Tests;

use PHPUnit\Framework\TestCase;
use Xnekv03\ApiNameday\ApiNamedayClass;

abstract class BaseTest extends TestCase
{
    public ApiNamedayClass $nd;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nd = new ApiNamedayClass();
    }
}
