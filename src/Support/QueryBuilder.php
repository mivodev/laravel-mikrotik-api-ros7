<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Support;

use Mivo\MikrotikRos7\Client;

/**
 * Fluent query builder for RouterOS v7 REST API.
 *
 * Translates Eloquent-style chaining into REST API query parameters.
 * Unlike ROS6 which uses socket command prefixes (?key, ~key),
 * ROS7 REST uses standard HTTP query strings for filtering.
 *
 * Usage:
 *   $builder = new QueryBuilder($client, '/rest/ip/hotspot/user');
 *   $result = $builder->where('profile', 'Premium-1M')
 *       ->select(['name', 'limit-uptime'])
 *       ->get();
 */
class QueryBuilder
{
    /**
     * @var array<string, string>
     */
    protected array $filters = [];

    /**
     * @var string|null
     */
    protected ?string $proplist = null;

    public function __construct(
        protected Client $client,
        protected string $endpoint
    ) {}

    /**
     * Add an exact-match query filter (translated to HTTP query param).
     */
    public function where(string $key, string $value): self
    {
        $this->filters[$key] = $value;

        return $this;
    }

    /**
     * Select specific attributes to return (.proplist).
     *
     * @param  array<int, string>  $attributes
     */
    public function select(array $attributes): self
    {
        $this->proplist = implode(',', $attributes);

        return $this;
    }

    /**
     * Execute the query via GET and return parsed results.
     *
     * @return array<int, array<string, string>>
     */
    public function get(): array
    {
        $params = $this->filters;

        if ($this->proplist !== null) {
            $params['.proplist'] = $this->proplist;
        }

        return $this->client->get($this->endpoint, $params);
    }
}
