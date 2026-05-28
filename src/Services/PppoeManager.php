<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages PPPoE secrets and active sessions on RouterOS v7 via REST API.
 */
class PppoeManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getActive(): array
    {
        return $this->client->get('/rest/ppp/active');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getSecrets(): array
    {
        return $this->client->get('/rest/ppp/secret');
    }

    /**
     * @param  array<string, string>  $data
     * @return array<int, array<string, string>>
     */
    public function addSecret(array $data): array
    {
        return $this->client->put('/rest/ppp/secret', $data);
    }

    /**
     * Remove a PPPoE secret by name (finds .id via GET filter, then DELETE).
     *
     * @return array<int, array<string, string>>
     */
    public function removeSecret(string $name): array
    {
        $secrets = $this->client->get('/rest/ppp/secret', ['name' => $name]);

        if (! empty($secrets) && isset($secrets[0]['.id'])) {
            return $this->client->delete("/rest/ppp/secret/{$secrets[0]['.id']}");
        }

        return [];
    }

    /**
     * Force disconnect an active PPPoE session by username.
     *
     * In ROS7 REST, removing an active session is done via DELETE on the .id.
     *
     * @return array<int, array<string, string>>
     */
    public function disconnect(string $name): array
    {
        $active = $this->client->get('/rest/ppp/active', ['name' => $name]);

        if (! empty($active) && isset($active[0]['.id'])) {
            return $this->client->delete("/rest/ppp/active/{$active[0]['.id']}");
        }

        return [];
    }
}
