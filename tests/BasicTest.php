<?php


use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use namedayapi\Nameday;

abstract class BasicTest extends TestCase
{
    protected string $baseUrl = 'https://nameday.abalin.net/';
    protected array $availableCountries;
    protected $namedayInstance;
    protected Client $guzzleClient;
    protected function setUp(): void
    {
        parent::setUp();
        $countries = file_get_contents(__DIR__ . '../src/data/countryList.json');
        $this->availableCountries = json_decode((string)$countries);
        $this->namedayInstance = new Namday();
        $this->guzzleClient = new Client();
    }
}