<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages ARP table entries on RouterOS v7 via REST API.
 */
class ArpManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getAll(): array
    {
        return $this->client->get('/rest/ip/arp');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function add(string $address, string $macAddress, string $interface): array
    {
        return $this->client->put('/rest/ip/arp', [
            'address' => $address,
            'mac-address' => $macAddress,
            'interface' => $interface,
        ]);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function remove(string $id): array
    {
        return $this->client->delete("/rest/ip/arp/{$id}");
    }
}
