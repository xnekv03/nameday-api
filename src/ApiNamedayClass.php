<?php

namespace Xnekv03\ApiNameday;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\InvalidArgumentException;
use JsonException;
use Xnekv03\ApiNameday\traits\ValidationTrait;

class ApiNamedayClass
{
    protected Carbon $carbonToday;
    protected string $timeZone;
    protected string $baseUrl = 'https://nameday.abalin.net/api/V2/';
    use ValidationTrait;

    /**
     * @param string|null $timeZone
     *
     * @throws Exception
     */
    public function __construct(?string $timeZone = null)
    {
        try {
            $this->carbonToday = Carbon::today($timeZone ?? date_default_timezone_get());
        } catch (Exception $e) {
            throw new \RuntimeException('Invalid timezone');
        }

        $this->timeZone = $this->carbonToday->getTimezone();
    }

    /**
     * @throws Exception
     */
    public function today(): array
    {
        return $this->getSpecificDay($this->carbonToday);
    }

    /**
     * @throws Exception
     */
    public function tomorrow(): array
    {
        return $this->getSpecificDay($this->carbonToday->addDay());
    }

    /**
     * @throws Exception
     */
    public function yesterday(): array
    {
        return $this->getSpecificDay($this->carbonToday->subDay());
    }

    /**
     * @throws \JsonException
     * @throws Exception
     * @throws GuzzleException
     */
    public function searchByName(string $name): array
    {
        $this->validateSearchName($name);

        return $this->callApi('getname', [
            'name' => $name,
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function getSpecificDay(Carbon $date): array
    {
        return $this->callApi('date', [
            'day'   => $date->day,
            'month' => $date->month,
        ]);
    }

    public function specificDay(int $day, int $month): array
    {
        $this->validateDate($day, $month);

        return $this->getSpecificDay(Carbon::create(year: 2000, month: $month, day: $day, timezone: $this->timeZone));
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function callApi(string $url, array $data)
    {
        try {
            $response = (new Client())->request('POST', $this->baseUrl.$url, [
                'json'    => $data,
                'headers' => [
                    'vne-client' => 'xnekv03/nameday-api',
                    'Accept'     => 'application/json',
                ],
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Unsuccessful call');
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
