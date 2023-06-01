<?php

namespace Modernmcguire\Overwatch\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modernmcguire\Overwatch\Overwatch;

class OverwatchHorizonStatsController extends OverwatchController
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->checkSignature($request->payload);

        return response()->json(Overwatch::horizon());
    }
}
