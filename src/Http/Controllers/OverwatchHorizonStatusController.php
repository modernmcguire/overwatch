<?php

namespace Modernmcguire\Overwatch\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modernmcguire\Overwatch\Metrics\HorizonStatus;

class OverwatchHorizonStatusController extends OverwatchController
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->checkSignature($request->payload);

        $horizonStatus = new HorizonStatus;

        $status = array_merge($horizonStatus->handle(), [
            'site' => config('app.url'),
        ]);

        return response()->json($status);
    }
}
