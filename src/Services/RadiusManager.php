<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages RADIUS client configuration on RouterOS v7 via REST API.
 */
class RadiusManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getClients(): array
    {
        return $this->client->get('/rest/radius');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function addClient(string $address, string $secret, string $service = 'ppp'): array
    {
        return $this->client->put('/rest/radius', [
            'address' => $address,
            'secret' => $secret,
            'service' => $service,
        ]);
    }
}
