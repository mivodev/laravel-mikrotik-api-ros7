<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages wireless interfaces and security profiles on RouterOS v7 via REST API.
 *
 * Note: ROS7 introduced the new "wifi" package alongside the legacy "wireless".
 * This manager targets the legacy path for backward compatibility.
 */
class WirelessManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getInterfaces(): array
    {
        return $this->client->get('/rest/interface/wireless');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getSecurityProfiles(): array
    {
        return $this->client->get('/rest/interface/wireless/security-profiles');
    }
}
