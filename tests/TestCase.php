<?php

declare(strict_types=1);

namespace Stratos\Pegboard\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Stratos\Pegboard\PegboardServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            PegboardServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
