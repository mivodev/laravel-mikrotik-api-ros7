<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages RouterOS system users and groups on RouterOS v7 via REST API.
 */
class RouterUserManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getUsers(): array
    {
        return $this->client->get('/rest/user');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getGroups(): array
    {
        return $this->client->get('/rest/user/group');
    }
}
