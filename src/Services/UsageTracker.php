<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Tracks interface-level bandwidth usage on RouterOS v7 via REST API.
 */
class UsageTracker
{
    public function __construct(protected Client $client) {}

    /**
     * Uses .proplist query parameter to only fetch rx-byte and tx-byte.
     *
     * @return array<int, array<string, string>>
     */
    public function getInterfaceStats(string $name): array
    {
        return $this->client->get('/rest/interface', [
            'name' => $name,
            '.proplist' => 'rx-byte,tx-byte',
        ]);
    }
}
