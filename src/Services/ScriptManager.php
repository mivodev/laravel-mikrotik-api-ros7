<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages scripts and scheduler on RouterOS v7 via REST API.
 */
class ScriptManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getScripts(): array
    {
        return $this->client->get('/rest/system/script');
    }

    /**
     * Run a script by name.
     *
     * In ROS7 REST, running a script is a non-CRUD action → POST.
     *
     * @return array<int, array<string, string>>
     */
    public function runScript(string $name): array
    {
        return $this->client->post('/rest/system/script/run', ['number' => $name]);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getScheduler(): array
    {
        return $this->client->get('/rest/system/scheduler');
    }
}
