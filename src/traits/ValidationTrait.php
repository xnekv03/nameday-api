<?php

namespace Xnekv03\ApiNameday\traits;

trait ValidationTrait
{
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
    public function validateSearchName(string $name, string $countryCode): void
    {
        $min = 3;
        $max = 20;
        if (strlen(trim($name)) < $min) {
            throw new \RuntimeException('Name must contain more than '.$min.' characters');
        }

        if (strlen(trim($name)) > $max) {
            throw new \RuntimeException('Name must contain less then '.$max.' characters');
        }
        $this->validateCountryCode($countryCode);
    }

    /**
     * @throws \Exception
     */
    public function validateCountryCode(string $countryCode)
    {
        if (!in_array($countryCode, $this->supportedCountries, true)) {
            throw new \RuntimeException('Unsupported country');
        }
    }
}
