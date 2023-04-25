<?php

namespace Modernmcguire\Overwatch;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Overwatch
{
    public function index(Request $request)
    {
        $this->checkSignature($request->header('X-OVERWATCH-SECRET'), $request->getContent());

        $configs = config('overwatch.metrics');

        $response = [];

        if (empty($configs)) {
            return response()->json($response);
        }

        foreach ($configs as $config) {
            $class = new $config;
            try {
                $response[$class::KEY] = $class->handle();
            } catch (\Exception $e) {
                $response[$class::KEY] = [
                    'data'    => null,
                    'message' => $e->getMessage(),
                    'code'    => 500,
                ];
            }
        }
        return response()->json($response);
    }

    public function checkSignature(?string $theirSecret, ?string $encryptedPayload): void
    {

        if ($theirSecret === null) {
            abort(401, 'Missing secret.');
        }

        if ($encryptedPayload === null) {
            abort(401, 'Missing payload.');
        }

        $ourSecret = config('app.key');

        if (!$theirSecret || !$ourSecret) {
            abort(401, 'Invalid secret.');
        }

        try {
            // decrypt incoming data
            $decrypted = decrypt($encryptedPayload);
            $decryptedData = json_decode($decrypted);

            if (!isset($decryptedData->timestamp)) {
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
