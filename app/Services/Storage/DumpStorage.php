<?php

namespace App\Services\Storage;

use Illuminate\Support\Facades\File;
use Exception;

/**
 * Filesystem Storage Service for WING Dump Data
 * 
 * Manages JSON shard storage according to the filesystem contract:
 * - One logical object per file
 * - Files ≤ 32 KB
 * - UTF-8, pretty-printed, stable key ordering
 */
class DumpStorage
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
        $this->ensureDirectoryStructure();
    }

    /**
     * Ensure directory structure exists
     */
    private function ensureDirectoryStructure(): void
    {
        $directories = [
            $this->basePath,
            $this->basePath . '/domains',
            $this->basePath . '/domains/ch',
            $this->basePath . '/domains/bus',
            $this->basePath . '/domains/aux',
            $this->basePath . '/domains/fx',
            $this->basePath . '/domains/dca',
            $this->basePath . '/domains/main',
            $this->basePath . '/domains/cfg',
            $this->basePath . '/domains/$ctl',
            $this->basePath . '/domains/misc',
            $this->basePath . '/raw',
        ];

        foreach ($directories as $dir) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }
    }

    /**
     * Save metadata file
     */
    public function saveMeta(array $metadata): void
    {
        $this->saveJson('meta.json', $metadata);
    }

    /**
     * Save index (tree structure)
     */
    public function saveIndex(array $index): void
    {
        $this->saveJson('index.json', $index);
    }

    /**
     * Save coverage report
     */
    public function saveCoverage(array $coverage): void
    {
        $this->saveJson('coverage.json', $coverage);
    }

    /**
     * Save errors
     */
    public function saveErrors(array $errors): void
    {
        $this->saveJson('errors.json', $errors);
    }

    /**
     * Save domain dump file
     * 
     * @param string $domain Domain name (ch, bus, aux, etc.)
     * @param string $filename Filename (e.g., "ch_01.json")
     * @param array $data Domain data
     */
    public function saveDomainFile(string $domain, string $filename, array $data): void
    {
        $path = "domains/{$domain}/{$filename}";
        $this->saveJson($path, $data);
    }

    /**
     * Save raw dump file
     * 
     * @param string $filename Filename
     * @param array $data Raw data
     */
    public function saveRawFile(string $filename, array $data): void
    {
        $path = "raw/{$filename}";
        $this->saveJson($path, $data);
    }

    /**
     * Check if domain file exists (for resume functionality)
     */
    public function domainFileExists(string $domain, string $filename): bool
    {
        $path = $this->basePath . "/domains/{$domain}/{$filename}";
        return File::exists($path);
    }

    /**
     * Load metadata
     */
    public function loadMeta(): ?array
    {
        return $this->loadJson('meta.json');
    }

    /**
     * Load index
     */
    public function loadIndex(): ?array
    {
        return $this->loadJson('index.json');
    }

    /**
     * Load coverage
     */
    public function loadCoverage(): ?array
    {
        return $this->loadJson('coverage.json');
    }

    /**
     * Load errors
     */
    public function loadErrors(): ?array
    {
        return $this->loadJson('errors.json');
    }

    /**
     * Save JSON file with validation
     */
    private function saveJson(string $relativePath, array $data): void
    {
        $fullPath = $this->basePath . '/' . $relativePath;
        
        // Ensure directory exists
        $dir = dirname($fullPath);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Encode with pretty printing and stable key ordering
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
        
        if ($json === false) {
            throw new Exception("Failed to encode JSON for {$relativePath}: " . json_last_error_msg());
        }

        // Validate file size (32 KB limit)
        if (strlen($json) > 32768) {
            throw new Exception("File {$relativePath} exceeds 32 KB limit (" . strlen($json) . " bytes)");
        }

        // Write file atomically
        $tempPath = $fullPath . '.tmp';
        File::put($tempPath, $json);
        File::move($tempPath, $fullPath);
    }

    /**
     * Load JSON file
     */
    private function loadJson(string $relativePath): ?array
    {
        $fullPath = $this->basePath . '/' . $relativePath;
        
        if (!File::exists($fullPath)) {
            return null;
        }

        $content = File::get($fullPath);
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode JSON from {$relativePath}: " . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Get base path
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }
}

