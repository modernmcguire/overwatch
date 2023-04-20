<?php

it('can retrieve stripe data', function () {
    $stripeDataCon = new \Modernmcguire\Overwatch\StripeDataController();
    $data = $stripeDataCon->handle();
    expect($data)->toBeJson();
});
