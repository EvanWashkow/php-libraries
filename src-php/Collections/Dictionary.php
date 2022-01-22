<?php

declare(strict_types=1);

namespace PHP\Collections;

use PHP\Collections\Iterators\DictionaryIterator;
use PHP\Exceptions\NotFoundException;
use PHP\Collections\Iteration\Iterator;
use PHP\Types\Models\AnonymousType;

/**
 * Defines a mutable, unordered, and iterable set of key-value pairs
 */
class Dictionary extends Collection
{
    /***************************************************************************
    *                               PROPERTIES
    ***************************************************************************/

    /** @var array The set of key-value pairs */
    private $entries;




    /***************************************************************************
    *                               CONSTRUCTOR
    ***************************************************************************/


    /**
     * Create a new collection of entries, stored in key-value pairs
     *
     * Only supports string and integer keys, for the time being.
     *
     * Throws \InvalidArgumentException on bad key or value type
     *
     * @param string $keyType   Type requirement for keys. '*' allows all types.
     * @param string $valueType Type requirement for values. '*' allows all types.
     * @param array  $entries   Initial entries [ key => value ]
     * @throws \InvalidArgumentException On bad key / value type
     */
    public function __construct(
        string $keyType,
        string $valueType,
        array  $entries = []
    )
    {
        // Set properties
        $this->clear();
        parent::__construct($keyType, $valueType, $entries);

        // Exit. The key type must be either an integer or string.
        if (!$this->getKeyType()->is('int') &&
             !$this->getKeyType()->is('string')) {
            throw new \InvalidArgumentException('Dictionary keys must either be integers or strings');
        }
    }


    /**
     * @see Collection->createAnoymousKeyType()
     *
     * @internal This can be overridden to add more anonymous type support
     */
    protected function createAnonymousKeyType(): AnonymousType
    {
        return new Dictionary\DictionaryAnonymousKeyType();
    }




    /***************************************************************************
    *                            COLLECTION OVERRIDES
    ***************************************************************************/


    /**
     * @see Collection->clear()
     */
    public function clear(): bool
    {
        $this->entries = [];
        return true;
    }


    /**
     * @see Collection->count()
     *
     * @internal Final: counting items is rather boring work, and this is
     * critical to other methods working correctly.
     */
    final public function count(): int
    {
        return count($this->entries);
    }


    /**
     * @see Collection->get()
     */
    public function get($key)
    {
        if (!$this->hasKey($key)) {
            throw new \OutOfBoundsException('Key doesn\'t exist');
        }
        return $this->entries[ $key ];
    }


    /**
     * @see Collection->getKeyOf()
     */
    public function getKeyOf($value)
    {
        // Throw exception for wrong value type
        if (!$this->getValueType()->isValueOfType($value)) {
            throw new NotFoundException('Could not find key. Value is the wrong type.');
        }

        // Search for the value
        $key = array_search($value, $this->entries, true);

        // Throw exception for key not found
        if (false === $key) {
            throw new NotFoundException('Value (and key) not found.');
        }

        // Return the key
        return $key;
    }


    /**
     * @see Collection->getKeys()
     */
    public function getKeys(): Sequence
    {
        return new Sequence(
            $this->getKeyType()->getName(),
            array_keys($this->entries)
        );
    }


    /**
     * @see Collection->hasKey()
     */
    public function hasKey($key): bool
    {
        return (
            $this->getKeyType()->isValueOfType($key) &&
            array_key_exists($key, $this->entries)
        );
    }


    /**
     * @see Collection->remove()
     */
    public function remove($key): bool
    {
        $isSuccessful = false;
        if ($this->hasKey($key)) {
            unset($this->entries[ $key ]);
            $isSuccessful = true;
        } else {
            trigger_error("Key does not exist");
        }
        return $isSuccessful;
    }


    /**
     * @see Collection->set()
     */
    public function set($key, $value): bool
    {
        // Throw warnings
        $isSuccessful = false;
        if (!$this->getKeyType()->isValueOfType($key)) {
            trigger_error('Wrong key type');
        } elseif (!$this->getValueType()->isValueOfType($value)) {
            trigger_error('Wrong value type');
        }

        // Set the key value pair
        else {
            $this->entries[ $key ] = $value;
            $isSuccessful = true;
        }
        return $isSuccessful;
    }


    /**
     * @see Collection->toArray()
     *
     * @internal Final: this method should always return an array of the
     * original values.
     */
    final public function toArray(): array
    {
        return $this->entries;
    }




    /***************************************************************************
    *                      ITERATOR INTERFACE IMPLEMENTATION
    ***************************************************************************/


    public function getIterator(): Iterator
    {
        return new DictionaryIterator($this);
    }


    /**
     * @deprecated Use getIterator() instead. 04-2020
     */
    final public function current()
    {
        static $isFirstCurrent = true;
        if ($isFirstCurrent) {
            trigger_error('Deprecated. Use getIterator() instead.', E_USER_DEPRECATED);
            $isFirstCurrent = false;
        }
        return current($this->entries);
    }

    /**
     * @deprecated Use getIterator() instead. 04-2020
     */
    final public function key()
    {
        static $isFirstKey = true;
        if ($isFirstKey) {
            trigger_error('Deprecated. Use getIterator() instead.', E_USER_DEPRECATED);
            $isFirstKey = false;
        }
        $key = key($this->entries);

        /**
         * PHP implicitly implicitly converts string indices--like "0"--to integers
         *
         * TODO: Remove this when converting to two internal sequences for keys
         * and values
         */
        if ((null !== $key) && $this->getKeyType()->is('string')) {
            $key = ( string ) $key;
        }
        return $key;
    }

    /**
     * @deprecated Use getIterator() instead. 04-2020
     */
    final public function next()
    {
        static $isFirstNext = true;
        if ($isFirstNext) {
            trigger_error('Deprecated. Use getIterator() instead.', E_USER_DEPRECATED);
            $isFirstNext = false;
        }
        next($this->entries);
    }

    /**
     * @deprecated Use getIterator() instead. 04-2020
     */
    final public function rewind()
    {
        static $isFirstRewind = true;
        if ($isFirstRewind) {
            trigger_error('Deprecated. Use getIterator() instead.', E_USER_DEPRECATED);
            $isFirstRewind = false;
        }
        reset($this->entries);
    }
}
