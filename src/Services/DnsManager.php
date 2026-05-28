<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages DNS configuration and static entries on RouterOS v7 via REST API.
 */
class DnsManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getConfig(): array
    {
        return $this->client->get('/rest/ip/dns');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getStatic(): array
    {
        return $this->client->get('/rest/ip/dns/static');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function addStatic(string $name, string $address): array
    {
        return $this->client->put('/rest/ip/dns/static', [
            'name' => $name,
            'address' => $address,
        ]);
    }
}
