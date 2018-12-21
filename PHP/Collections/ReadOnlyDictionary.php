<?php
namespace PHP\Collections;

// Deprecate
\trigger_error( __NAMESPACE__ . "\\ReadOnlyDictionary is deprecated. Clone a Dictionary instance instead." );

/**
 * Defines a read only, unordered set of key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
class ReadOnlyDictionary extends ReadOnlyCollection
{
    
    /**
     * Create a new read-only Dictionary instance
     *
     * As entries are added to / removed from the dictionary, the changes will
     * be reflected here. To change that, simply clone() this after creation.
     *
     * @param Dictionary &$dictionary The dictionary to make read-only
     */
    public function __construct( Dictionary &$dictionary )
    {
        parent::__construct( $dictionary );
    }
    
    
    public function clone(): ReadOnlyCollection
    {
        return new self( $this->collection );
    }
}
