<?php

namespace Modernmcguire\Overwatch;

use Modernmcguire\Overwatch\Commands\OverwatchGenerate;
use Modernmcguire\Overwatch\Commands\OverwatchMetrics;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Modernmcguire\Overwatch\Commands\OverwatchSchedulerMonitor;

class OverwatchServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('overwatch')
            ->hasConfigFile()
            ->hasRoute('api')
            ->hasCommands([
                OverwatchGenerate::class,
                OverwatchMetrics::class,
                OverwatchSchedulerMonitor::class,
            ]);
    }
}
