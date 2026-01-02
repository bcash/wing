<?php

namespace App\Services\Wing;

use App\Libraries\Osc\OscClient;
use Exception;

/**
 * Discovery Service for WING OSC Tree
 * 
 * Enumerates the full OSC tree structure through recursive discovery.
 */
class Discovery
{
    private OscClient $oscClient;
    private array $discoveredTree = [];
    private int $maxDepth = 10;

    public function __construct(OscClient $oscClient, int $maxDepth = 10)
    {
        $this->oscClient = $oscClient;
        $this->maxDepth = $maxDepth;
    }

    /**
     * Discover the full OSC tree starting from root
     * 
     * @param string $rootPath Starting path (default: "/")
     * @return array Tree structure
     */
    public function discover(string $rootPath = '/'): array
    {
        $this->discoveredTree = [];
        $this->discoverRecursive($rootPath, 0);
        return $this->discoveredTree;
    }

    /**
     * Recursively discover tree structure
     */
    private function discoverRecursive(string $path, int $depth): void
    {
        if ($depth > $this->maxDepth) {
            return;
        }

        try {
            // Query for children
            $children = $this->oscClient->listChildren($path);
            
            if ($children === null || empty($children)) {
                // Leaf node - mark as empty object
                $this->setPath($path, []);
                return;
            }

            // Node with children - recurse
            $node = [];
            foreach ($children as $child) {
                $childPath = rtrim($path, '/') . '/' . $child;
                $this->discoverRecursive($childPath, $depth + 1);
                $node[$child] = $this->getPath($childPath) ?? [];
            }

            $this->setPath($path, $node);
        } catch (Exception $e) {
            // On error, mark as leaf
            $this->setPath($path, []);
        }
    }

    /**
     * Set path in tree structure
     */
    private function setPath(string $path, array $value): void
    {
        $parts = array_filter(explode('/', $path));
        
        if (empty($parts)) {
            $this->discoveredTree = $value;
            return;
        }

        $current = &$this->discoveredTree;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                $current[$part] = [];
            }
            $current = &$current[$part];
        }
        $current = $value;
    }

    /**
     * Get path from tree structure
     */
    private function getPath(string $path): ?array
    {
        $parts = array_filter(explode('/', $path));
        
        if (empty($parts)) {
            return $this->discoveredTree;
        }

        $current = $this->discoveredTree;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return null;
            }
            $current = $current[$part];
        }
        
        return $current;
    }

    /**
     * Get all discovered paths as flat list
     * 
     * @return array List of OSC paths
     */
    public function getAllPaths(): array
    {
        return $this->flattenTree($this->discoveredTree);
    }

    /**
     * Flatten tree structure to path list
     */
    private function flattenTree(array $tree, string $prefix = ''): array
    {
        $paths = [];
        
        foreach ($tree as $key => $value) {
            $path = $prefix . '/' . $key;
            $paths[] = $path;
            
            if (is_array($value) && !empty($value)) {
                $paths = array_merge($paths, $this->flattenTree($value, $path));
            }
        }
        
        return $paths;
    }
}

