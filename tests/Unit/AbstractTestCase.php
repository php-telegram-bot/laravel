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
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return ServiceProvider::class;
    }
}
