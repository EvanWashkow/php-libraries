<?php
namespace PHP;

use PHP\Collections\Dictionary;

/**
 * Caches and retrieves items from system memory
 */
class Cache extends Dictionary implements CacheSpec
{
    
    /**
     * Are the items in this cache complete?
     *
     * @var bool
     */
    private $isComplete;
    
    
    /**
     * Create a new cache instance
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '', string $valueType = '' )
    {
        parent::__construct( $keyType, $valueType );
        $this->markIncomplete();
    }
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    
    final public function isComplete(): bool
    {
        return $this->isComplete;
    }
    
    
    final public function markComplete()
    {
        $this->isComplete = true;
    }
    
    
    final public function markIncomplete()
    {
        $this->isComplete = false;
    }
}
