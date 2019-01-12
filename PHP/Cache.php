<?php
namespace PHP;

use PHP\Collections\Dictionary;

/**
 * Caches and retrieves items from system memory
 */
class Cache extends Dictionary
{
    
    /**
     * Are the items in this cache complete?
     *
     * @var bool
     */
    private $isComplete;


    /**
     * Create a new system-memory cache
     *
     * @param string $keyType   Type requirement for keys. '*' allows all types.
     * @param string $valueType Type requirement for values. '*' allows all types.
     * @param array  $entries   Initial entries [ key => value ]
     */
    public function __construct( string $keyType,
                                 string $valueType,
                                 array  $entries )
    {
        parent::__construct( $keyType, $valueType, $entries );
        $this->markIncomplete();
    }
    
    
    
    
    /***************************************************************************
    *                                CACHE STATUS
    ***************************************************************************/
    
    
    /**
     * Has this cache been marked complete?
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     *
     * @return bool
     */
    final public function isComplete(): bool
    {
        return $this->isComplete;
    }
    
    
    /**
     * Mark cache as complete
     *
     * Useful for flagging an interative cache as "complete", to prevent further
     * lookups.
     */
    final public function markComplete()
    {
        $this->isComplete = true;
    }
    
    
    /**
     * Mark cache as incomplete
     *
     * Useful for flagging an interative cache as "incomplete", meaning there
     * are still items to fetch
     */
    final public function markIncomplete()
    {
        $this->isComplete = false;
    }
}
