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
    protected $cache;
    
    
    /**
     * Create new cache instance
     */
    public function __construct()
    {
        $this->cache = [];
    }
    
    
    /**
     * Cache new item, overwriting previous key value
     *
     * @param int|string $key   Key to store the value at
     * @param mixed      $value The value to store
     * @return int|string Sanitized key. NULL on failure.
     */
    public function update( $key, $value )
    {
        $key = self::sanatizeKey( $key );
        if ( isset( $key )) {
            $this->cache[ $key ] = $value;
        }
        return $key;
    }
    
    
    /**
     * Sanitize the cache key
     *
     * @param mixed $key The cache key
     * @return mixed NULL will be returned if invalid
     */
    final protected static function sanatizeKey( $key )
    {
        $type = gettype( $key );
        
        // Sanatize strings; attempting to convert strings to integers
        if ( 'string' == $type ) {
            $key = trim( $key );
            if ( 0 !== intval( $key )) {
                $key = intval( $key );
            }
            elseif ( '0' == $key ) {
                $key = 0;
            }
            elseif ( '' == $key ) {
                $key = NULL;
            }
        }
        
        // Set key as invalid
        elseif ( 'integer' != $type ) {
            $key = NULL;
        }
        
        return $key;
    }
}
