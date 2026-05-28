<?php

declare(strict_types=1);

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

// =========================================================
// Class Existence: Ensure all classes autoload correctly
// =========================================================

test('all 22 service manager classes exist', function () {
    expect(class_exists(ArpManager::class))->toBeTrue()
        ->and(class_exists(BridgeManager::class))->toBeTrue()
        ->and(class_exists(DhcpManager::class))->toBeTrue()
        ->and(class_exists(DnsManager::class))->toBeTrue()
        ->and(class_exists(FirewallManager::class))->toBeTrue()
        ->and(class_exists(HotspotManager::class))->toBeTrue()
        ->and(class_exists(InterfaceManager::class))->toBeTrue()
        ->and(class_exists(IpAddressManager::class))->toBeTrue()
        ->and(class_exists(IpPoolManager::class))->toBeTrue()
        ->and(class_exists(NtpManager::class))->toBeTrue()
        ->and(class_exists(PppoeManager::class))->toBeTrue()
        ->and(class_exists(QueueManager::class))->toBeTrue()
        ->and(class_exists(RadiusManager::class))->toBeTrue()
        ->and(class_exists(RouteManager::class))->toBeTrue()
        ->and(class_exists(RouterUserManager::class))->toBeTrue()
        ->and(class_exists(ScriptManager::class))->toBeTrue()
        ->and(class_exists(SessionMonitor::class))->toBeTrue()
        ->and(class_exists(SyslogManager::class))->toBeTrue()
        ->and(class_exists(SystemManager::class))->toBeTrue()
        ->and(class_exists(UsageTracker::class))->toBeTrue()
        ->and(class_exists(VpnManager::class))->toBeTrue()
        ->and(class_exists(WirelessManager::class))->toBeTrue();
});

test('query builder class exists', function () {
    expect(class_exists(QueryBuilder::class))->toBeTrue();
});

// =========================================================
// Manager: Method accessibility
// =========================================================

test('manager has all 22 service accessor methods and query', function () {
    $methods = [
        'arp', 'bridge', 'dhcp', 'dns', 'firewall', 'hotspot',
        'interfaces', 'ipAddress', 'ipPool', 'ntp', 'pppoe', 'queue',
        'radius', 'routes', 'routerUsers', 'scripts', 'sessionMonitor',
        'syslog', 'system', 'usageTracker', 'vpn', 'wireless', 'query',
    ];

    foreach ($methods as $method) {
        expect(method_exists(MikrotikManager::class, $method))
            ->toBeTrue("Method '{$method}' not found on MikrotikManager");
    }
});

// =========================================================
// Service Managers: Correct ROS7 REST API (get/put/patch/post/delete)
// =========================================================

test('service managers accept ros7 client via constructor', function () {
    $client = Mockery::mock(Client::class);

    $arp = new ArpManager($client);
    $hotspot = new HotspotManager($client);
    $system = new SystemManager($client);

    expect($arp)->toBeInstanceOf(ArpManager::class)
        ->and($hotspot)->toBeInstanceOf(HotspotManager::class)
        ->and($system)->toBeInstanceOf(SystemManager::class);
});

test('arp manager uses GET /rest/ip/arp for listing', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->with('/rest/ip/arp')
        ->once()
        ->andReturn([['address' => '192.168.1.1', 'mac-address' => 'AA:BB:CC:DD:EE:FF']]);

    $result = (new ArpManager($client))->getAll();

    expect($result)->toBeArray()
        ->and($result[0]['address'])->toBe('192.168.1.1');
});

test('arp manager uses PUT /rest/ip/arp for adding', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('put')
        ->with('/rest/ip/arp', [
            'address' => '10.0.0.1',
            'mac-address' => '11:22:33:44:55:66',
            'interface' => 'ether1',
        ])
        ->once()
        ->andReturn([]);

    $result = (new ArpManager($client))->add('10.0.0.1', '11:22:33:44:55:66', 'ether1');
    expect($result)->toBeArray();
});

