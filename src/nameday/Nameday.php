<?php

declare(strict_types=1);

namespace Nameday;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\InvalidArgumentException;

class Nameday
{
    protected $carbonToday;
    protected $countryList;
    protected $baseUrl = 'https://nameday.abalin.net/';

    /**
     * @param string|null $timeZone
     * @throws Exception
     */
    public function __construct(string $timeZone = null)
    {
        try {
            $this->carbonToday = is_null($timeZone) ? Carbon::now() : Carbon::now($timeZone);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->countryList = json_decode(file_get_contents('src/nameday/data/countryList.json'));
    }


    public function searchByName(string $name, string $country): array
    {
        $name = trim($name);

        if (strlen($name) < 3) {
            throw new InvalidArgumentException('The name must be at least 3 characters');
        }

        $countryCode = $this->countryCodeCheck($country);
        if (is_null($countryCode)) {
            throw new InvalidArgumentException('Invalid country code');
        }


        $response = $this->callApi(
            'getdate',
            [
                'name'    => $name,
                'country' => $countryCode
            ]
        );

        foreach ($response[ 'data' ][ 'namedays' ] as $nd) {
            $results[] = [
                'day'   => $nd[ 'day' ],
                'month' => $nd[ 'month' ],
                'name'  => $nd[ 'name' ],
            ];
        }

        return [
            'calendar' => $countryCode,
            'results'  => $results ?? [],
        ];
    }

    /**
     * @param string $country
     * @return string
     * @throws InvalidArgumentException
     */
    private function countryCodeCheck(string $country): ?string
    {
        $country = trim($country);
        if (strlen($country) < 2) {
            return null;
        }

        foreach ($this->countryList as $item) {
            if (
                !(
                strcasecmp($country, $item->countrycode)
                && strcasecmp($country, $item->name)
                && strcasecmp($country, $item->alpha3)
                )
            ) {
                return $item->countrycode;
            }
        }
        return null;
    }

    /**
     * @param string $urlParameter
     * @return array
     */
    private function callApi(string $urlParameter, array $formParams = null): array
    {
        try {
            $response = (new Client())->request(
                'POST',
                $this->baseUrl . $urlParameter,
                [
                    'form_params' => is_null($formParams) ? [] : $formParams
                ]
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Unsuccessfull call');
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param int $day
     * @param int $month
     * @param string $country
     * @return array
     * @throws InvalidArgumentException
     */
    public function specificDay(int $day, int $month, string $country): array
    {
        if (!checkdate($month, $day, 2016)) {
            throw new InvalidArgumentException('Invalid date');
        }

        $date = Carbon::createFromDate(2016, $month, $day, $this->carbonToday->timezoneName);

        $countryCode = $this->countryCodeCheck($country);
        if (is_null($countryCode)) {
            throw new InvalidArgumentException('Invalid country code');
        }

        $response = $this->callApi(
            'namedays',
            [
                'day'     => $date->day,
                'month'   => $date->month,
                'country' => $countryCode
            ]
        );

        return [
            'data' => [
                'day'                  => $date->day,
                'month'                => $date->month,
                'name_' . $countryCode => $response[ 'data' ][ 'namedays' ][ $countryCode ],
            ],
        ];
    }
}
