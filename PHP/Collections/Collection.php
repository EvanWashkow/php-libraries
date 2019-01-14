<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Collections\Collection\AnonymousType;
use PHP\Types;
use PHP\Types\Models\Type;
use PHP\Types\TypeNames;


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
                          implements \Countable, \Iterator
{


    /***************************************************************************
    *                               PROPERTIES
    ***************************************************************************/

    /** @var Type $keyType Type requirement for all keys */
    private $keyType;

    /** @var Type $valueType Type requirement for all values */
    private $valueType;




    /***************************************************************************
    *                              CONSTRUCTOR
    ***************************************************************************/


    /**
     * Create a new Collection
     * 
     * Throws exception when key or value type is NULL or unknown.
     *
     * @param string $keyType   Type requirement for keys. '*' allows all types.
     * @param string $valueType Type requirement for values. '*' allows all types.
     * @param array  $entries   Initial entries [ key => value ]
     * @throws \InvalidArgumentException On bad key / value type
     */
    public function __construct( string $keyType,
                                 string $valueType,
                                 array  $entries   = [] )
    {
        // Lookup key type
        if ( in_array( $keyType, [ '', '*' ] )) {
            $this->keyType = $this->createAnonymousKeyType();
        }
        else {
            $this->keyType = Types::GetByName( $keyType );
        }

        // Lookup value type
        if ( in_array( $valueType, [ '', '*' ] )) {
            $this->valueType = $this->createAnonymousValueType();
        }
        else {
            $this->valueType = Types::GetByName( $valueType );
        }

        // Throw exception on invalid key type
        switch ( $this->getKeyType()->getName() ) {
            case TypeNames::NULL:
                throw new \InvalidArgumentException( 'Key type cannot be "null"' );
                break;
            
            case TypeNames::UNKNOWN:
                throw new \InvalidArgumentException( "Key type \"{$keyType}\" does not exist" );
                break;
            
            default:
                break;
        }

        // Throw exception on invalid value type
        switch ( $this->getValueType()->getName() ) {
            case TypeNames::NULL:
                throw new \InvalidArgumentException( 'Value type cannot be "null"' );
                break;
            
            case TypeNames::UNKNOWN:
                throw new \InvalidArgumentException( "Value type \"{$valueType}\" does not exist" );
                break;
            
            default:
                break;
        }

        // For each initial entry, add it to this collection
        foreach ( $entries as $key => $value ) {
            $this->set( $key, $value );
        }
    }


    /**
     * Create an anonymous key type
     * 
     * @internal This allows the child class to customize the anonymous type to
     * allow / prevent certain types.
     *
     * @return AnonymousType
     **/
    protected function createAnonymousKeyType(): AnonymousType
    {
        return new Collection\AnonymousKeyType();
    }


    /**
     * Create an anonymous value type
     * 
     * @internal This allows the child class to customize the anonymous type to
     * allow / prevent certain types.
     *
     * @return AnonymousType
     **/
    protected function createAnonymousValueType(): AnonymousType
    {
        return new Collection\AnonymousType();
    }




    /***************************************************************************
    *                                 ABSTRACT
    ***************************************************************************/

    /**
     * Remove all entries
     *
     * @return bool
     */
    abstract public function clear(): bool;


    /**
     * Retrieve the number of entries in the collection
     *
     * @return int
     **/
    abstract public function count(): int;

    /**
     * Retrieve the value
     * 
     * Throws an exception if the key does not exist
     *
     * @param mixed $key The key to retrieve the value from
     * @return mixed The value if the key exists. NULL otherwise.
     * @throws \InvalidArgumentException Key doesn't exist
     */
    abstract public function get( $key );

    /**
     * Retrieve all keys
     * 
     * @internal There's no way to write an optimal solution for this (using
     * toArray()) without also making it incorrect.
     *
     * @return Sequence
     */
    abstract public function getKeys(): Sequence;

    /**
     * Determine if the key exists
     * 
     * @internal There's no way to write a solution for this (using toArray())
     * without also making it incorrect.
     *
     * @param mixed $key The key to check for
     * @return bool
     */
    abstract public function hasKey( $key ): bool;

    /**
     * Remove key (and its corresponding value) from this collection
     *
     * @param mixed $key The key to remove the value from
     * @return bool Whether or not the operation was successful
     */
    abstract public function remove( $key ): bool;

    /**
     * Store the value at the key
     *
     * Adds a new key or updates existing. Rejects entry if key or value aren't
     * the right type, returning false.
     *
     * @param mixed $key The key to store the value at
     * @param mixed $value The value to store
     * @return bool Whether or not the operation was successful
     */
    abstract public function set( $key, $value ): bool;

    /**
     * Convert to a native PHP array
     * 
     * @return array
     */
    abstract public function toArray(): array;
    
    
    
    
    /***************************************************************************
    *                      ITERATOR INTERFACE OVERRIDES
    ***************************************************************************/


    /**
     * Deprecated
     */
    final public function seek( $key )
    {
        trigger_error( 'Collection->seek() is deprecated', E_USER_DEPRECATED );
    }


    /**
     * @see Iterator->valid()
     */
    final public function valid(): bool
    {
        return $this->hasKey( $this->key() );
    }




    /***************************************************************************
    *                                   CLONE
    ***************************************************************************/


    /**
     * Invoked on shallow collection clone
     **/
    public function __clone()
    {
        // Reset cursor to the beginning
        $this->rewind();
    }


    /**
     * Creates a new Collection that is a copy of the current instance
     *
     * @return static
     */
    public function clone(): Collection
    {
        return ( clone $this );
    }




    /***************************************************************************
    *                                 OWN METHODS
    ***************************************************************************/


    /**
     * Retrieve the key of the first value found
     * 
     * Throws exception when key not found. This *always* has to be handled by
     * the caller, even if a default value was returned. Throwing an exception
     * provides more information to the caller about what happened.
     *
     * @param mixed $value The value to find
     * @return mixed The key
     * @throws \Exception When key not found
     */
    public function getKeyOf( $value )
    {
        // Throw exception for wrong value type
        if ( !$this->getValueType()->equals( $value ) ) {
            throw new \InvalidArgumentException( 'Wrong value type' );
        }

        // Search for the value
        $key = array_search( $value, $this->toArray(), true );

        // Throw exception for key not found
        if ( false === $key ) {
            throw new \Exception( 'Key not found' );
        }

        // Return the key
        return $key;
    }


    /**
     * Retrieve key type
     * 
     * @return Type
     **/
    final public function getKeyType(): Type
    {
        return $this->keyType;
    }


    /**
     * Retrieve all values
     *
     * @return Sequence
     */
    public function getValues(): Sequence
    {
        return new Sequence(
            $this->getValueType()->getName(),
            array_values( $this->toArray() )
        );
    }


    /**
     * Retrieve value type
     * 
     * @return Type
     **/
    final public function getValueType(): Type
    {
        return $this->valueType;
    }


    /**
     * Determine if the value exists
     * 
     * @internal Because $type->equals() is slow for class types, it's actually
     * just faster to check the array directly.
     *
     * @param mixed $value The value to check for
     * @return bool
     */
    final public function hasValue( $value ): bool
    {
        $hasValue;
        try {
            $this->getKeyOf( $value );
            $hasValue = true;
        }
        catch ( \Throwable $th ) {
            $hasValue = false;
        }
        return $hasValue;
    }


    /**
     * Deprecated
     */
    final public function isOfKeyType( $key ): bool
    {
        trigger_error( 'isOfKeyType() is deprecated. Use getKeyType() instead.', E_USER_DEPRECATED );
        return $this->getKeyType()->equals( $key );
    }


    /**
     * Deprecated
     */
    final public function isOfValueType( $value ): bool
    {
        trigger_error( 'isOfValueType() is deprecated. Use getValueType() instead.', E_USER_DEPRECATED );
        return ( $this->getValueType()->equals( $value ) );
    }


    /**
     * Invoke the callback function for each entry in the collection, passing
     * the key and value for each.
     *
     * Callback function requires two parameters (the key and the value), and
     * must return a boolean value to continue iterating: "true" to continue,
     * "false" to break/stop the loop.
     * To access variables outside the callback function, specify a "use" clase:
     * function() use ( $outerVar ) { $outerVar; }
     * 
     * Throws an exception if the callback function does not return a boolean
     * 
     * @internal Type hint of Closure. This type hint should execute slightly
     * faster than the "callable" pseudo-type. Also, users **should** be using
     * closures rather than hard-coded, public functions. Doing this needlessly
     * dirties class namespaces, and should be discouraged.
     * 
     * @internal Do not use iterator_apply(). It is at least twice as slow as this.
     *
     * @param \Closure $function Callback functiouse theuse then to execute for each entry
     * @return void
     * @throws \TypeError If the callback does not return a boolean value
     */
    final public function loop( \Closure $function )
    {
        // Loop through each value, until the end of the collection is reached,
        // or caller wants to stop the loop
        $collection = clone $this;
        while ( $collection->valid() ) {
            
            // Execute callback function
            $key            = $collection->key();
            $value          = $collection->current();
            $shouldContinue = $function( $key, $value );
            
            // Handle return value
            if ( true === $shouldContinue ) {
                $collection->next();
            }
            elseif ( false === $shouldContinue ) {
                break;
            }
            else {
                throw new \TypeError( 'Collection->loop() callback function did not return a boolean value' );
            }
        }
    }
}
