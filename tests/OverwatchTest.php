<?php

use Illuminate\Encryption\Encrypter;
use Modernmcguire\Overwatch\Metrics\LaravelVersion;
use Modernmcguire\Overwatch\Metrics\PhpVersion;
use Modernmcguire\Overwatch\Overwatch;

it('can check signature', function () {

    $secret = 'base64:'.base64_encode(Encrypter::generateKey(config('app.cipher')));
    config(['overwatch.secret' => $secret]);

    $overwatch = new Overwatch();
    $payload = json_encode(['timestamp' => now('UTC')->toDateTimeString()]);
    $convertedKey = base64_decode(substr(config('overwatch.secret'), strlen('base64:')));
    $encrypter = new Encrypter($convertedKey, config('app.cipher'));
    $encryptedPayload = $encrypter->encrypt($payload);

    $overwatch->checkSignature($encryptedPayload);

    // checkSignature aborts if it fails so it will never reach this point on failure.
    expect(true)->toBeTrue();
});

it('can get laravel version', function () {
    $controller = new LaravelVersion();

    $response = $controller->handle();

    expect($response)->toBe(app()->version());
});

it('can get php version', function () {
    $controller = new PhpVersion();

    $response = $controller->handle();

    expect($response)->toBe(phpversion());
});
