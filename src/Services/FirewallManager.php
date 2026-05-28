<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Services;

use Mivo\MikrotikRos7\Client;

/**
 * Manages firewall rules and address-lists on RouterOS v7 via REST API.
 *
 * Supports dual-stack (IPv4 + IPv6 address-lists) for customer isolation.
 */
class FirewallManager
{
    public function __construct(protected Client $client) {}

    /**
     * @return array<int, array<string, string>>
     */
    public function getNatRules(): array
    {
        return $this->client->get('/rest/ip/firewall/nat');
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function addAddressList(string $list, string $address): array
    {
        return $this->client->put('/rest/ip/firewall/address-list', [
            'list' => $list,
            'address' => $address,
        ]);
    }

    /**
     * Remove an IPv4 address from a firewall address-list by finding its ID first.
     *
     * @return array<int, array<string, string>>
     */
    public function removeAddressList(string $list, string $address): array
    {
        $items = $this->client->get('/rest/ip/firewall/address-list', [
            'list' => $list,
            'address' => $address,
        ]);

        if (! empty($items) && isset($items[0]['.id'])) {
            return $this->client->delete("/rest/ip/firewall/address-list/{$items[0]['.id']}");
        }

        return [];
    }

    /**
     * Add an IPv6 address to a firewall address-list.
     *
     * @return array<int, array<string, string>>
     */
    public function addV6AddressList(string $list, string $address): array
    {
        return $this->client->put('/rest/ipv6/firewall/address-list', [
            'list' => $list,
            'address' => $address,
        ]);
    }

    /**
     * Remove an IPv6 address from a firewall address-list.
     *
     * @return array<int, array<string, string>>
     */
    public function removeV6AddressList(string $list, string $address): array
    {
        $items = $this->client->get('/rest/ipv6/firewall/address-list', [
            'list' => $list,
            'address' => $address,
        ]);

        if (! empty($items) && isset($items[0]['.id'])) {
            return $this->client->delete("/rest/ipv6/firewall/address-list/{$items[0]['.id']}");
        }

        return [];
    }
}
