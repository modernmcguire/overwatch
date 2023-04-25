<?php

use Illuminate\Encryption\Encrypter;
use Modernmcguire\Overwatch\Overwatch;

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
