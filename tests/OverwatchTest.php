<?php

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;
use Modernmcguire\Overwatch\Overwatch;

it('can check signature', function () {
    $overwatch = new Overwatch();
    $cipher = strtolower(Config::get('app.cipher'));
    $supportedCiphers = [
        'aes-128-cbc' => ['size' => 16, 'aead' => false],
        'aes-256-cbc' => ['size' => 32, 'aead' => false],
        'aes-128-gcm' => ['size' => 16, 'aead' => true],
        'aes-256-gcm' => ['size' => 32, 'aead' => true],
    ];
    $secret = Illuminate\Support\Str::random($supportedCiphers[$cipher]['size']);

    config(['overwatch.secret' => $secret]);

    $newEncrypter = new Encrypter($secret, $cipher);
    $payload = json_encode(['timestamp' => now()->toDateTimeString()]);
    $encryptedPayload = $newEncrypter->encrypt($payload);

    $overwatch->checkSignature($secret, $encryptedPayload);

    // checkSignature aborts if it fails so it will never reach this point on failure.
    expect(true)->toBeTrue();
});
