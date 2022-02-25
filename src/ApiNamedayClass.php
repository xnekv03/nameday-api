<?php

namespace Xnekv03\ApiNameday;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\InvalidArgumentException;
use Xnekv03\ApiNameday\traits\ValidationTrait;

class ApiNamedayClass{
  protected Carbon $carbonToday;
  protected string $baseUrl = 'https://nameday.abalin.net/api/V1/';
  protected string $timeZone = 'Europe/Prague';
  use ValidationTrait;

  /**
   * @param string|null $timeZone
   *
   * @throws Exception
   */
  public function __construct(string $timeZone = null){
    if(!is_null($timeZone)){
      $this->timezoneValidation($timeZone);
      $this->timeZone = $timeZone;
    }

    try{
      $this->carbonToday = Carbon::now($this->timeZone);
    }
    catch(Exception $e){
      throw new \RuntimeException($e->getMessage());
    }
  }

  /**
   * @throws Exception
   */
  public function today($countryCode = null): array{
    if(!is_null($countryCode)){
      $this->validateCountryCode($countryCode);
    }

    return $this->getSpecificDay($this->carbonToday, $countryCode);
  }

  /**
   * @throws Exception
   */
  public function tomorrow($countryCode = null): array{
    if(!is_null($countryCode)){
      $this->validateCountryCode($countryCode);
    }

    return $this->getSpecificDay($this->carbonToday->addDay(), $countryCode);
  }

  /**
   * @throws Exception
   */
  public function yesterday($countryCode = null): array{
    if(!is_null($countryCode)){
      $this->validateCountryCode($countryCode);
    }

    return $this->getSpecificDay($this->carbonToday->subDay(), $countryCode);
  }

  /**
   * @throws \JsonException
   * @throws Exception
   */
  public function searchByName(string $name, string $countryCode): array{
    $this->validateSearchName($name, $countryCode);

    return $this->callApi('getname', [
      'name' => $name,
      'country' => $countryCode,
    ]);
  }

  private function getSpecificDay(Carbon $date, string $countryCode = null): array{
    $parameters = [
      'day' => $date->day,
      'month' => $date->month,
    ];

    if(!is_null($countryCode)){
      $parameters = array_merge($parameters, ['country' => $countryCode]);
    }

    return $this->callApi('getdate', $parameters);
  }

  /**
   * @param string $urlParameter
   *
   * @return array
   * @throws \JsonException
   */
  private function callApi(string $urlParameter, array $formParams = null): array{
    try{
      $response = (new Client())->request('POST', $this->baseUrl.$urlParameter, [
        'form_params' => $formParams ?? [],
      ]);
    }
    catch(Exception $e){
      throw new InvalidArgumentException($e->getMessage());
    }

    if($response->getStatusCode() !== 200){
      throw new \RuntimeException('Unsuccessfull call');
    }

    return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
  }

  public function specificDay(int $day, int $month, string $countryCode): array{
    $this->validateCountryCode($countryCode);
    $this->validateDate($day, $month);

    return $this->getSpecificDay(Carbon::create(2000, $month, $day, 0, 0, 0, $this->timeZone), $countryCode);
  }
}
