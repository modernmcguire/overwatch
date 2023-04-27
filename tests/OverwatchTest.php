<?php

use Illuminate\Encryption\Encrypter;
use Modernmcguire\Overwatch\Overwatch;
use Modernmcguire\Overwatch\LaravelVersion;

it('can check signature', function () {
    $overwatch = new Overwatch();
    $secret = Illuminate\Support\Str::random(32);

    config(['app.key' => $secret]);

    $newEncrypter = new Encrypter($secret, 'aes-256-cbc');
    $payload = json_encode(['timestamp' => now()->toDateTimeString()]);
    $encryptedPayload = $newEncrypter->encrypt($payload);

    $overwatch->checkSignature($secret, $encryptedPayload);

    // checkSignature aborts if it fails so it will never reach this point on failure.
    expect(true)->toBeTrue();
});

it('can get laravel version', function () {
    $laravelVersionController = new LaravelVersion();

    $response = $laravelVersionController->handle();

    expect($response)->toBeArray();
    expect($response['data'])->toBe(app()->version());
    expect($response['message'])->toBe('Success');
    expect($response['code'])->toBe(200);
});
