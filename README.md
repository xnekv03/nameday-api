# Official International Name days API library


<a href="#"><img src="https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-no-action.svg"></a>
## Name day API library for [nameday.abalin.net](https://nameday.abalin.net)

This library makes it easy to send requests towards [nameday.abalin.net](https://nameday.abalin.net) API. API provides name days for various
countries.

## Installation

The recommended way to install package is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of package:

```bash
composer require xnekv03/nameday-api
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update package using composer:

 ```bash
composer update
 ```

## List of supported countries

* Country names
    * United States
    * Czech Republic
    * Slovakia
    * Poland
    * France
    * Hungary
    * Croatia
    * Sweden
    * Austria
    * Italy
    * Germany
    * Spain
* Country codes
    * us
    * cz
    * sk
    * pl
    * fr
    * hu
    * hr
    * se
    * at
    * it
    * de
    * es

## Usage

##### create an instance of the class

```php
use Xnekv03\ApiNameday\ApiNamedayClass as Nameday;

$nameday = new Nameday();
$nameday = new Nameday('America/Vancouver'); # time zone specification, other then system default (see below)
```

##### Request name days for today / tomorrow / yesterday

```php
echo $nameday->today(); # {"data":{"day":27,"month":8,"name_us":"Caesar, Cesar ... }}
echo $nameday->tomorrow(); # {"data":{"day":28,"month":8,"name_us":"Agustin, August, Augusta ... }}
echo $nameday->yesterday(); # {"data":{"day":26,"month":8,"name_us":"Percival, Percy ... }}
```


##### Request name days for specific date

```php
echo $nameday->specificDay(int $day, int $month);
```

```php
echo $nameday->specificDay(21,10); # {"data":{"day":21,"month":10,"name_us":"Celina, Celine, Nobel" ... }}
```


##### Request name day in country calendar

Will return all days which contains the name.
> searchByName(string $name)
```php
echo $nameday->searchByName('Jan'); # {"calendar":"cz","results":[{"day":24,"month":5,"name":"Jana"},{"day":24,"month":6,"name":"Jan"} ... }}
```

### Specification of time zone

Time zone is set by local ```php.ini``` settings. Therefore ```$nameday->today()``` will return result according to that. If you need to specify
different time zone you can do so by adding optional parameter ```$timeZone``` to the constructor.
```$timeZone``` must be  [PHP time zones](https://www.php.net/manual/en/timezones.php) string or
integer [offset to GMT](https://en.wikipedia.org/wiki/List_of_UTC_time_offsets).

```php
$nameday = new Nameday('Pacific/Honolulu');
echo $nameday->today(); # will return today name days according to Pacific/Honolulu time zone
```

```php
$nameday = new Nameday('+13:30');
echo $nameday->tomorrow(); # will return today name days according to given UTC offset
```

### Certificate

Make sure you have proper certificates stored on your local machine as Name day API uses HTTPS only.

If you run into problems with server certificate try downloading the [The Mozilla CA certificate store](https://curl.haxx.se/docs/caextract.html),
save it on your system and configure ```php.ini```

```ini
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo = "C:\...\cacert.pem"
```