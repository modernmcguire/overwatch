<?php

namespace Modernmcguire\Overwatch\Http\Controllers;

use Exception;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modernmcguire\Overwatch\Overwatch;

class OverwatchController extends Controller
{
    const TZ = 'UTC';

    public function __invoke(Request $request): JsonResponse
    {
        $this->checkSignature($request->payload);

        return response()->json(Overwatch::run());
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

            $timestamp = Carbon::parse($decryptedData->timestamp)->tz(self::TZ);
            if ($timestamp->lt(now(self::TZ)) && $timestamp->subMinute()->gt(now(self::TZ))) {
                abort(401, 'Expired secret.');
            }
        } catch (\Exception $e) {
            abort(401, $e->getMessage());
        }
    }
}
