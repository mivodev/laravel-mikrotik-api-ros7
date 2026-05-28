<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages NTP client and system clock on RouterOS v7 via REST API.
 */
class NtpManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getClientConfig(): array
    {
        return $this->client->get('/rest/system/ntp/client');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getClock(): array
    {
        return $this->client->get('/rest/system/clock');
    }
}
