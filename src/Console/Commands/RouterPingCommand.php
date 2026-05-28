<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7\Console\Commands;

use App\Models\Router;
use Illuminate\Console\Command;
use Mivo\LaravelMikrotikRos7\Facades\MikrotikRos7;

/**
 * Artisan command to ping and diagnose a Mikrotik RouterOS v7 connection.
 *
 * Supports DB ID lookup, option flags, or step-by-step interactive mode.
 */
class RouterPingCommand extends Command
{
    protected $signature = 'mivo:ros7-ping 
                            {router_id? : The database ID of the router to ping} 
                            {--host= : Manual Router IP or Hostname/Domain} 
                            {--username= : Manual API username} 
                            {--password= : Manual API password} 
                            {--port=443 : Manual API REST port}';

    protected $description = 'Ping and check Mikrotik RouterOS v7 REST API connection. Supports DB ID lookup, option flags, or step-by-step interactive mode.';

    public function handle(): int
    {
        $host = $this->option('host');
        $username = $this->option('username');
        $password = $this->option('password');
        $port = (int) $this->option('port');

        $routerId = $this->argument('router_id');

        if ($routerId !== null) {
            /** @var Router|null $router */
            $router = Router::find($routerId);

            if (! $router) {
                $this->error('Router not found in database!');

                return self::FAILURE;
            }

            $host = $router->vpn_assigned_ip;
            $username = $router->api_username;
            $password = $router->api_password;
            $port = $router->api_port ? (int) $router->api_port : 443;

            $this->info("Connecting using database Router '{$router->name}' ({$host})...");
        } elseif (empty($host)) {
            // Interactive Mode
            $this->info('No router_id or --host specified. Starting step-by-step interactive mode:');

            $host = $this->ask('1. Router Host/IP address');
            if (empty($host)) {
                $this->error('Host cannot be empty.');

                return self::FAILURE;
            }

            $username = $this->ask('2. API Username', 'admin');
            $password = $this->secret('3. API Password') ?? '';
            $port = (int) $this->ask('4. API Port', '443');
        } else {
            // Host is provided via --host flag
            $username = $username ?: 'admin';
            $password = $password ?: '';
            $this->info("Connecting to manual host {$host}:{$port}...");
        }

        try {
            $client = MikrotikRos7::connection([
                'host' => $host,
                'username' => $username,
                'password' => $password,
                'port' => $port,
            ]);

            $identity = $client->get('/rest/system/identity');
            $this->info('Successfully connected to RouterOS v7!');
            $this->comment('Identity: '.($identity[0]['name'] ?? $identity['name'] ?? 'Unknown'));

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to connect: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}

