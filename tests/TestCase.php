<?php

namespace Magutti\MaguttiSpatial\Tests;

use Magutti\MaguttiSpatial\MaguttiSpatialServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Register the package service provider so config('magutti-spatial.*')
     * and the builder are available inside tests.
     */
    protected function getPackageProviders($app): array
    {
        return [
            MaguttiSpatialServiceProvider::class,
        ];
    }
}
