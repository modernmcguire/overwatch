<?php

use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;
use Modernmcguire\Overwatch\Overwatch;
use Illuminate\Support\Facades\Artisan;
use Modernmcguire\Overwatch\Metrics\PhpVersion;
use Modernmcguire\Overwatch\Metrics\LaravelVersion;

it('can run metrics', function () {
    config([
        'overwatch.metrics' => [
            PhpVersion::class,
            LaravelVersion::class,
        ],
    ]);

    $data = Overwatch::run();

    expect($data)->toHaveKey('laravel_version');
    expect($data['laravel_version'])->toBe(app()->version());

    expect($data)->toHaveKey('php_version');
    expect($data['php_version'])->toBe(phpversion());
});

it('can run metrics locally', function(){
    config([
        'overwatch.metrics' => [
            PhpVersion::class,
            LaravelVersion::class,
        ],
    ]);

    $this->artisan('overwatch:metrics')->assertExitCode(0);
});


it('can check signature', function () {

    // capture output of artisan call
    Artisan::call('overwatch:generate');
    $output = Artisan::output();

    $secret = Str::of($output)->after(': ')->trim()->toString();
    config(['overwatch.secret' => $secret]);

    $payload = json_encode(['timestamp' => now('UTC')->toDateTimeString()]);
    $convertedKey = base64_decode(substr(config('overwatch.secret'), strlen('base64:')));
    $encrypter = new Encrypter($convertedKey, config('app.cipher'));
    $encryptedPayload = $encrypter->encrypt($payload);

    $this->postJson(route('overwatch'), ['payload' => $encryptedPayload])->assertStatus(200);
});
