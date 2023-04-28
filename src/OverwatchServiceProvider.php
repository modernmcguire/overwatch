<?php

namespace Modernmcguire\Overwatch;

use Modernmcguire\Overwatch\Commands\OverwatchCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommand(OverwatchCommand::class);
    }
}
