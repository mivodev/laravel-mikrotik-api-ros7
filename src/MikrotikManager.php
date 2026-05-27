<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7;

use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Mivo\MikrotikRos7\Client;

/**
 * Manages multiple Mikrotik RouterOS v7 REST API connections.
 */
class MikrotikManager
{
    /**
     * The application instance.
     */
    protected Application $app;

    /**
     * The active connection instances.
     *
     * @var array<string, Client>
     */
    protected array $connections = [];

    /**
     * Create a new manager instance.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get a Mikrotik connection instance.
     *
     * @param  string|array|null  $name  Connection name (string) or dynamic configuration (array).
     * @return Client
     */
    public function connection(string|array|null $name = null): Client
    {
        if (is_array($name)) {
            return $this->makeClient($name);
        }

        $name = $name ?: $this->getDefaultConnection();

        if (! isset($this->connections[$name])) {
            $this->connections[$name] = $this->makeConnection($name);
        }

        return $this->connections[$name];
    }

    /**
     * Make the Mikrotik connection instance.
     *
     * @param  string  $name
     * @return Client
     */
    protected function makeConnection(string $name): Client
    {
        $config = $this->configuration($name);

        return $this->makeClient($config);
    }

    /**
     * Build a Client instance from an array of configuration.
     *
     * @param  array  $config
     * @return Client
     */
    protected function makeClient(array $config): Client
    {
        if (empty($config['host']) || empty($config['username'])) {
            throw new InvalidArgumentException('Mikrotik connection must specify a host and username.');
        }

        $client = new Client();
        $client->timeout   = (int) ($config['timeout'] ?? 10);
        $client->verifySsl = (bool) ($config['verify_ssl'] ?? false);
        $client->debug     = (bool) ($config['debug'] ?? false);

        $client->connect(
            $config['host'],
            $config['username'],
            $config['password'] ?? '',
            (int) ($config['port'] ?? 443)
        );

        return $client;
    }

    /**
     * Get the configuration for a connection.
     *
     * @param  string  $name
     * @return array
     */
    protected function configuration(string $name): array
    {
        $connections = $this->app['config']['mikrotik-ros7.connections'];

        if (is_null($config = $connections[$name] ?? null)) {
            throw new InvalidArgumentException("Mikrotik connection [{$name}] not configured.");
        }

        return $config;
    }

    /**
     * Get the default connection name.
     *
     * @return string
     */
    public function getDefaultConnection(): string
    {
        return $this->app['config']['mikrotik-ros7.default'];
    }

    /**
     * Disconnect from the given connection and remove from cache.
     *
     * @param  string|null  $name
     * @return void
     */
    public function purge(?string $name = null): void
    {
        $name = $name ?: $this->getDefaultConnection();

        if (isset($this->connections[$name])) {
            $this->connections[$name]->disconnect();
            unset($this->connections[$name]);
        }
    }

    /**
     * Dynamically pass methods to the default connection.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->connection()->$method(...$parameters);
    }
}
