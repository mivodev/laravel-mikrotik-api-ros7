<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages IP routes on RouterOS v7 via REST API.
 *
 * Supports dual-stack (IPv4 + IPv6 routing).
 */
class RouteManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getRoutes(): array
    {
        return $this->client->get('/rest/ip/route');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function addRoute(string $dstAddress, string $gateway): array
    {
        return $this->client->put('/rest/ip/route', [
            'dst-address' => $dstAddress,
            'gateway' => $gateway,
        ]);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getV6Routes(): array
    {
        return $this->client->get('/rest/ipv6/route');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function addV6Route(string $dstAddress, string $gateway): array
    {
        return $this->client->put('/rest/ipv6/route', [
            'dst-address' => $dstAddress,
            'gateway' => $gateway,
        ]);
    }
}
