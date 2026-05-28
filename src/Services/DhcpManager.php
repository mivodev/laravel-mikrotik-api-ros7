<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages DHCP server leases on RouterOS v7 via REST API.
 *
 * Supports dual-stack (IPv4 leases + IPv6 DHCPv6 bindings).
 */
class DhcpManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getLeases(): array
    {
        return $this->client->get('/rest/ip/dhcp-server/lease');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function makeStatic(string $macAddress, string $ipAddress): array
    {
        return $this->client->put('/rest/ip/dhcp-server/lease', [
            'mac-address' => $macAddress,
            'address' => $ipAddress,
        ]);
    }

    /**
     * Get DHCPv6 server bindings for IPv6 address allocation.
     *
     * @return array<int, array<string, string>>
     */
    public function getV6Bindings(): array
    {
        return $this->client->get('/rest/ipv6/dhcp-server/binding');
    }
}
