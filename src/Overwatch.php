<?php

namespace Modernmcguire\Overwatch;

use Carbon\Carbon;
use Exception;
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
        try {
            $decrypted = decrypt($encryptedPayload);
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
