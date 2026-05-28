<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages bridge interfaces and ports on RouterOS v7 via REST API.
 */
class BridgeManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getBridges(): array
    {
        return $this->client->get('/rest/interface/bridge');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getPorts(): array
    {
        return $this->client->get('/rest/interface/bridge/port');
    }
}
