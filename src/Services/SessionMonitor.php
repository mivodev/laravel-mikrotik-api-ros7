<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Monitors active PPPoE and Hotspot session counts on RouterOS v7 via REST API.
 */
class SessionMonitor
{
    public function __construct(protected Client $client) {}

    public function getPppActiveCount(): int
    {
        return count($this->client->get('/rest/ppp/active'));
    }

    public function getHotspotActiveCount(): int
    {
        return count($this->client->get('/rest/ip/hotspot/active'));
    }
}
