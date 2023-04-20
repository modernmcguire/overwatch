# OVERWATCH
This package allows you to configure a laravel site to send customizable JSON data when its `/overwatch` endpoint is requested.

## Installation

You can install the package via composer:

```bash
composer require modernmcguire/overwatch
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="overwatch-config"
```

This is the contents of the published config file:

```php
return [
    'secret' => env('OVERWATCH_SECRET'),
    'metrics' => [],
];
```

## Usage
Generate a secret that will save to your config file:
```bash
overwatch make:secret
```
Add custom classes to your overwatch config file

```php
return [
    'secret' => env('OVERWATCH_SECRET'),
    'metrics' => [
        StripeController::class,
        LmsController::class,
    ],
];
```
From the site you wish to pull data to, make requests to `/overwatch` and create a payload. Make sure both sites use the same cipher.
```php
$cipher = strtolower(Config::get('app.cipher'));
// Assumes you have stored overwatch's secret in the receiver's database.
$secret = Project::where('id', $projectId)->value('secret');
$newEncrypter = new Encrypter($secret, $cipher);
$payload = json_encode(['timestamp' => now()->toDateTimeString()]);
$encryptedPayload = $newEncrypter->encrypt($payload);
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
