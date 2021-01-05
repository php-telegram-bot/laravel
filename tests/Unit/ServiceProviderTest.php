<?php

declare(strict_types=1);

namespace Tests\Unit;

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use Illuminate\Config\Repository;
use Illuminate\Database\DatabaseManager as Database;

class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    /**
     * @test
     */
    public function config_is_injectable(): void
    {
        $this->assertIsInjectable(Repository::class);
    }

    /**
     * @test
     */
    public function database_is_injectable(): void
    {
        $this->assertIsInjectable(Database::class);
    }

    /**
     * @todo Fix for "array" return type from parent "provides"
     *
     * @test
     */
    public function provides_(): void
    {
        $this->testProvides();
    }
}
