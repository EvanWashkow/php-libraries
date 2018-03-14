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
     * @param string $type Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $type = '' )
    {
        parent::__construct( 'string', $type );
        $this->MarkIncomplete();
    }
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    
    final public function IsComplete()
    {
        return $this->isComplete;
    }
    
    
    final public function MarkComplete()
    {
        $this->isComplete = true;
    }
    
    
    final public function MarkIncomplete()
    {
        $this->isComplete = false;
    }
}
