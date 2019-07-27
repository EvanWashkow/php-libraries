<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Exceptions\NotFoundException;
use PHP\Interfaces\Cloneable;
use PHP\ObjectClass;
use PHP\Types;
use PHP\Types\Models\AnonymousType;
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
abstract class Collection extends ObjectClass implements Cloneable,
                                                         \Countable,
                                                         \Iterator
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
     * Throws \InvalidArgumentException when key or value type is NULL or unknown.
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
        if ( AnonymousType::NAME === $keyType ) {
            $this->keyType = $this->createAnonymousKeyType();
        }
        else {
            try {
                $this->keyType = Types::GetByName( $keyType );
            } catch ( NotFoundException $e ) {
                throw new \InvalidArgumentException( "\"$keyType\" cannot be used for the key type: it does not exist." );
            }
        }

        // Lookup value type
        if ( AnonymousType::NAME === $valueType ) {
            $this->valueType = $this->createAnonymousValueType();
        }
        else {
            try {
                $this->valueType = Types::GetByName( $valueType );
            } catch ( NotFoundException $e ) {
                throw new \InvalidArgumentException( "\"$valueType\" cannot be used for the value type: it does not exist." );
            }
        }

        // Throw exception on types
        if ( TypeNames::NULL === $this->getKeyType()->getName() ) {
            throw new \InvalidArgumentException( 'Key type cannot be "null"' );
        }
        if ( TypeNames::NULL === $this->getValueType()->getName() ) {
            throw new \InvalidArgumentException( 'Value type cannot be "null"' );
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
        return new AnonymousType();
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
     * @internal No way to write an optimal implementation (using toArray()).
     * Depending on the collection, toArray() may take time to complete.
     *
     * @return int
     **/
    abstract public function count(): int;

    /**
     * Retrieve the value
     * 
     * Throws \OutOfBoundsException if the key does not exist
     *
     * @param mixed $key The key to retrieve the value from
     * @return mixed The value if the key exists. NULL otherwise.
     * @throws \OutOfBoundsException Key doesn't exist
     */
    abstract public function get( $key );

    /**
     * Retrieve all keys
     * 
     * @internal There's no way to write a solution for this (using toArray())
     * without also making it incorrect.
     *
     * @return Sequence
     */
    abstract public function getKeys(): Sequence;

    /**
     * Retrieve the key of the first value found
     * 
     * Throws \PHP\Exceptions\NotFoundException if key not found. This *always* has to be
     * handled by the caller, even if a default value was returned. Throwing an
     * exception provides more information to the caller about what happened.
     * 
     * @internal There's no way to write a solution for this (using toArray())
     * without also making it incorrect.
     *
     * @param mixed $value The value to find
     * @return mixed The key
     * @throws \PHP\Exceptions\NotFoundException When key not found
     */
    abstract public function getKeyOf( $value );

    /**
     * Determine if the key exists
     * 
     * @internal There's no way to write an optimal solution for this
     * (using getKeys()). getKeys() takes time to complete.
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
    *                                     OVERRIDES
    ***************************************************************************/


    /**
     * Determines if this collection has the same entries
     * 
     * @param array|Collection $value The entries to compare this to
     * @return bool
     */
    public function equals( $value ): bool
    {
        // Variables
        $equals     = false;
        $valueArray = NULL;

        // Get array
        if ( is_array( $value )) {
            $valueArray = $value;
        }
        elseif ( $value instanceof Collection ) {
            $valueArray = $value->toArray();
        }

        /**
         * Compare the array values
         * 
         * Note: "===" actually compares the array entries, not the instances.
         */
        if ( NULL !== $valueArray ) {
            $equals = $this->toArray() === $valueArray;
        }

        return $equals;
    }


    /**
     * @see Iterator->valid()
     * 
     * @internal Final. This functionality is derived from sub methods, and
     * there is no other conceivable behavior to add here.
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
    public function clone(): Cloneable
    {
        return clone $this;
    }




    /***************************************************************************
    *                                 OWN METHODS
    ***************************************************************************/


    /**
     * Retrieve key type
     * 
     * @internal Final. The key type is set in stone by the constructor, and
     * after construction, is immutible.
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
     * @internal Final. The value type is set in stone by the constructor, and
     * after construction, is immutible.
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
     * @param mixed $value The value to check for
     * @return bool
     */
    public function hasValue( $value ): bool
    {
        $hasValue = true;
        try {
            $this->getKeyOf( $value );
        }
        catch ( NotFoundException $e ) {
            $hasValue = false;
        }
        return $hasValue;
    }


    /**
     * Iterate over the key-value pairs invoking the callback function with them
     * 
     * @internal Final. This method is performance-critical and should not be
     * overridden for fear of breaking the loop implementation. Also, it is
     * dependent on sub-methods for operation, which can be changed to correct
     * this behavior.
     * 
     * @internal Type hint of Closure. This type hint should execute slightly
     * faster than the "callable" pseudo-type. Also, users **should** be using
     * closures rather than hard-coded, public functions. Doing this needlessly
     * dirties class namespaces, and should be discouraged.
     * 
     * @internal Do not use iterator_apply(). It is at least twice as slow as this.
     *
     * @param \Closure $function function( $key, $value ) { return true; }
     * @return void
     * @throws \TypeError If the callback does not return a bool
     */
    final public function loop( \Closure $function )
    {
        // Loop through each value, until the end of the collection is reached,
        // or caller wants to stop the loop
        $collection = $this->clone();
        while ( $collection->valid() ) {
            
            // Execute callback function with key and value
            $canContinue = $function( $collection->key(), $collection->current() );
            
            // Handle return value
            if ( true === $canContinue ) {
                $collection->next();
            }
            elseif ( false === $canContinue ) {
                break;
            }
            else {
                throw new \TypeError( 'Collection->loop() callback function did not return a boolean value' );
            }
        }
    }
}
