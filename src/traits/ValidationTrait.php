<?php

namespace Xnekv03\ApiNameday\traits;

use DateTimeZone;

trait ValidationTrait{
  protected array $supportedCountries = [
    'at',
    'cz',
    'fi',
    'gr',
    'lv',
    'ru',
    'se',
    'bg',
    'dk',
    'fr',
    'hu',
    'lt',
    'sk',
    'us',
    'hr',
    'ee',
    'de',
    'it',
    'pl',
    'es',
  ];

  /**
   * @throws \Exception
   */
  public function validateSearchName(string $name, string $countryCode): void{
    $min = 3;
    $max = 20;
    if(strlen(trim($name)) < $min){
      throw new \RuntimeException('Name must contain more than '.$min.' characters');
    }

    if(strlen(trim($name)) > $max){
      throw new \RuntimeException('Name must contain less then '.$max.' characters');
    }
    $this->validateCountryCode($countryCode);
  }

  /**
   * @throws \Exception
   */
  public function validateCountryCode(string $countryCode){
    if(!in_array($countryCode, $this->supportedCountries, true)){
      throw new \RuntimeException('Unsupported country');
    }
  }

  /**
   * @throws \Exception
   */
  public function validateDate(int $day, int $month){
    if(!checkdate($month, $day, 2000)){
      throw new \RuntimeException('Invalid date');
    }
  }

  /**
   * @throws \Exception
   */
  public function timezoneValidation(string $timeZone){
    if(!in_array($timeZone, DateTimeZone::listIdentifiers(), true)){
      throw new \RuntimeException('Invalid timezone');
    }
  }
}
