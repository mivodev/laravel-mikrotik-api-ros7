<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages logging rules and reads system logs on RouterOS v7 via REST API.
 */
class SyslogManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getLoggingRules(): array
    {
        return $this->client->get('/rest/system/logging');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getLogs(): array
    {
        return $this->client->get('/rest/log');
    }
}
