<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages simple queues (bandwidth limiting) on RouterOS v7 via REST API.
 */
class QueueManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getSimpleQueues(): array
    {
        return $this->client->get('/rest/queue/simple');
    }

    /**
     * @param  array<string, string>  $data
     * @return array<int, array<string, string>>
     */
    public function addSimpleQueue(array $data): array
    {
        return $this->client->put('/rest/queue/simple', $data);
    }

    /**
     * Remove a simple queue by name (finds .id via GET filter, then DELETE).
     *
     * @return array<int, array<string, string>>
     */
    public function removeSimpleQueue(string $name): array
    {
        $queues = $this->client->get('/rest/queue/simple', ['name' => $name]);

        if (! empty($queues) && isset($queues[0]['.id'])) {
            return $this->client->delete("/rest/queue/simple/{$queues[0]['.id']}");
        }

        return [];
    }
}
