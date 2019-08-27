<?php declare(strict_types=1);

namespace Nameday;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class Nameday
{
    protected $carbonToday;

    /**
     * @param string|null $timeZone
     * @throws Exception
     */
    public function __construct(?string $timeZone = null)
    {
        try {
            $this->carbonToday = Carbon::now($timeZone);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string|null $countryCode
     * @return string
     * @throws Exception
     */
    public function today(?string $countryCode = null): string
    {
        if ($countryCode === null) {
            return $this->specificDay($this->carbonToday->day, $this->carbonToday->month);
        }

        return $this->specificDay(
            $this->carbonToday->day,
            $this->carbonToday->month,
            $this->countryCodeCheck($countryCode)
        );
    }

    /**
     * @param string|null $countryCode
     * @return string
     * @throws Exception
     */
    public function tomorrow(?string $countryCode = null): string
    {
        $tomorrow = $this->carbonToday->clone()->addDay();
        if ($countryCode === null) {
            return $this->specificDay($tomorrow->day, $tomorrow->month);
        }

        return $this->specificDay($tomorrow->day, $tomorrow->month, $this->countryCodeCheck($countryCode));
    }

    /**
     * @param string|null $countryCode
     * @return string
     */
    public function yesterday(?string $countryCode = null): string
    {
        $yesterday = $this->carbonToday->clone()->subDay();
        if ($countryCode === null) {
            return $this->specificDay($yesterday->day, $yesterday->month);
        }

        return $this->specificDay($yesterday->day, $yesterday->month, $this->countryCodeCheck($countryCode));
    }

    /**
     * @param string $name
     * @param string $countryCode
     * @return string
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function searchByName(string $name, string $countryCode): string
    {
        if (strlen($name) < 3) {
            throw new InvalidArgumentException('Invalid parameter name');
        }

        $url = 'getdate?name=' . $name . '&calendar=' . $this->countryCodeCheck($countryCode);

        return $this->callApi($url);
    }

    /**
     * @param int $day
     * @param int $month
     * @param string|null $countryCode
     * @return string
     * @throws InvalidArgumentException
     */
    public function specificDay(int $day, int $month, ?string $countryCode = null): string
    {
        // leap year
        if (!checkdate($month, $day, 2016)) {
            throw new InvalidArgumentException('Invalid date');
        }

        $url = 'namedays?day=' . $day . '&month=' . $month;

        if ($countryCode !== null) {
            $url .= '&country=' . $this->countryCodeCheck($countryCode);
        }
        return $this->callApi($url);
    }

    /**
     * @param string $countryCode
     * @return string
     * @throws InvalidArgumentException
     */
    private function countryCodeCheck(string $countryCode): string
    {
        if (strlen(trim($countryCode)) !== 2) {
            throw new InvalidArgumentException('Invalid parameter Country');
        }
        return trim($countryCode);
    }

    /**
     * @param string $urlParameter
     * @return string
     * @throws GuzzleException
     */
    private function callApi(string $urlParameter): string
    {
        $client = new Client();

        $res = $client->request('GET', 'https://api.abalin.net/get/' . $urlParameter);
        return $res->getBody()->getContents();
    }
}
