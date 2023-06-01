<?php

namespace Modernmcguire\Overwatch\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modernmcguire\Overwatch\Overwatch;
use Modernmcguire\Overwatch\Metrics\HorizonStatus;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;

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
