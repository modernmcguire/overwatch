<?php

namespace Modernmcguire\Overwatch;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Modernmcguire\Overwatch\Commands\OverwatchCommand;

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
            ->hasViews()
            ->hasMigration('create_overwatch_table')
            ->hasCommand(OverwatchCommand::class);
    }
}
