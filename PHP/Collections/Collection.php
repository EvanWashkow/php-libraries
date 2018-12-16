<?php
namespace PHP\Collections;

use PHP\Types;
use PHP\Types\Models\Type;


/**
 * Defines an iterable set of mutable, key-value pairs
 * 
 * Nested foreach() loops are broken. Use $this->loop() instead. PHP does not
 * clone objects in foreach() loops, therefore, the cursor on the inside loop
 * messes up the one on the outside loop.
 *
 * @see PHP\Collections\Iterator
 */
abstract class Collection extends    \PHP\PHPObject
                          implements \SeekableIterator, ICollection
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


    /**
     * For each entry in the collection, invoke the callback function with the
     * key and value
     *
     * To break the loop, return a non-NULL value. This value will be
     * returned by loop().
     *
     * Variables can be bound the callback function via the `use` clause
     *
     * @param callable $function Callback function to execute for each entry
     * @return mixed NULL or the value returned by the callback function
     */
    final public function loop( callable $function )
    {
        // Variables
        $returnValue = null;
        
        // Stash outer loop position (if there is one)
        $outerLoopKey = null;
        if ( $this->valid() ) {
            $outerLoopKey = $this->key();
        }
        
        // Loop through each value, until the return value is not null
        $this->rewind();
        while ( $this->valid() ) {
            
            // Execute callback function
            $key         = $this->key();
            $value       = $this->current();
            $returnValue = call_user_func_array( $function, [ $key, $value ] );
            
            // Go to next entry or stop loop
            if ( null === $returnValue ) {
                $this->next();
            }
            else {
                break;
            }
        }
        
        // Restore outer loop position (if there is one)
        if ( null !== $outerLoopKey ) {
            try {
                $this->seek( $outerLoopKey );
            } catch ( \Exception $e ) {
                $this->rewind();
            }
        }
        
        return $returnValue;
    }


    final public function seek( $key )
    {
        if ( $this->hasKey( $key )) {
            
            // Variables
            $isFound = false;
            
            // Loop through each key, halting when the given key is found
            $this->rewind();
            while ( $this->valid() ) {
                if ( $this->key() === $key ) {
                    $isFound = true;
                    break;
                }
                $this->next();
            }
            
            // Error on invalid seek
            if ( !$isFound ) {
                $this->throwSeekError( $key );
            }
        }
        else {
            $this->throwSeekError( $key );
        }
    }


    /**
     * Throws an error when the seek position is not found
     *
     * @param mixed $key The key not found
     */
    protected function throwSeekError( $key )
    {
        throw new \OutOfBoundsException( 'Invalid seek position' );
    }


    final public function valid()
    {
        return $this->hasKey( $this->key() );
    }
}
