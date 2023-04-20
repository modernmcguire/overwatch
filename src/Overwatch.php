<?php

namespace Modernmcguire\Overwatch;

use Carbon\Carbon;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Overwatch
{
    public function index(Request $request): JsonResponse
    {
        $this->checkSignature($request->headers('X-OVERWATCH-SECRET'), $request->getData());

        $configs = config('overwatch.metrics');

        $response = [];

        if (empty($configs)) {
            return json_encode($response);
        }

        foreach ($configs as $config) {
            $class = new $config;
            $response[] = $class->handle();
        }

        return response()->json($response);
    }

    public function checkSignature(string $theirSecret, string $encryptedPayload): void
    {
        $ourSecret = config('overwatch.secret');

        if (! $theirSecret || ! $ourSecret) {
            abort(401, 'Invalid secret.');
        }

        // create new encrypter with our secret
        $newEncrypter = new Encrypter($ourSecret, Config::get('app.cipher'));

         try {
            // decrypt incoming data
            $decrypted = $newEncrypter->decrypt($encryptedPayload);
            $decryptedData = json_decode($decrypted);

            if (! isset($decryptedData->timestamp)) {
                abort(401, 'Missing timestamp.');
            }

            $timestamp = Carbon::parse($decryptedData->timestamp);
            if ($timestamp->lt(now()) && $timestamp->subMinute()->gt(now())) {
                abort(401, 'Expired secret.');
            }
        } catch (\Exception $e) {
            abort(401, $e->getMessage());
        }
    }
}
