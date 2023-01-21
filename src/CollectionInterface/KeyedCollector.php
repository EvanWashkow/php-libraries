<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Describes a collection with key => value mapping
 *
 * @template TKey
 * @template TValue
 */
interface KeyedCollector extends Collector
{
    /**
     * Retrieve the value by its key
     *
     * @param TKey $key The key for the value
     *
     * @return TValue The value
     *
     * @throws \OutOfBoundsException
     */
    public function get(mixed $key): mixed;

    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type;

    /**
     * Determines if the key exists
     *
     * @param TKey $key The key
     */
    public function hasKey(mixed $key): bool;

    /**
     * Removes a value by its key
     *
     * @param TKey $key The key to remove
     *
     * @return self The modified collection
     *
     * @throws \OutOfBoundsException
     */
    public function removeKey(mixed $key): self;

    /**
     * Inserts a new value at the corresponding key
     *
     * @param TKey $key The key for the value
     * @param TValue $value The value
     *
     * @return self The modified collection
     */
    public function set(mixed $key, mixed $value): self;
}
