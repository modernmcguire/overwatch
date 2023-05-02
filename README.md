# Overwatch

[![Downloads on Packagist](https://img.shields.io/packagist/dt/modernmcguire/overwatch.svg?style=flat)](https://packagist.org/packages/modernmcguire/overwatch)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/modernmcguire/overwatch.svg?style=flat)](https://packagist.org/packages/modernmcguire/overwatch)


This package allows you to define custom metrics for a Laravel application and retrieve them either through an HTTP request or a command.

## Installation

You can install the package via composer:

```bash
composer require modernmcguire/overwatch
```

To create a new overwatch secret key for your application, use the following command:
```bash
php artisan overwatch:generate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="overwatch-config"
```

This is the contents of the published config file which will include the laravel and php version by default:

```php
<?php

use Modernmcguire\Overwatch\Metrics\PhpVersion;
use Modernmcguire\Overwatch\Metrics\LaravelVersion;

return [

    'secret' => env('OVERWATCH_SECRET'),

    'metrics' => [
        PhpVersion::class,
        LaravelVersion::class,
    ],
];
```

## Usage
Overwatch works by querying your application for Metrics that you want to track. You can create your own metrics by extending the `Metric` class and implementing the `handle()` method.

```php
<?php

namespace App\Metrics;

use Modernmcguire\Overwatch\Metric;

class TotalUsers extends Metric
{
    public function handle()
    {
        return User::count();
    }
}
```

By default the metric will be snake cased and returned as a string. You can customize this by providing a constant KEY in your metrics.

```php
<?php

namespace App\Metrics;

use Modernmcguire\Overwatch\Metric;

class TotalUsers extends Metric
{
    const KEY = 'app_users';

    public function handle()
    {
        return User::count();
    }
}
```

Now that you have a new metric to watch, let's add it to your config.

```php
<?php

use App\Metric\TotalUsers;
use Modernmcguire\Overwatch\Metrics\PhpVersion;
use Modernmcguire\Overwatch\Metrics\LaravelVersion;

return [
    'metrics' => [
        PhpVersion::class,
        LaravelVersion::class,

        TotalUsers::class,
    ],
];
```


## Security
In order to protect sensitive metrics, Overwatch requires a secret key to be provided in the request. This secret key is used to encrypt the payload and verify the request came from a trusted source.

To generate a secret key, use the following command:
```bash
php artisan overwatch:generate
```

This will generate a new secret key and store it in your `.env` file. You can also set the secret key manually by adding the following to your `.env` file:
```bash
OVERWATCH_SECRET=your-secret-key
```

## Fetching Data
To get metric data on an application that has Overwatch installed, you can make a POST request to the `/overwatch` route. The payload should be encrypted using the secret key that was generated for your application.

```php
<?php

use Illuminate\Encryption\Encrypter;

$newEncrypter = new Encrypter(
    $super_secret_key,
    strtolower(config('app.cipher'))
);

// adding a timestamp to the payload helps prevent replay attacks
$payload = json_encode([
    'timestamp' => now()->toDateTimeString()
]);

$metrics = Http::asJson()->post('https://awesome-application.com/overwatch', [
    'payload' => $newEncrypter->encrypt($payload),
])->json();
```

## Command
You can also retrieve metrics from the command line using the `overwatch:metrics` command.

```bash
php artisan overwatch:metrics
```

This will return a table response of all the metrics that are defined in your config.

```bash
+----------------+---------------------+
| Metric         | Value               |
+----------------+---------------------+
| php_version    | 8.0.3               |
| laravel_version| 8.40.0              |
| app_users      | 10                  |
+----------------+---------------------+
```

Or you can pass in the `--json` flag to get a json response.

```bash
php artisan overwatch:metrics --json
```

```json
{"php_version": "8.0.3", "laravel_version": "8.40.0", "app_users": 10}
```

## Testing

```bash
vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Modern Mcguire](https://github.com/modernmcguire)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
