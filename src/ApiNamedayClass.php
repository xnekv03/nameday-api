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
  protected string $defaultTimeZone = 'Europe/Prague';
  use ValidationTrait;

  /**
   * @param string|null $timeZone
   *
   * @throws Exception
   */
  public function __construct(string $timeZone = null){
    try{
      $this->carbonToday = Carbon::now($timeZone ?? $this->defaultTimeZone);
    }
    catch(Exception $e){
      throw new Exception($e->getMessage());
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
}
