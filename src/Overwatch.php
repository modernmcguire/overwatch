<?php

namespace Modernmcguire\Overwatch;

use Illuminate\Support\Str;

class Overwatch
{
    public static function run()
    {
        $configs = config('overwatch.metrics');
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
