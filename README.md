# Official International Name days API library
## Name day API library for [nameday.abalin.net](https://nameday.abalin.net)
This library makes it easy to send requests towards [nameday.abalin.net](https://nameday.abalin.net) API.
API provides name days for various countries. 

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
Constantly adding new Country codes, please check [nameday.abalin.net](https://nameday.abalin.net) for updated list.

When using country codes in the library you can use either **country names** or **country codes**.
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
$nameday = new Nameday();
$nameday = new Nameday('America/Vancouver'); # time zone specification, other then system default (see below)
```
##### Request name days for today / tomorrow / yesterday
```php
echo $nameday->today(); # {"data":{"day":27,"month":8,"name_us":"Caesar, Cesar ... }}
echo $nameday->tomorrow(); # {"data":{"day":28,"month":8,"name_us":"Agustin, August, Augusta ... }}
echo $nameday->yesterday(); # {"data":{"day":26,"month":8,"name_us":"Percival, Percy ... }}
```
##### Request name days for today / tomorrow / yesterday for specific country only
```php
echo $nameday->today('sk'); # {"data":{"day":27,"month":8,"name_sk":"Silvia"}}
echo $nameday->today('Slovakia'); # {"data":{"day":27,"month":8,"name_sk":"Silvia"}}

echo $nameday->tomorrow('at'); # {"data":{"day":28,"month":8,"name_at":"Adelinde, Aline, Augustin"}}
echo $nameday->tomorrow('Austria'); # {"data":{"day":28,"month":8,"name_at":"Adelinde, Aline, Augustin"}}

echo $nameday->yesterday('de'); # {"data":{"day":26,"month":8,"name_de":"Margarita, Miriam, Patricia, Teresa"}}
echo $nameday->yesterday('Germany'); # {"data":{"day":26,"month":8,"name_de":"Margarita, Miriam, Patricia, Teresa"}}
```
##### Request name days for specific date
>specificDay(int $day, int $month, string $countryCode)


```php
echo $nameday->specificDay(21,10); # {"data":{"day":21,"month":10,"name_us":"Celina, Celine, Nobel" ... }}
```

##### Request name days for specific date and for specific country only
simply add optional third string parameter ```$countryCode```, which must be one of the supported [country codes](https://nameday.abalin.net/documentation)
```php
echo $nameday->specificDay(29,3,'es'); # {"data":{"day":29,"month":3,"name_es":"Jonas, Segundo"}}
echo $nameday->specificDay(29,3,'Spain'); # {"data":{"day":29,"month":3,"name_es":"Jonas, Segundo"}}

echo $nameday->specificDay(2,12,'de'); # {"data":{"day":2,"month":12,"name_de":"Bibiana, Jan, Lucius"}}
echo $nameday->specificDay(2,12,'Germany'); # {"data":{"day":2,"month":12,"name_de":"Bibiana, Jan, Lucius"}}

echo $nameday->specificDay(12,1,'pl'); # {"data":{"day":22,"month":1,"name_pl":"Anastazy, Dobromysł, Dorian, Marta, Wincenty"}}
echo $nameday->specificDay(12,1,'Poland'); # {"data":{"day":22,"month":1,"name_pl":"Anastazy, Dobromysł, Dorian, Marta, Wincenty"}}

echo $nameday->specificDay(2,2,'hr'); # {"data":{"day":2,"month":2,"name_hr":"Marijan"}}
echo $nameday->specificDay(2,2,'Croatia'); # {"data":{"day":2,"month":2,"name_hr":"Marijan"}}
```
##### Request name day in country calendar
Will return all days in given calendar which contains the name.
>searchByName(string $day, string $countryCode)

Both parameters are required. Parameter ```$countryCode``` must be one of the supported [country codes](https://nameday.abalin.net/documentation)

```php
echo $nameday->searchByName('Jan','cz'); # {"calendar":"cz","results":[{"day":24,"month":5,"name":"Jana"},{"day":24,"month":6,"name":"Jan"} ... }}
echo $nameday->searchByName('Jan','Czech Republic'); # {"calendar":"cz","results":[{"day":24,"month":5,"name":"Jana"},{"day":24,"month":6,"name":"Jan"} ... }}
```

### Specification of time zone

Time zone is set by local ```php.ini``` settings. Therefore ```$nameday->today()``` will return result according to that.
If you need to specify different time zone you can do so by adding optional parameter ```$timeZone``` to the constructor.
```$timeZone``` must be  [PHP time zones](https://www.php.net/manual/en/timezones.php) string or integer [offset to GMT](https://en.wikipedia.org/wiki/List_of_UTC_time_offsets).

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

If you run into problems with server certificate try downloading the [The Mozilla CA certificate store](https://curl.haxx.se/docs/caextract.html), save it on your system and configure ```php.ini```
```ini
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo ="C:\...\cacert.pem"
```