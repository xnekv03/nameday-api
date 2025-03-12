<?php

namespace Xnekv03\ApiNameday\traits;

use DateTimeZone;

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
    public function validateSearchName(string $name): void
    {
        $min = 2;
        $max = 20;
        if (strlen(trim($name)) < $min) {
            throw new \RuntimeException('Name must contain more than '.$min.' characters');
        }

        if (strlen(trim($name)) > $max) {
            throw new \RuntimeException('Name must contain less then '.$max.' characters');
        }
    }


    /**
     * @throws \Exception
     */
    public function validateDate(int $day, int $month): void
    {
        if (!checkdate($month, $day, 2000)) {
            throw new \RuntimeException('Invalid date');
        }
    }
}
