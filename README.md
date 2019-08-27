# Official International Namedays API library
## Nameday API library for [api.abalin.net](https://api.abalin.net)
This library makes it easy to send requests towards [api.abalin.net](https://api.abalin.net) API.
API provides namedays for varius countries. For list of supported countries reach out to api [dociumentation](https://api.abalin.net/documentation). 

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

## Usage

##### create an instance of the class
```php
$nameday = new Nameday();
```
##### Request namedays for today / tomorrow / yesterday
```php
echo $nameday->today(); # {"data":{"day":27,"month":8,"name_us":"Caesar, Cesar ... }}
echo $nameday->tomorrow(); # {"data":{"day":28,"month":8,"name_us":"Agustin, August, Augusta ... }}
echo $nameday->yesterday(); # {"data":{"day":26,"month":8,"name_us":"Percival, Percy ... }}
```
##### Request namedays for today / tomorrow / yesterday for specific country only
```php
echo $nameday->today('sk'); # {"data":{"day":27,"month":8,"name_sk":"Silvia"}}
echo $nameday->tomorrow('at'); # {"data":{"day":28,"month":8,"name_at":"Adelinde, Aline, Augustin"}}
echo $nameday->yesterday('de'); # {"data":{"day":26,"month":8,"name_de":"Margarita, Miriam, Patricia, Teresa"}}
```
##### Request namedays for specific date
>specificDay(int $day, int $month, string $countryCode)


```php
echo $nameday->specificDay(21,10); # {"data":{"day":21,"month":10,"name_us":"Celina, Celine, Nobel" ... }}
```

##### Request namedays for specific date and for specific country only
simply add optional third string parameter ```$countryCode```, which must be one of the supported [country codes](https://api.abalin.net/documentation)
```php
echo $nameday->specificDay(29,3,'es'); # {"data":{"day":29,"month":3,"name_es":"Jonas, Segundo"}}
echo $nameday->specificDay(2,12,'de'); # {"data":{"day":2,"month":12,"name_de":"Bibiana, Jan, Lucius"}}
echo $nameday->specificDay(12,1,'pl'); # {"data":{"day":22,"month":1,"name_pl":"Anastazy, Dobromysł, Dorian, Marta, Wincenty"}}
echo $nameday->specificDay(2,2,'hr'); # {"data":{"day":2,"month":2,"name_hr":"Marijan"}}
```
##### Request nameday in country calendar
Will return all days in given calendar which contains the name.
>searchByName(string $day, string $countryCode)

Both parametrs are required. Parameter ```$countryCode``` must be one of the supported [country codes](https://api.abalin.net/documentation)

```php
echo $nameday->searchByName('Jan','cz'); # {"calendar":"cz","results":[{"day":24,"month":5,"name":"Jana"},{"day":24,"month":6,"name":"Jan"} ... }}
```

### Specification of Timezene

Timezone is set by local ```php.ini``` settings. Terefore ```$nameday->today()``` will return result according to that.
If you need to specify different timezone you can do so by adding optional parameter ```$timeZone``` to the constructor.
```$timeZone``` must be  [PHP timezones](https://www.php.net/manual/en/timezones.php) string or integer [offset to GMT](https://en.wikipedia.org/wiki/List_of_UTC_time_offsets).

```php
$nameday = new Nameday('Pacific/Honolulu');
echo $nameday->today(); # will return today namedays according to Pacific/Honolulu timezone
```

```php
$nameday = new Nameday('+13:30');
echo $nameday->tomorrow(); # will return today namedays according to given UTC offset
```

### Certificate
Make sure you have proper certificates stored on your local machine as Nameday API uses HTTPS only. 

If you run into problems with server certificate try downloading the [The Mozilla CA certificate store](https://curl.haxx.se/docs/caextract.html), save it on your system and configure ```php.ini```
```ini
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo ="C:\...\cacert.pem"
```