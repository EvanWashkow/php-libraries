<?php
namespace PHP\Collections\Dictionary;

use \PHP\Object;

/**
 * Defines a read only, unordered set of indexed values
 */
class ReadOnlyDictionary extends \PHP\Object implements ReadOnlyDictionaryDefinition
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
     * @param string $indexType Specifies the type requirement for all indexes (see `is()`). An empty string permits all types.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     * @param array  $items     Indexed array of values for this dictionary
     */
    public function __construct( string $indexType = '',
                                 string $valueType = '',
                                 array  $items     = [] )
    {
        $this->dictionary = new \PHP\Collections\Dictionary( $indexType, $valueType );
        foreach ( $items as $index => $value ) {
            $this->dictionary->Add( $index, $value );
        }
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
