<?php
namespace PHP\Collections;

/**
 * Defines a mutable, unordered set of indexed values
 */
class Dictionary extends \PHP\Object implements Dictionary\iDictionary
{
    
    /**
     * The set of indexed values
     *
     * @var array
     */
    private $items;
    
    /**
     * Specifies the type requirement for all indexes
     *
     * @var string
     */
    private $indexType;
    
    /**
     * Specifies the type requirement for all values
     *
     * @var string
     */
    private $valueType;
    
    
    public function __construct( string $indexType = '', string $valueType = '' )
    {
        // Abort. Neither index nor value can be null.
        if ( 'null' === strtolower( $indexType )) {
            throw new \Exception( 'Dictionary indexes cannot be NULL' );
        }
        elseif ( 'null' === strtolower( $valueType )) {
            throw new \Exception( 'Dictionary values cannot be NULL' );
        }
        
        // Initialize properties
        $this->Clear();
        $this->indexType = $indexType;
        $this->valueType = $valueType;
    }
    
    
    public function Add( $index, $value )
    {
        if ( $this->HasIndex( $index )) {
            $index = null;
        }
        else {
            $index = $this->insert( $index, $value );
        }
        return $index;
    }
    
    
    public function Clear()
    {
        $this->items = [];
    }
    
    
    public function Clone(): iReadOnlyCollection
    {
        $clone = new static( $this->indexType, $this->valueType );
        $this->Loop( function( $index, $value, &$clone ) {
            $clone->Add( $index, $value );
        }, $clone );
        return $clone;
    }
    
    
    public function ConvertToArray(): array
    {
        return $this->items;
    }
    
    
    public function Count(): int
    {
        return count( $this->items );
    }
    
    
    public function Get( $index, $defaultValue = null )
    {
        $value = $defaultValue;
        if ( $this->HasIndex( $index )) {
            $value = $this->items[ $index ];
        }
        return $value;
    }
    
    
    public function HasIndex( $index ): bool
    {
        return (
            is( $index, $this->indexType ) &&
            array_key_exists( $index, $this->items )
        );
    }
    
    
    public function Loop( callable $function, &...$args )
    {
        $iterable   = new Iterable( $this->items );
        $parameters = array_merge( [ $function ], $args );
        return call_user_func_array( [ $iterable, 'Loop' ], $parameters );
    }
    
    
    public function Remove( $index )
    {
        unset( $this->items[ $index ] );
    }
    
    
    public function Update( $index, $value )
    {
        if ( $this->HasIndex( $index )) {
            $this->insert( $index, $value );
        }
        else {
            $index = null;
        }
        return $index;
    }
    
    
    /**
     * Store the value at the specified index
     *
     * Fails if the index or value doesn't match its type requirement
     *
     * @param mixed $index The index to store the value at
     * @param mixed $value The value to store
     * @return mixed The index or NULL on failure.
     */
    private function insert( $index, $value )
    {
        if (( '' !== $this->indexType ) && !is( $index, $this->indexType )) {
            trigger_error( 'The index does not match its type constraints' );
            $index = null;
        }
        elseif (( '' !== $this->valueType ) && !is( $value, $this->valueType )) {
            trigger_error( 'The value does not match its type constraints' );
            $index = null;
        }
        else {
            $this->items[ $index ] = $value;
        }
        return $index;
    }
}