test('arp manager uses DELETE /rest/ip/arp/{id} for removal', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('delete')
        ->with('/rest/ip/arp/*1')
        ->once()
        ->andReturn([]);

    $result = (new ArpManager($client))->remove('*1');
    expect($result)->toBeArray();
});

test('hotspot manager uses REST GET/PUT verbs', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->with('/rest/ip/hotspot/user')
        ->once()
        ->andReturn([['name' => 'test-user']]);

    $client->shouldReceive('put')
        ->with('/rest/ip/hotspot/user', ['name' => 'new-user', 'password' => '123'])
        ->once()
        ->andReturn([]);

    $hotspot = new HotspotManager($client);
    expect($hotspot->getUsers())->toBeArray();
    expect($hotspot->addUser(['name' => 'new-user', 'password' => '123']))->toBeArray();
});

test('system manager uses POST for reboot (non-CRUD action)', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('post')
        ->with('/rest/system/reboot')
        ->once()
        ->andReturn([]);

    (new SystemManager($client))->reboot();

    // Mockery verifies POST was called — not comm()
    expect(true)->toBeTrue();
});

test('interface manager uses POST for monitor-traffic', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('post')
        ->with('/rest/interface/monitor-traffic', [
            'interface' => 'ether1',
            'once' => '',
        ])
        ->once()
        ->andReturn([['rx-bits-per-second' => '1000']]);

    $result = (new InterfaceManager($client))->getTraffic('ether1');
    expect($result[0]['rx-bits-per-second'])->toBe('1000');
});

test('script manager uses POST to run scripts', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('post')
        ->with('/rest/system/script/run', ['number' => 'my-script'])
        ->once()
        ->andReturn([]);

    (new ScriptManager($client))->runScript('my-script');
    expect(true)->toBeTrue();
});

test('firewall manager supports ipv6 via REST PUT', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('put')
        ->with('/rest/ipv6/firewall/address-list', [
            'list' => 'blocked',
            'address' => '2001:db8::1/128',
        ])
        ->once()
        ->andReturn([]);

    $result = (new FirewallManager($client))->addV6AddressList('blocked', '2001:db8::1/128');
    expect($result)->toBeArray();
});

test('query builder uses REST GET with query params (not comm)', function () {
    $client = Mockery::mock(Client::class);
    $client->shouldReceive('get')
        ->with('/rest/ip/hotspot/user', [
            'profile' => 'Premium-1M',
            '.proplist' => 'name,limit-uptime',
        ])
        ->once()
        ->andReturn([['name' => 'dyzulk']]);

    $result = (new QueryBuilder($client, '/rest/ip/hotspot/user'))
        ->where('profile', 'Premium-1M')
        ->select(['name', 'limit-uptime'])
        ->get();

    expect($result)->toBeArray()
        ->and($result[0]['name'])->toBe('dyzulk');
});

test('all service managers depend on ros7 client type', function () {
    $managers = [
        ArpManager::class, BridgeManager::class, DhcpManager::class,
        DnsManager::class, FirewallManager::class, HotspotManager::class,
    ];

    foreach ($managers as $managerClass) {
        $reflection = new ReflectionClass($managerClass);
        $param = $reflection->getConstructor()->getParameters()[0];
        expect($param->getType()->getName())->toBe(Client::class,
            "Expected {$managerClass} constructor to accept ".Client::class
        );
    }
});

test('manager throws on invalid connection name', function () {
    $app = app();
    $app['config']->set('mikrotik-ros7.connections', []);

    (new MikrotikManager($app))->connection('nonexistent');
})->throws(InvalidArgumentException::class);

test('manager throws on empty host config', function () {
    $app = app();
    (new MikrotikManager($app))->connection(['host' => '', 'username' => '']);
})->throws(InvalidArgumentException::class);
