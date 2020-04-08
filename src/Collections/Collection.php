<?php
declare( strict_types = 1 );

namespace PHP\Collections;

use PHP\Exceptions\NotFoundException;
use PHP\Interfaces\Cloneable;
use PHP\Iteration\IIterable;
use PHP\ObjectClass;
use PHP\Types\Models\AnonymousType;
use PHP\Types\Models\Type;
use PHP\Types\TypeLookupSingleton;
use PHP\Types\TypeNames;

/**
 * Defines an iterable set of mutable, key-value pairs
 *
 * @see PHP\Collections\Iterator
 */
abstract class Collection extends ObjectClass implements Cloneable, \Countable, IIterable
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
     * @param string $keyType   Type requirement for keys. '*' allows all types.
     * @param string $valueType Type requirement for values. '*' allows all types.
     * @param array  $entries   Initial entries [ key => value ]
     * @throws \DomainException When key or value type either does not exist or is null.
     */
    public function __construct( string $keyType,
                                 string $valueType,
                                 array  $entries   = [] )
    {
        // Create type lookup
        $typeLookup = TypeLookupSingleton::getInstance();

        // Lookup key type
        if ( AnonymousType::NAME === $keyType ) {
            $this->keyType = $this->createAnonymousKeyType();
        }
        else {
            try {
                $this->keyType = $typeLookup->getByName( $keyType );
            } catch ( \DomainException $e ) {
                throw new \DomainException( "\"$keyType\" cannot be used for the key type: it does not exist." );
            }
        }

        // Lookup value type
        if ( AnonymousType::NAME === $valueType ) {
            $this->valueType = $this->createAnonymousValueType();
        }
        else {
            try {
                $this->valueType = $typeLookup->getByName( $valueType );
            } catch ( \DomainException $e ) {
                throw new \DomainException( "\"$valueType\" cannot be used for the value type: it does not exist." );
            }
        }

        // Throw exception on types
        if ( TypeNames::NULL === $this->getKeyType()->getName() ) {
            throw new \DomainException( 'Key type cannot be "null"' );
        }
        if ( TypeNames::NULL === $this->getValueType()->getName() ) {
            throw new \DomainException( 'Value type cannot be "null"' );
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
     * @deprecated Use getIterator() instead. 04-2020.
     */
    final public function valid(): bool
    {
        trigger_error( 'Deprecated. Use getIterator() instead.', E_USER_DEPRECATED );
        return $this->hasKey( $this->key() );
    }




    /***************************************************************************
    *                                   CLONE
    ***************************************************************************/


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
     * @internal Final. The key type cannot be modified after construction.
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
     * @internal Final. The value type cannot be modified after construction.
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
     * @internal Not final since a child class may have optimizations to make,
     * especially if they have a limited data set.
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
     * @deprecated Use foreach( Collection ) instead. 04-2020.
     */
    final public function loop( \Closure $function )
    {
        trigger_error(
            'Collection->loop() deprecated. Use foreach( Collection ) instead.',
            E_USER_DEPRECATED
        );

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
