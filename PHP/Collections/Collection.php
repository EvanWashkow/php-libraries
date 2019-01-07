<?php
declare( strict_types = 1 );

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
                          implements \Countable, \SeekableIterator
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
    public function __construct( string $keyType   = '*',
                                 string $valueType = '*',
                                 array  $entries   = [] )
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

        // For each initial entry, add it to this collection
        foreach ( $entries as $key => $value ) {
            $this->set( $key, $value );
        }
    }




    /***************************************************************************
    *                                MAGIC METHODS
    ***************************************************************************/


    /**
     * Invoked on shallow collection clone
     **/
    final public function __clone()
    {
        // Reset cursor to the beginning
        $this->rewind();
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
     * Remove an entry
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
     * @see Iterator->seek()
     */
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


    /**
     * @see Iterator->valid()
     */
    final public function valid(): bool
    {
        return $this->hasKey( $this->key() );
    }




    /***************************************************************************
    *                                 OWN METHODS
    ***************************************************************************/


    /**
     * Creates a new Collection that is a copy of the current instance
     *
     * @return static
     */
    final public function clone(): Collection
    {
        return ( clone $this );
    }


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
        $key = array_search( $value, $this->toArray(), true );
        if ( false === $key ) {
            throw new \Exception( 'Key not found' );
        }
        return $key;
    }


    /**
     * Retrieve all keys
     *
     * @return Sequence
     */
    public function getKeys(): Sequence
    {
        $keys = new Sequence( $this->getKeyType()->getName() );
        $this->loop( function( $key, $value ) use ( &$keys ) {
            $keys->add( $key );
            return true;
        });
        return $keys;
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
        $values = new Sequence( $this->getValueType()->getName() );
        $this->loop( function( $key, $value ) use ( &$values ) {
            $values->add( $value );
            return true;
        });
        return $values;
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
     * Determine if the key exists
     * 
     * @internal Essentially, executes array_key_exists() on toArray().
     * array_key_exists() requires a string or an integer (see warning when
     * passing an object). Checking this first is drastically faster.
     *
     * @param mixed $key The key to check for
     * @return bool
     */
    public function hasKey( $key ): bool
    {
        return (
            ( is_int( $key ) || is_string( $key ) ) &&
            $this->getKeyType()->equals( $key )     &&
            array_key_exists( $key, $this->toArray() )
        );
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
        trigger_error( 'isOfKeyType() is deprecated. Use getKeyType() instead.' );
        return $this->getKeyType()->equals( $key );
    }


    /**
     * Deprecated
     */
    final public function isOfValueType( $value ): bool
    {
        trigger_error( 'isOfValueType() is deprecated. Use getValueType() instead.' );
        return ( $this->getValueType()->equals( $value ) );
    }


    /**
     * Invoke the callback function for each entry in the collection.
     *
     * Callback function requires two parameters: 1) the key and 2) the value.
     * Callback function must return a boolean value: "true" to continue,
     * "false" to break/stop the loop.
     * To access variables outside the callback function, use the "use" clase:
     * function() use ( $outerVar ) { $outerVar; }
     * 
     * Throws an exception if the callback function does not return a boolean
     * 
     * @internal Type hint of Closure. This type hint should execute slightly
     * faster than the "callable" pseudo-type. Also, users **should** be using
     * closures rather than hard-coded, public functions. Doing this needlessly
     * dirties class namespaces, and should be discouraged.
     *
     * @param \Closure $function Callback function to execute for each entry
     * @return void
     * @throws \TypeError If the callback does not return a boolean value
     */
    final public function loop( \Closure $function )
    {
        // Stash outer loop position (if there is one)
        $outerLoopKey = null;
        if ( $this->valid() ) {
            $outerLoopKey = $this->key();
        }
        
        // Loop through each value, until the return value is not null
        $this->rewind();
        while ( $this->valid() ) {
            
            // Execute callback function
            $key            = $this->key();
            $value          = $this->current();
            $shouldContinue = $function( $key, $value );
            
            // Handle return value
            if ( true === $shouldContinue ) {
                $this->next();
            }
            elseif ( false === $shouldContinue ) {
                break;
            }
            else {
                throw new \TypeError( 'Collection->loop() callback function did not return a boolean value' );
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
    }
}
