<?php

function getAllSupportedCountries(): array
{
    return json_decode(file_get_contents('src/data/countryList.json'), true);
}
