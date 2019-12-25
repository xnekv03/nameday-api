<?php


namespace Nameday;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected $baseUrl = 'https://api.abalin.net/';
    protected $availableCountries;
    protected $nameday;

    protected function setUp(): void
    {
        parent::setUp();

        $countries = file_get_contents(__DIR__ . '/data/supportedCountries.json');
        $this->availableCountries = json_decode((string)$countries);
        $this->nameday = new Nameday();
    }
}
