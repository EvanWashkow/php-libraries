<?php
namespace PHP\Collections;

use PHP\Types;
use PHP\Types\Models\Type;


/**
 * Defines an iterable set of mutable, key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
abstract class Collection extends Iterator implements ICollection
{

    /** @var Type $keyType Type requirement for all keys */
    private $keyType;

    /** @var Type $valueType Type requirement for all values */
    private $valueType;
    
    
    /**
     * Create a new Collection
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '*', string $valueType = '*' )
    {
        // Lookup key type
        $keyType = trim( $keyType );
        if ( in_array( $keyType, [ '', '*' ] ) ) {
            $this->keyType = new Collection\WildcardKeyType();
        }
        else {
            $this->keyType = Types::GetByName( $keyType );
        }
        
        // Lookup value type
        $valueType = trim( $valueType );
        if ( in_array( $valueType, [ '', '*' ] ) ) {
            $this->valueType = new Collection\WildcardType();
        }
        else {
            $this->valueType = Types::GetByName( $valueType );
        }

        // Check for invalid types
        $keyType   = $this->getKeyType()->getName();
        $valueType = $this->getValueType()->getName();
        $invalidTypes = [
            'null',
            Types::GetUnknownType()->getName()
        ];
        if ( in_array( $keyType, $invalidTypes )) {
            throw new \InvalidArgumentException( "Key type cannot be {$keyType}" );
        }
        elseif ( in_array( $valueType, $invalidTypes )) {
            throw new \InvalidArgumentException( "Value type cannot be {$valueType}" );
        }
    }
    
    
    final public function getKeys(): Sequence
    {
        $keys = new Sequence( $this->getKeyType()->getName() );
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
        $values = new Sequence( $this->getValueType()->getName() );
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
        trigger_error( 'isOfKeyType() is deprecated. Use getKeyType() instead.' );
        return $this->getKeyType()->equals( $key );
    }
    
    
    final public function isOfValueType( $value ): bool
    {
        trigger_error( 'isOfValueType() is deprecated. Use getValueType() instead.' );
        return ( $this->getValueType()->equals( $value ) );
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
