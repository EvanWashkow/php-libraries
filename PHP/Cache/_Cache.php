<?php
namespace PHP\Cache;

/**
 * Defines a structure for all Cache implementations
 */
abstract class _Cache
{
    /**
     * Create new cache instance
     *
     * @param array $items Key => value item pairs
     * @param bool  $markCacheComplete After setting items, mark the cache complete
     */
    abstract public function __construct( array $items = [], bool $markCacheComplete = false );
    
    
    /***************************************************************************
    *                             CACHE OPERATIONS
    ***************************************************************************/
    
    /**
     * Add cached value; fails if key already exists
     *
     * @param int|string $key   Key to store the value at
     * @param mixed      $value The value to store
     * @return int|string Sanitized key. NULL on failure.
     */
    abstract public function add( $key, $value );
    
    
    /**
     * Clear the cache
     *
     * Restores cache to its initial, default state.
     */
    abstract public function clear();
    
    
    /**
     * Remove an item from the cache
     *
     * @param int|string $key Key the value is stored at
     * @return mixed Sanitized key. NULL on failure.
     */
    abstract public function delete( $key );
    
    
    /**
     * Retrieve cached value(s)
     *
     * @param int|string $key Key the value is stored at
     * @return mixed Array if $key is NULL
     */
    abstract public function get( $key = NULL );
    
    
    /**
     * Add or replace cached value
     *
     * @param int|string $key   Key to store the value at
     * @param mixed      $value The value to store
     * @return int|string Sanitized key. NULL on failure.
     */
    abstract public function update( $key, $value );
    
    
    /**
     * Set all the cache items
     *
     * @param array $items             Key => value item pairs
     * @param bool  $markCacheComplete After setting items, mark the cache complete
     */
    abstract public function set( array $items, bool $markCacheComplete = true );
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    /**
     * Is the cache key set?
     *
     * Does not check to see if $value is NULL: NULL is considered valid.
     *
     * @param int|string $key Key to store the value at
     * @return bool
     */
    abstract public function isSet( $key );
    
    
    /**
     * Has this cache been marked complete?
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     *
     * @return bool
     */
    abstract public function isComplete();
    
    
    /**
     * Mark cache as complete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    abstract public function markComplete();
    
    
    /**
     * Mark cache as incomplete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    abstract public function markIncomplete();
    
    
    /***************************************************************************
    *                                STATIC HELPERS
    ***************************************************************************/
    
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
