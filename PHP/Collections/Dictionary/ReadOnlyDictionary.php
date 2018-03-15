<?php
namespace PHP\Collections\Dictionary;

use \PHP\Collections\Collection\ReadOnlyCollectionSpec;
use \PHP\Collections\Dictionary;
use PHP\Collections\Sequence\ReadOnlySequenceSpec;

/**
 * Defines a read only, unordered set of indexed values
 */
class ReadOnlyDictionary extends \PHP\Object implements ReadOnlyDictionarySpec
{
    
    /**
     * The dictionary instance
     *
     * @var \PHP\Collections\Dictionary
     */
    private $dictionary;
    
    
    /**
     * Create a new read-only Dictionary instance
     *
     * As entries are added to / removed from the dictionary, the changes will
     * be reflected here. To change that, simply clone() this after creation.
     *
     * @param Dictionary $dictionary The dictionary to make read-only
     */
    public function __construct( Dictionary &$dictionary )
    {
        $this->dictionary = $dictionary;
    }
    
    
    final public function clone(): ReadOnlyCollectionSpec
    {
        $dictionaryClone = $this->dictionary->clone();
        return new static( $dictionaryClone );
    }
    
    
    final public function convertToArray(): array
    {
        return $this->dictionary->convertToArray();
    }
    
    final public function count(): int
    {
        return $this->dictionary->count();
    }
    
    final public function get( $index, $defaultValue = null )
    {
        return $this->dictionary->get( $index, $defaultValue );
    }
    
    final public function getIndices(): ReadOnlySequenceSpec
    {
        return $this->dictionary->getIndices();
    }
    
    final public function getValues(): ReadOnlySequenceSpec
    {
        return $this->dictionary->getValues();
    }
    
    final public function hasIndex( $index ): bool
    {
        return $this->dictionary->hasIndex( $index );
    }
    
    final public function loop( callable $function, &...$args )
    {
        $args = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->dictionary, 'loop' ], $args );
    }
}
