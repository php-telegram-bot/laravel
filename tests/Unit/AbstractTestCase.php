<?php

declare(strict_types=1);

namespace Tests\Unit;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use PhpTelegramBot\Laravel\ServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass(): string
    {
        return ServiceProvider::class;
    }
}
