<?php

namespace Modernmcguire\Overwatch\Metrics;

abstract class Metric
{
    /**
     * The key to use for this metric. If null, the class name will be used in snake case.
     */
    const KEY = null;

    /**
     * Handle the metric.
     *
     * @return mixed
     */
    abstract public function handle();
}
