<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages IP addresses on RouterOS v7 via REST API.
 *
 * Supports dual-stack (IPv4 + IPv6 address assignment).
 */
class IpAddressManager
{
    public function __construct(protected Client $client)
    {
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getAll(): array
    {
        return $this->client->get('/rest/ip/address');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function add(string $address, string $interface): array
    {
        return $this->client->put('/rest/ip/address', [
            'address' => $address,
            'interface' => $interface,
        ]);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getAllV6(): array
    {
        return $this->client->get('/rest/ipv6/address');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function addV6(string $address, string $interface): array
    {
        return $this->client->put('/rest/ipv6/address', [
            'address' => $address,
            'interface' => $interface,
        ]);
    }
}
