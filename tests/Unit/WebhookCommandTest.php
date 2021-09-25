<?php

declare(strict_types=1);

namespace Tests\Unit;

class WebhookCommandTest extends AbstractTestCase
{
    /** @test */
    public function it_can_set_webhook()
    {
        $this->markTestSkipped('Mock instead of live API calls');

        $this->artisan('telegram:webhook https://example.com/test')
            ->expectsOutput('Webhook set successfully!')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_show_webhook_info()
    {
        $this->markTestSkipped('Mock instead of live API calls');

        $this->artisan('telegram:webhook --info')
            ->expectsOutput('Current webhook info:')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_delete_webhook()
    {
        $this->markTestSkipped('Mock instead of live API calls');

        $this->artisan('telegram:webhook --delete')
            ->expectsOutput('Webhook deleted successfully!')
            ->assertExitCode(0);
    }
}
