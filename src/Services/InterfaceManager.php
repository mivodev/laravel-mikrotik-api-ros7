<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Monitors network interfaces and traffic on RouterOS v7 via REST API.
 */
class InterfaceManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getAll(): array
    {
        return $this->client->get('/rest/interface');
    }

    /**
     * Monitor traffic on a specific interface.
     *
     * ROS7 REST uses POST for real-time monitoring commands
     * (non-CRUD actions that don't map to standard HTTP verbs).
     *
     * @return array<int, array<string, string>>
     */
    public function getTraffic(string $interface): array
    {
        return $this->client->post('/rest/interface/monitor-traffic', [
            'interface' => $interface,
            'once' => '',
        ]);
    }
}
