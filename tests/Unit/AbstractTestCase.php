<?php

declare(strict_types=1);

namespace Tests\Unit;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use PhpTelegramBot\Laravel\ServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return ServiceProvider::class;
    }
}
