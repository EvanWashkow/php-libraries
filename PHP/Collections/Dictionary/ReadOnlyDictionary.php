<?php
namespace PHP\Collections\Dictionary;

use \PHP\Collections\Collection\ReadOnlyCollectionSpec;
use \PHP\Collections\DictionarySpec;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a read only, unordered set of keyed values
 */
class ReadOnlyDictionary extends \PHP\PHPObject implements ReadOnlyDictionarySpec
{
    
    /**
     * The dictionary instance
     *
     * @var DictionarySpec
     */
    private $dictionary;
    
    
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
        $this->dictionary = $dictionary;
    }
    
    
    public function clone(): ReadOnlyCollectionSpec
    {
        $class           = get_class( $this );
        $dictionaryClone = $this->dictionary->clone();
        return new $class( $dictionaryClone );
    }
    
    
    public function convertToArray(): array
    {
        return $this->dictionary->convertToArray();
    }
    
    public function count(): int
    {
        return $this->dictionary->count();
    }
    
    public function get( $key )
    {
        return $this->dictionary->get( $key );
    }
    
    public function getKeys(): ReadOnlySequenceSpec
    {
        return $this->dictionary->getKeys();
    }
    
    public function getValues(): ReadOnlySequenceSpec
    {
        return $this->dictionary->getValues();
    }
    
    public function hasKey( $key ): bool
    {
        return $this->dictionary->hasKey( $key );
    }
    
    public function loop( callable $function, &...$args )
    {
        $args = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->dictionary, 'loop' ], $args );
    }
    
    
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function current()
    {
        return $this->dictionary->current();
    }
    
    final public function key()
    {
        return $this->dictionary->key();
    }
    
    final public function next()
    {
        $this->dictionary->next();
    }
    
    final public function rewind()
    {
        $this->dictionary->rewind();
    }
    
    final public function valid()
    {
        return $this->dictionary->valid();
    }
}
