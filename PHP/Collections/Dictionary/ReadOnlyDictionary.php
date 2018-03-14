<?php
namespace PHP\Collections\Dictionary;

use \PHP\Collections\Dictionary;
use \PHP\Collections\Collection\ReadOnlyCollectionSpec;

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
     * be reflected here. To change that, simply Clone() this after creation.
     *
     * @param Dictionary $dictionary The dictionary to make read-only
     */
    public function __construct( Dictionary &$dictionary )
    {
        $this->dictionary = $dictionary;
    }
    
    
    final public function Clone(): ReadOnlyCollectionSpec
    {
        $dictionaryClone = $this->dictionary->Clone();
        return new static( $dictionaryClone );
    }
    
    
    final public function ConvertToArray(): array
    {
        return $this->dictionary->ConvertToArray();
    }
    
    final public function Count(): int
    {
        return $this->dictionary->Count();
    }
    
    final public function Get( $index, $defaultValue = null )
    {
        return $this->dictionary->Get( $index, $defaultValue );
    }
    
    final public function HasIndex( $index ): bool
    {
        return $this->dictionary->HasIndex( $index );
    }
    
    final public function Loop( callable $function, &...$args )
    {
        $args = array_merge( [ $function ], $args );
        return call_user_func_array( [ $this->dictionary, 'Loop' ], $args );
    }
}
