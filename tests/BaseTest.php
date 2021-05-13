<?php

declare(strict_types=1);

namespace Nameday;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected string $baseUrl = 'https://nameday.abalin.net/';
    protected array $availableCountries;
    protected $namedayInstance;
    protected Client $guzzleClient;
    protected function setUp(): void
    {
        parent::setUp();
        $countries = file_get_contents(__DIR__ . '/data/supportedCountries.json');
        $this->availableCountries = json_decode((string)$countries);
        $this->namedayInstance = new ApiHandler();
        $this->guzzleClient = new Client();
    }
}
