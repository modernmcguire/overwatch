<?php

namespace Modernmcguire\Overwatch;

use Illuminate\Support\Str;

class Overwatch
{
    public static function run()
    {
        return (new Overwatch)->process(config('overwatch.metrics'));
    }

    public static function horizon()
    {
        return (new Overwatch)->process(config('overwatch.horizon'));
    }

    public function process($configs = []): array
    {
        if (empty($configs)) {
            return [];
        }

        $data = [];

        foreach ($configs as $config) {
            $class = new $config();
            $key = defined($class::KEY) ? $class::KEY : Str::snake(class_basename($config));

            try {
                $data[$key] = $class->handle();
            } catch (\Exception $e) {
                $data[$key] = $e->getMessage();
                report($e);
            }
        }

        return $data;
    }
}
