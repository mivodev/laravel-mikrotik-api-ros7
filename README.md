![Laravel Mikrotik API ROS7](https://raw.githubusercontent.com/mivodev/.github/main/profile/assets/img/logo-banner.png)

# Laravel Mikrotik API ROS7

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-8892BF.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/laravel-%3E%3D10.0-FF2D20.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A clean, elegant Laravel wrapper for `mivodev/mikrotik-api-ros7`. Provides a ServiceProvider, Facade, configuration file, and Hybrid Connection Manager for seamless multi-tenant integration into your Laravel application.

## Installation

```bash
composer require mivodev/laravel-mikrotik-api-ros7
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=mikrotik-ros7-config
```

## Configuration

After publishing, you can configure your default router credentials in your `.env` file:

```env
MIKROTIK_ROS7_HOST=192.168.1.1
MIKROTIK_ROS7_USERNAME=admin
MIKROTIK_ROS7_PASSWORD=rahasia
MIKROTIK_ROS7_PORT=443
MIKROTIK_ROS7_VERIFY_SSL=false
MIKROTIK_ROS7_TIMEOUT=10
```

## Usage

### 1. REST-Native Service Managers (Sugar Syntax)
Unlike legacy socket APIs, ROS7 uses native REST calls. This package provides 22 REST-native service managers using clean HTTP verbs under the hood, with full IPv4 & IPv6 support:

```php
use Mivo\LaravelMikrotikRos7\Facades\MikrotikRos7;

// 1. Hotspot Management (REST GET / PUT)
$users = MikrotikRos7::hotspot()->getUsers();
MikrotikRos7::hotspot()->addUser([
    'name' => 'dyzulk',
    'password' => 'secret123',
    'profile' => 'Premium-1M'
]);

// 2. PPPoE Secret Management (REST GET / DELETE / POST)
$activeSessions = MikrotikRos7::pppoe()->getActive();
MikrotikRos7::pppoe()->disconnect('customer_123'); // Disconnects session by REST GET lookup + DELETE /rest/ppp/active/{.id}

// 3. Simple Queues (REST PUT)
MikrotikRos7::queue()->addSimpleQueue([
    'name' => 'customer_123_limit',
    'target' => '192.168.88.10',
    'max-limit' => '1M/2M'
]);

// 4. Dual-Stack IPv4 / IPv6 Support (REST endpoints)
MikrotikRos7::ipAddress()->addV6('2001:db8::1/64', 'ether1'); // REST PUT to /rest/ipv6/address
MikrotikRos7::firewall()->addV6AddressList('blocked', '2001:db8::2'); // REST PUT to /rest/ipv6/firewall/address-list
```

Available managers: `arp()`, `bridge()`, `dhcp()`, `dns()`, `firewall()`, `hotspot()`, `interfaces()`, `ipAddress()`, `ipPool()`, `ntp()`, `pppoe()`, `queue()`, `radius()`, `routes()`, `routerUsers()`, `scripts()`, `sessionMonitor()`, `syslog()`, `system()`, `usageTracker()`, `vpn()`, `wireless()`.

### 2. Fluent REST Query Builder
Query REST API resources using clean, fluent query strings instead of CLI parameters:

```php
$users = MikrotikRos7::query('/rest/ip/hotspot/user')
    ->where('profile', 'Premium-1M')
    ->select(['name', 'limit-uptime'])
    ->get();
```

### 3. Hybrid Multi-Tenant Connections
Perfect for SaaS applications (like Mivo Enterprise) where router credentials are retrieved dynamically from the database:

```php
use App\Models\Router;
use Mivo\LaravelMikrotikRos7\Facades\MikrotikRos7;

$router = Router::find(1);

// Establish dynamic connection from database model
$client = MikrotikRos7::connection([
    'host'       => $router->vpn_assigned_ip,
    'username'   => $router->api_username,
    'password'   => $router->api_password,
    'port'       => 443,
    'verify_ssl' => false,
]);

// Use any service manager on this specific router
$users = $client->hotspot()->getUsers();
```

---

## 4. Artisan Diagnosis Command
Diagnose and ping router connections easily using the Artisan tool:

```bash
# Ping using a database Router ID
php artisan mivo:ros7-ping 1
```

## License

MIT License. See [LICENSE](LICENSE) for details.