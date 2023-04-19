<?php

namespace Modernmcguire\Overwatch\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modernmcguire\Overwatch\OverwatchServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Modernmcguire\\Overwatch\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            OverwatchServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_overwatch_table.php.stub';
        $migration->up();
        */
    }
}
