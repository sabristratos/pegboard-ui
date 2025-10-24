<?php

declare(strict_types=1);

namespace Stratos\Pegboard\Tests\Unit;

use Stratos\Pegboard\PegboardServiceProvider;
use Stratos\Pegboard\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider_is_registered(): void
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertArrayHasKey(PegboardServiceProvider::class, $providers);
    }

    public function test_config_is_registered(): void
    {
        $this->assertNotNull(config('pegboard'));
        $this->assertIsArray(config('pegboard'));
    }

    public function test_config_has_expected_keys(): void
    {
        $this->assertArrayHasKey('prefix', config('pegboard'));
        $this->assertEquals('pegboard', config('pegboard.prefix'));
    }
}
