<?php

namespace Modernmcguire\Overwatch;

use App\Http\Controllers\Api\ApiController;
use Stripe\StripeClient;

class StripeDataController extends ApiController
{
    public string $key = 'stripe';

    /**
     * Gets specific data from Stripe.
     */
    public function handle(): string
    {
        if (! config('overwatch.services.stripe.secret')) {
            return $this->errorResponse([], 'Stripe secret key not set', 500);
        }

        // todo: put in global container?
        $stripe = new StripeClient(config('overwatch.services.stripe.secret'));

        $data = [];
        $data['charges'] = $stripe->charges->all();
        $data['customers'] = $stripe->customers->all();
        $data['balance_transactions'] = $stripe->balanceTransactions->all();

        return $this->successResponse($data);
    }
}
