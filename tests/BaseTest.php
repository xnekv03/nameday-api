<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use NameDay;

abstract class BaseTest extends TestCase
{
    public NameDay $nd;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nd = new NameDay();
    }
}
