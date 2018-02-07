<?php
namespace PHP;

/**
 * Caches and retrieves items from system memory
 */
class Cache
{
    /**
     * Memory cache
     *
     * @var array
     */
    private $cache;
    
    
    /**
     * Create new cache instance
     */
    public function __construct()
    {
        $this->cache = [];
    }
}
