<?php
namespace PHP\Collections;

/**
 * Defines a set of mutable, key-value pairs
 */
abstract class Collection extends Iterator implements CollectionSpec
{
    
    /**
     * Type requirement for all keys
     *
     * @var string
     */
    private $keyType;
    
    /**
     * Type requirement for all values
     *
     * @var string
     */
    private $valueType;
    
    
    /**
     * Create a new Collection
     *
     * @param string $keyType Specifies the type requirement for all keys (see `is()`). An empty string permits all types. Must be 'string' or 'integer'.
     * @param string $valueType Specifies the type requirement for all values (see `is()`). An empty string permits all types.
     */
    public function __construct( string $keyType = '', string $valueType = '' )
    {
        if ( 'null' === strtolower( $keyType )) {
            throw new \Exception( 'Key types cannot be NULL' );
        }
        else if ( 'null' === strtolower( $keyType )) {
            throw new \Exception( 'Value types cannot be NULL' );
        }
        
        $this->keyType   = $keyType;
        $this->valueType = $valueType;
    }
    
    
    public function getKeys(): SequenceSpec
    {
        $keys = new Sequence( $this->keyType );
        $this->loop( function( $key, $value, Sequence &$keys ) {
            $keys->add( $key );
        }, $keys );
        return $keys;
    }
    
    
    public function getValues(): SequenceSpec
    {
        $values = new Sequence( $this->valueType );
        $this->loop( function( $key, $value, Sequence &$values ) {
            $values->add( $value );
        }, $values );
        return $values;
    }
    
    
    public function hasKey( $key ): bool
    {
        $hasKey = false;
        if ( $this->isValidKeyType( $key )) {
            $this->loop( function( $i, $value, $key, &$hasKey ) {
                if ( $i === $key ) {
                    $hasKey = true;
                    return $hasKey;
                }
            }, $key, $hasKey );
        }
        return $hasKey;
    }
    
    
    public function isValidKeyType( $key ): bool
    {
        return (
            ( null !== $key ) &&
            (
                ( '' === $this->keyType ) ||
                is( $key, $this->keyType )
            )
        );
    }
    
    
    public function isValidValueType( $value ): bool
    {
        return (( '' === $this->valueType ) || is( $value, $this->valueType ));
    }
}
