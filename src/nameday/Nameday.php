<?php declare(strict_types=1);

namespace Nameday;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;

class Nameday
{
    protected $carbonToday;
    protected $countryList;

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

        $this->countryList = json_decode((string)file_get_contents('src/nameday/data/countryList.json'));
    }

    /**
     * @param string|null $country
     * @return string
     * @throws Exception
     */
    public function today(?string $country = null): string
    {
        if ($country === null) {
            return $this->specificDay($this->carbonToday->day, $this->carbonToday->month);
        }

        return $this->specificDay(
            $this->carbonToday->day,
            $this->carbonToday->month,
            $this->countryCodeCheck($country)
        );
    }

    /**
     * @param string|null $country
     * @return string
     * @throws Exception
     */
    public function tomorrow(?string $country = null): string
    {
        $tomorrow = $this->carbonToday->clone()->addDay();
        if ($country === null) {
            return $this->specificDay($tomorrow->day, $tomorrow->month);
        }

        return $this->specificDay($tomorrow->day, $tomorrow->month, $this->countryCodeCheck($country));
    }

    /**
     * @param string|null $country
     * @return string
     */
    public function yesterday(?string $country = null): string
    {
        $yesterday = $this->carbonToday->clone()->subDay();
        if ($country === null) {
            return $this->specificDay($yesterday->day, $yesterday->month);
        }

        return $this->specificDay($yesterday->day, $yesterday->month, $this->countryCodeCheck($country));
    }

    /**
     * @param string $name
     * @param string $country
     * @return string
     */
    public function searchByName(string $name, string $country): string
    {
        if (strlen($name) < 3) {
            throw new InvalidArgumentException('Invalid parameter name');
        }

        $url = 'getdate?name=' . $name . '&calendar=' . $this->countryCodeCheck($country);

        return $this->callApi($url);
    }

    /**
     * @param int $day
     * @param int $month
     * @param string|null $country
     * @return string
     * @throws InvalidArgumentException
     */
    public function specificDay(int $day, int $month, ?string $country = null): string
    {
        // leap year
        if (!checkdate($month, $day, 2016)) {
            throw new InvalidArgumentException('Invalid date');
        }

        $url = 'namedays?day=' . $day . '&month=' . $month;

        if ($country !== null) {
            $url .= '&country=' . $this->countryCodeCheck($country);
        }
        return $this->callApi($url);
    }

    /**
     * @param string $country
     * @return string
     * @throws InvalidArgumentException
     */
    private function countryCodeCheck(string $country): string
    {
        $countryCode = strtolower(trim($country));
        foreach ($this->countryList as $item) {
            if ($countryCode === $item->name || $countryCode === $item->code) {
                return $item->code;
            }
        }
        throw new InvalidArgumentException('Invalid parameter Country');
    }

    /**
     * @param string $urlParameter
     * @return string
     */
    private function callApi(string $urlParameter): string
    {
        $client = new Client();

        $res = $client->request('GET', 'https://api.abalin.net/get/' . $urlParameter);
        return $res->getBody()->getContents();
    }
}
