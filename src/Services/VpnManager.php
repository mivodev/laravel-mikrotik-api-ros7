<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages VPN tunnels (SSTP/L2TP/PPTP) on RouterOS v7 via REST API.
 */
class VpnManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getSstpServerConfig(): array
    {
        return $this->client->get('/rest/interface/sstp-server/server');
    }

    /**
     * Get active VPN tunnels filtered by SSTP service.
     *
     * @return array<int, array<string, string>>
     */
    public function getActiveTunnels(): array
    {
        return $this->client->get('/rest/ppp/active', ['service' => 'sstp']);
    }
}
