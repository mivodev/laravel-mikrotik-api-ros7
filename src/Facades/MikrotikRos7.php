<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Facades;

use Illuminate\Support\Facades\Facade;
use Mivo\LaravelMikrotikRos7\MikrotikManager;
use Mivo\MikrotikRos7\Client;

/**
 * @method static \Mivo\MikrotikRos7\Client connection(string|array|null $name = null)
 * @method static void purge(?string $name = null)
 * @method static string getDefaultConnection()
 * @method static bool connect(string $host, string $username = 'admin', string $password = '', int $port = 443)
 * @method static void disconnect()
 * @method static bool isConnected()
 * @method static array get(string $endpoint, array $params = [])
 * @method static array put(string $endpoint, array $payload = [])
 * @method static array patch(string $endpoint, array $payload = [])
 * @method static array post(string $endpoint, array $payload = [])
 * @method static array delete(string $endpoint, array $payload = [])
 * @method static array comm(string $command, array $params = [])
 *
 * @see MikrotikManager
 * @see Client
 */
class MikrotikRos7 extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'mikrotik.ros7';
    }
}
