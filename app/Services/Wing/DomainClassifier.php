<?php

namespace App\Services\Wing;

/**
 * Domain Classifier for WING OSC Paths
 * 
 * Classifies OSC paths into logical domains based on prefix rules.
 */
class DomainClassifier
{
    private const DOMAIN_MAP = [
        '/ch' => 'ch',
        '/bus' => 'bus',
        '/aux' => 'aux',
        '/fx' => 'fx',
        '/dca' => 'dca',
        '/main' => 'main',
        '/cfg' => 'cfg',
        '/$ctl' => '$ctl',
    ];

    /**
     * Classify an OSC path into a domain
     * 
     * @param string $path OSC path (e.g., "/ch/01/preamp/gain")
     * @return string Domain name (e.g., "ch")
     */
    public function classify(string $path): string
    {
        $path = rtrim($path, '/');
        
        // Check each domain prefix
        foreach (self::DOMAIN_MAP as $prefix => $domain) {
            if (strpos($path, $prefix) === 0) {
                return $domain;
            }
        }

        // Default to misc for unknown paths
        return 'misc';
    }

    /**
     * Get filename for a domain object
     * 
     * @param string $path OSC path
     * @return string Filename (e.g., "ch_01.json")
     */
    public function getFilename(string $path): string
    {
        $domain = $this->classify($path);
        
        // Extract identifier from path
        // e.g., "/ch/01" -> "ch_01"
        $parts = array_filter(explode('/', $path));
        $identifier = implode('_', array_slice($parts, 0, 2));
        
        // Sanitize for filesystem
        $identifier = preg_replace('/[^a-zA-Z0-9_]/', '_', $identifier);
        
        return $identifier . '.json';
    }

    /**
     * Get all known domains
     * 
     * @return array List of domain names
     */
    public function getDomains(): array
    {
        return array_values(self::DOMAIN_MAP);
    }
}

