<?php
namespace PHP\Collections;

use PHP\Types;
use PHP\Types\Type;


/**
 * Defines an iterable set of mutable, key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
abstract class Collection extends Iterator implements ICollection
{
    
    /**
     * Type requirement for all keys
     *
     * @var string
     */
    private $keyTypeString;

    /** @var Type $keyType Type requirement for all keys */
    private $keyType;
    
    /**
     * Type requirement for all values
     *
     * @var string
     */
    private $valueTypeString;

    /** @var Type $valueType Type requirement for all values */
    private $valueType;
    
    
    /**
     * Create a new Collection
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '', string $valueType = '' )
    {
        // Lookup key type
        $keyType = trim( $keyType );
        if ( '' === $keyType ) {
            $this->keyType = new Collection\WildcardType();
        }
        else {
            $this->keyType = Types::GetByName( $keyType );
        }
        
        // Lookup value type
        $valueType = trim( $valueType );
        if ( '' === $valueType ) {
            $this->valueType = new Collection\WildcardType();
        }
        else {
            $this->valueType = Types::GetByName( $valueType );
        }
        
        // Check for invalid value types
        if ( 'null' === $this->keyType->getName() ) {
            throw new \InvalidArgumentException( 'Key types cannot be NULL' );
        }
        elseif ( 'null' === $this->valueType->getName() ) {
            throw new \InvalidArgumentException( 'Value types cannot be NULL' );
        }
        
        // Set properties
        $this->keyTypeString   = $keyType;
        $this->valueTypeString = $valueType;
    }
    
    
    final public function getKeys(): Sequence
    {
        $keys = new Sequence( $this->keyTypeString );
        $this->loop( function( $key, $value ) use ( &$keys ) {
            $keys->add( $key );
        });
        return $keys;
    }


    final public function getKeyType(): Type
    {
        return $this->keyType;
    }
    
    
    final public function getValues(): Sequence
    {
        $values = new Sequence( $this->valueTypeString );
        $this->loop( function( $key, $value ) use ( &$values ) {
            $values->add( $value );
        });
        return $values;
    }


    final public function getValueType(): Type
    {
        return $this->valueType;
    }
    
    
    final public function isOfKeyType( $key ): bool
    {
        return (
            ( null !== $key ) &&
            (
                ( '' === $this->keyTypeString ) ||
                is( $key, $this->keyTypeString )
            )
        );
    }
    
    
    final public function isOfValueType( $value ): bool
    {
        return (( '' === $this->valueTypeString ) || is( $value, $this->valueTypeString ));
    }
    
    
    
    
    /***************************************************************************
    *                              ITERATOR METHODS
    ***************************************************************************/
    
    final public function seek( $key )
    {
        if ( $this->hasKey( $key )) {
            parent::seek( $key );
        }
        else {
            $this->throwSeekError( $key );
        }
    }
    
    
    final public function valid()
    {
        return $this->hasKey( $this->key() );
    }
}
