<?php

namespace App\Console\Commands;

use App\Libraries\Osc\OscClient;
use Illuminate\Console\Command;

class WingPingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wping
                            {--ip= : Console IP address (defaults to config)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OSC connectivity to WING console by sending /? query';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $ip = $this->option('ip') ?: config('wing.default_ip');
        $port = config('wing.default_port', 2223);

        if (empty($ip)) {
            $this->error('IP address is required. Use --ip=192.168.8.200 or set WING_IP in .env');
            return Command::FAILURE;
        }

        $this->info("Testing OSC connectivity to {$ip}:{$port}...");
        $this->line("Query: /? (console identification)");
        $this->line("");

        try {
            $oscClient = new OscClient($ip, $port, 9000, 2);
            $oscClient->connect();

            $this->line("Socket bound to port: " . $oscClient->getLocalPort());
            $this->line("Sending query: /?");
            $this->line("");

            $startTime = microtime(true);
            $response = $oscClient->send('/?');
            $elapsed = round((microtime(true) - $startTime) * 1000, 2);

            if ($response === null) {
                $this->error('❌ No response from console');
                $this->warn('');
                $this->warn('Possible issues:');
                $this->warn('  • macOS firewall blocking UDP replies (check with: sudo /usr/libexec/ApplicationFirewall/socketfilterfw --getglobalstate)');
                $this->warn('  • Console not responding to /? query');
                $this->warn('  • Network/firewall blocking UDP port 2223');
                $this->warn('');
                $this->warn('Try: php test_osc.php (minimal test script)');
                return Command::FAILURE;
            }

            // For /? query, /* path is the identification response, not an error
            $consoleInfo = $response->getFirstString();
            
            if ($response->isError() && $consoleInfo === null) {
                $this->error('❌ Console returned error: ' . $response->getErrorMessage());
                return Command::FAILURE;
            }

            $this->info('✅ OSC is working!');
            $this->line('');
            $this->line("Response time: {$elapsed}ms");
            
            if ($consoleInfo !== null) {
                $this->line("Console info: {$consoleInfo}");
            } else {
                $this->line("Response: " . json_encode($response->toArray(), JSON_PRETTY_PRINT));
            }

            $this->line('');
            $this->info('OSC remote control is active and responding.');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
