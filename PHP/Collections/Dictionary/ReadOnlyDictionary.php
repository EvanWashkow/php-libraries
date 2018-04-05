<?php
namespace PHP\Collections\Dictionary;

use PHP\Collections\Collection\ReadOnlyCollection;
use PHP\Collections\DictionarySpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a read only, unordered set of keyed values
 */
class ReadOnlyDictionary extends ReadOnlyCollection implements ReadOnlyDictionarySpec
{
    
    /**
     * Create a new read-only Dictionary instance
     *
     * As entries are added to / removed from the dictionary, the changes will
     * be reflected here. To change that, simply clone() this after creation.
     *
     * @param DictionarySpec &$dictionary The dictionary to make read-only
     */
    public function __construct( DictionarySpec &$dictionary )
    {
        parent::__construct( $dictionary );
    }
    
    
    public function getKeys(): ReadOnlySequenceSpec
    {
        return $this->collection->getKeys();
    }
    
    public function getValues(): ReadOnlySequenceSpec
    {
        return $this->collection->getValues();
    }
}
