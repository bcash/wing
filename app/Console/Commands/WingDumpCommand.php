<?php

namespace App\Console\Commands;

use App\Libraries\Osc\OscClient;
use App\Services\Wing\Discovery;
use App\Services\Wing\DomainClassifier;
use App\Services\Wing\Extractor;
use App\Services\Storage\DumpStorage;
use Illuminate\Console\Command;
use Exception;

class WingDumpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wing:dump
                            {--ip= : Console IP address}
                            {--out=wing_dump : Output directory}
                            {--rate=15 : Requests per second}
                            {--resume : Skip completed files}
                            {--domains= : Optional domain filter (comma-separated)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the entire Behringer WING OSC tree into structured JSON files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $ip = $this->option('ip') ?: config('wing.default_ip');
        $out = $this->option('out') ?: config('wing.dump.default_output');
        $rate = (float) ($this->option('rate') ?: config('wing.default_rate'));
        $resume = $this->option('resume');
        $domainsFilter = $this->option('domains');

        // Validate IP
        if (empty($ip)) {
            $this->error('IP address is required. Use --ip=192.168.8.200 or set WING_IP in .env');
            return Command::FAILURE;
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $this->error("Invalid IP address: {$ip}");
            return Command::FAILURE;
        }

        // Parse domain filter
        $allowedDomains = null;
        if (!empty($domainsFilter)) {
            $allowedDomains = array_map('trim', explode(',', $domainsFilter));
        }

        try {
            $this->info("Connecting to WING console at {$ip}:2223...");
            
            // Initialize services
            // Calculate local port based on rate to avoid conflicts if multiple instances
            $localPort = 9000 + (int)($rate * 10);
            $oscClient = new OscClient($ip, 2223, $localPort, 2, $rate);
            $oscClient->connect();
            
            $storage = new DumpStorage($out);
            $classifier = new DomainClassifier();
            $discovery = new Discovery($oscClient);
            $extractor = new Extractor($oscClient, $storage, $classifier);

            // Save metadata
            $this->info('Saving metadata...');
            $storage->saveMeta([
                'console' => config('wing.console.model', 'Behringer WING'),
                'console_name' => config('wing.console.name', 'Unknown'),
                'firmware' => config('wing.console.firmware', 'unknown'),
                'wing_edit_version' => config('wing.console.wing_edit_version', 'unknown'),
                'ip' => $ip,
                'osc_port' => 2223,
                'generated_at' => now()->toIso8601String(),
                'tool_version' => '1.0.0',
            ]);

            // Phase 1: Discovery
            $this->info('Phase 1: Discovering OSC tree structure...');
            
            // Test connection first
            $this->info('Testing connection...');
            $testResponse = $oscClient->send('/?');
            if ($testResponse === null) {
                $this->warn('No response from console. Continuing anyway...');
            } else {
                $consoleInfo = $testResponse->getFirstString();
                if ($consoleInfo) {
                    $this->info('✓ Connected: ' . $consoleInfo);
                }
            }
            
            $tree = $discovery->discover();
            $storage->saveIndex($tree);
            $this->info('Tree structure discovered.');

            // Get all paths
            $allPaths = $discovery->getAllPaths();
            $this->info("Found " . count($allPaths) . " paths to extract.");

            // Filter by domain if specified
            if ($allowedDomains !== null) {
                $allPaths = array_filter($allPaths, function ($path) use ($classifier, $allowedDomains) {
                    return in_array($classifier->classify($path), $allowedDomains);
                });
                $this->info("Filtered to " . count($allPaths) . " paths in specified domains.");
            }

            // Phase 2-3: Classification and Extraction
            $this->info('Phase 2-3: Classifying and extracting data...');
            $bar = $this->output->createProgressBar(count($allPaths));
            $bar->start();
            
            foreach ($allPaths as $path) {
                $extractor->extract($path, $resume);
                $bar->advance();
            }
            
            $bar->finish();
            $this->newLine();

            // Phase 4-5: Persistence and Verification
            $this->info('Phase 4-5: Saving results and generating reports...');
            
            $stats = $extractor->getStats();
            $storage->saveCoverage($stats);
            
            $errors = $extractor->getErrors();
            $storage->saveErrors($errors);

            // Display results
            $this->info('Extraction complete!');
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Discovered Paths', $stats['discovered_paths']],
                    ['Dumped Objects', $stats['dumped_objects']],
                    ['Failed', $stats['failed']],
                    ['Coverage', $stats['coverage_percent'] . '%'],
                ]
            );

            if (!empty($errors)) {
                $this->warn("There were " . count($errors) . " errors. Check errors.json for details.");
            }

            $this->info("Output saved to: {$out}");

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
