<?php

namespace Modernmcguire\Overwatch\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modernmcguire\Overwatch\Overwatch;

class OverwatchHorizonStatsController extends OverwatchController
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->checkSignature($request->payload);

        return response()->json(Overwatch::horizon());
    }
}
