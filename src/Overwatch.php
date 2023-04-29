<?php

namespace Modernmcguire\Overwatch;

use Carbon\Carbon;
use Exception;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Overwatch
{
    public function index(Request $request): JsonResponse
    {
        $this->checkSignature($request->payload);

        $configs = config('overwatch.metrics');

        $response = [];

        if (empty($configs)) {
            return response()->json($response);
        }

        foreach ($configs as $config) {
            try {
                $class = new $config();
                $response[$class::KEY] = $class->handle();
            } catch (\Exception $e) {
                $response[$class::KEY] = $e->getMessage();
            }
        }

        return response()->json($response);
    }

    public function checkSignature(string $encryptedPayload): void
    {
        if (config('overwatch.secret') == null) {
            abort(401, 'Missing secret.');
        }

        try {
            $convertedKey = base64_decode(substr(config('overwatch.secret'), strlen('base64:')));
            $encrypter = new Encrypter($convertedKey, config('app.cipher'));
            $decrypted = $encrypter->decrypt($encryptedPayload);
        } catch (Exception $e) {
            abort(401, 'Invalid payload.');
        }

        try {
            // decrypt incoming data
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
