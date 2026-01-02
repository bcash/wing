<?php

namespace App\Services\Wing;

use App\Libraries\Osc\OscClient;
use App\Libraries\Osc\OscResponse;
use App\Services\Storage\DumpStorage;
use Exception;

/**
 * Extraction Service for WING OSC Tree
 * 
 * Handles the extraction phase: dumping values using the safest method per node.
 */
class Extractor
{
    private OscClient $oscClient;
    private DumpStorage $storage;
    private DomainClassifier $classifier;
    private array $errors = [];
    private int $discoveredPaths = 0;
    private int $dumpedObjects = 0;
    private int $failed = 0;

    public function __construct(OscClient $oscClient, DumpStorage $storage, DomainClassifier $classifier)
    {
        $this->oscClient = $oscClient;
        $this->storage = $storage;
        $this->classifier = $classifier;
    }

    /**
     * Extract data from an OSC path
     * 
     * @param string $path OSC path
     * @param bool $resume Skip if file already exists
     * @return array|null Extracted data or null if skipped/failed
     */
    public function extract(string $path, bool $resume = false): ?array
    {
        $this->discoveredPaths++;

        $domain = $this->classifier->classify($path);
        $filename = $this->classifier->getFilename($path);

        // Check if we should skip (resume mode)
        if ($resume && $this->storage->domainFileExists($domain, $filename)) {
            return null;
        }

        // Try bulk dump first (preferred method)
        $data = $this->tryBulkDump($path);
        
        if ($data !== null) {
            $this->saveDomainFile($domain, $filename, $path, 'bulk', $data);
            $this->dumpedObjects++;
            return $data;
        }

        // Fallback to individual leaf queries
        $data = $this->tryLeafExtraction($path);
        
        if ($data !== null) {
            $this->saveDomainFile($domain, $filename, $path, 'leaf', $data);
            $this->dumpedObjects++;
            return $data;
        }

        // Mark as failed
        $this->recordError($path, 'extraction_failed');
        $this->failed++;
        return null;
    }

    /**
     * Try bulk dump method
     */
    private function tryBulkDump(string $path): ?array
    {
        try {
            $response = $this->oscClient->bulkDump($path);
            
            if ($response === null) {
                return null;
            }

            // Check for error response
            if ($response->isError()) {
                return null;
            }

            // Parse bulk response into key/value pairs
            return $this->parseBulkResponse($response);
        } catch (Exception $e) {
            $this->recordError($path, 'bulk_dump_exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Try leaf extraction (fallback)
     */
    private function tryLeafExtraction(string $path): ?array
    {
        try {
            // Get children
            $children = $this->oscClient->listChildren($path);
            
            if ($children === null || empty($children)) {
                return null;
            }

            $data = [];
            $raw = [];

            // Query each child individually
            foreach ($children as $child) {
                $childPath = rtrim($path, '/') . '/' . $child;
                $response = $this->oscClient->send($childPath);
                
                if ($response !== null && !$response->isError()) {
                    $normalized = $this->normalizeValue($response);
                    $data[$child] = $normalized['value'];
                    $raw[$child] = $normalized['raw'];
                }
            }

            return empty($data) ? null : ['data' => $data, 'raw' => $raw];
        } catch (Exception $e) {
            $this->recordError($path, 'leaf_extraction_exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Normalize value from OscResponse
     */
    private function normalizeValue(OscResponse $response): array
    {
        // Extract raw OSC args
        $raw = [
            'types' => $response->types,
            'args' => $response->args,
        ];

        // Prefer last numeric arg, or preserve string if no numeric exists
        $value = null;
        if (!empty($response->args)) {
            $args = array_reverse($response->args);
            foreach ($args as $arg) {
                if (is_numeric($arg)) {
                    $value = (float) $arg;
                    break;
                }
            }
            if ($value === null) {
                $value = $response->args[0] ?? null;
            }
        }

        return [
            'value' => $value,
            'raw' => $raw,
        ];
    }

    /**
     * Parse bulk response into structured data
     */
    private function parseBulkResponse(OscResponse $response): array
    {
        // WING bulk dump returns a single string with key=value,key=value format
        $bulkString = $response->getFirstString();
        
        if ($bulkString === null) {
            return ['data' => [], 'raw' => []];
        }

        // Parse key=value pairs
        $data = [];
        $pairs = explode(',', $bulkString);
        
        foreach ($pairs as $pair) {
            if (strpos($pair, '=') === false) {
                continue;
            }
            
            [$key, $value] = explode('=', $pair, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Try to convert to numeric if possible
            if (is_numeric($value)) {
                $data[$key] = (float) $value;
            } else {
                $data[$key] = $value;
            }
        }

        return [
            'data' => $data,
            'raw' => [
                'types' => $response->types,
                'args' => $response->args,
                'bulk_string' => $bulkString,
            ],
        ];
    }

    /**
     * Save domain file
     */
    private function saveDomainFile(string $domain, string $filename, string $path, string $method, array $data): void
    {
        $fileData = [
            'path' => $path,
            'method' => $method,
            'data' => $data['data'] ?? [],
            'raw' => $data['raw'] ?? [],
        ];

        $this->storage->saveDomainFile($domain, $filename, $fileData);
    }

    /**
     * Record error
     */
    private function recordError(string $path, string $error, int $attempts = 1): void
    {
        $this->errors[] = [
            'path' => $path,
            'error' => $error,
            'attempts' => $attempts,
        ];
    }

    /**
     * Get statistics
     */
    public function getStats(): array
    {
        $coverage = $this->discoveredPaths > 0 
            ? ($this->dumpedObjects / $this->discoveredPaths) * 100 
            : 0;

        return [
            'discovered_paths' => $this->discoveredPaths,
            'dumped_objects' => $this->dumpedObjects,
            'failed' => $this->failed,
            'coverage_percent' => round($coverage, 2),
        ];
    }

    /**
     * Get errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

