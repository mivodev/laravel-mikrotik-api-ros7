<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Facades;

use Illuminate\Support\Facades\Facade;
use Mivo\LaravelMikrotikRos7\MikrotikManager;
use Mivo\LaravelMikrotikRos7\Services\ArpManager;
use Mivo\LaravelMikrotikRos7\Services\BridgeManager;
use Mivo\LaravelMikrotikRos7\Services\DhcpManager;
use Mivo\LaravelMikrotikRos7\Services\DnsManager;
use Mivo\LaravelMikrotikRos7\Services\FirewallManager;
use Mivo\LaravelMikrotikRos7\Services\HotspotManager;
use Mivo\LaravelMikrotikRos7\Services\InterfaceManager;
use Mivo\LaravelMikrotikRos7\Services\IpAddressManager;
use Mivo\LaravelMikrotikRos7\Services\IpPoolManager;
use Mivo\LaravelMikrotikRos7\Services\NtpManager;
use Mivo\LaravelMikrotikRos7\Services\PppoeManager;
use Mivo\LaravelMikrotikRos7\Services\QueueManager;
use Mivo\LaravelMikrotikRos7\Services\RadiusManager;
use Mivo\LaravelMikrotikRos7\Services\RouteManager;
use Mivo\LaravelMikrotikRos7\Services\RouterUserManager;
use Mivo\LaravelMikrotikRos7\Services\ScriptManager;
use Mivo\LaravelMikrotikRos7\Services\SessionMonitor;
use Mivo\LaravelMikrotikRos7\Services\SyslogManager;
use Mivo\LaravelMikrotikRos7\Services\SystemManager;
use Mivo\LaravelMikrotikRos7\Services\UsageTracker;
use Mivo\LaravelMikrotikRos7\Services\VpnManager;
use Mivo\LaravelMikrotikRos7\Services\WirelessManager;
use Mivo\LaravelMikrotikRos7\Support\QueryBuilder;
use Mivo\MikrotikRos7\Client;

/**
 * @method static Client connection(string|array|null $name = null)
 * @method static void purge(?string $name = null)
 * @method static string getDefaultConnection()
 * @method static QueryBuilder query(string $endpoint)
 * @method static ArpManager arp()
 * @method static BridgeManager bridge()
 * @method static DhcpManager dhcp()
 * @method static DnsManager dns()
 * @method static FirewallManager firewall()
 * @method static HotspotManager hotspot()
 * @method static InterfaceManager interfaces()
 * @method static IpAddressManager ipAddress()
 * @method static IpPoolManager ipPool()
 * @method static NtpManager ntp()
 * @method static PppoeManager pppoe()
 * @method static QueueManager queue()
 * @method static RadiusManager radius()
 * @method static RouteManager routes()
 * @method static RouterUserManager routerUsers()
 * @method static ScriptManager scripts()
 * @method static SessionMonitor sessionMonitor()
 * @method static SyslogManager syslog()
 * @method static SystemManager system()
 * @method static UsageTracker usageTracker()
 * @method static VpnManager vpn()
 * @method static WirelessManager wireless()
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
