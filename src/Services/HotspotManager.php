<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages hotspot users, hosts, and active sessions on RouterOS v7 via REST API.
 */
class HotspotManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getActive(): array
    {
        return $this->client->get('/rest/ip/hotspot/active');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getHosts(): array
    {
        return $this->client->get('/rest/ip/hotspot/host');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getUsers(): array
    {
        return $this->client->get('/rest/ip/hotspot/user');
    }

    /**
     * @param  array<string, string>  $data
     * @return array<int, array<string, string>>
     */
    public function addUser(array $data): array
    {
        return $this->client->put('/rest/ip/hotspot/user', $data);
    }

    /**
     * Remove a hotspot user by name (finds .id via GET filter, then DELETE).
     *
     * @return array<int, array<string, string>>
     */
    public function removeUser(string $name): array
    {
        $users = $this->client->get('/rest/ip/hotspot/user', ['name' => $name]);

        if (! empty($users) && isset($users[0]['.id'])) {
            return $this->client->delete("/rest/ip/hotspot/user/{$users[0]['.id']}");
        }

        return [];
    }
}
