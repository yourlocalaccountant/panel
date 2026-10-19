<?php

namespace Pterodactyl\Tests\Integration\Http\Controllers;

use Pterodactyl\Tests\TestCase;

class HealthControllerTest extends TestCase
{
    public function testHealthEndpointReturnsACompactReadyResponse(): void
    {
        $this->get('/healthz')
            ->assertOk()
            ->assertExactJson(['status' => 'ok']);
    }
}
