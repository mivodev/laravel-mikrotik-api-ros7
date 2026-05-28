<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages IP pools on RouterOS v7 via REST API.
 *
 * Supports dual-stack (IPv4 pools + IPv6 prefix pools).
 */
class IpPoolManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getAll(): array
    {
        return $this->client->get('/rest/ip/pool');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getUsedAddresses(): array
    {
        return $this->client->get('/rest/ip/pool/used');
    }

    /**
     * Get IPv6 prefix pools for customer delegation.
     *
     * @return array<int, array<string, string>>
     */
    public function getV6Pools(): array
    {
        return $this->client->get('/rest/ipv6/pool');
    }
}
