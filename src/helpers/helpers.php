<?php

if (!function_exists('getAllSupportedCountries')) {
    /**
     * @return array|null
     */
    function getAllSupportedCountries(): array
    {
        return json_decode(file_get_contents('src/data/countryList.json'), true);
    }
}
