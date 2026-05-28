<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages system identity, resources, and power control on RouterOS v7 via REST API.
 */
class SystemManager
{
    public function __construct(protected Client $client) {}

    public function getIdentity(): string
    {
        $res = $this->client->get('/rest/system/identity');

        return $res[0]['name'] ?? $res['name'] ?? 'Unknown';
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getResources(): array
    {
        return $this->client->get('/rest/system/resource');
    }

    /**
     * Reboot is a non-CRUD action → POST in ROS7 REST.
     */
    public function reboot(): void
    {
        $this->client->post('/rest/system/reboot');
    }
}
