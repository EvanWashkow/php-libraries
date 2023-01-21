<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Describes a collection with key => value mapping
 */
interface KeyedCollector extends Collector
{
    /**
     * Retrieve the value by its key
     *
     * @param int $key The key for the value
     *
     * @return mixed The value
     *
     * @throws \OutOfBoundsException
     */
    public function get(int $key): mixed;

    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type;

    /**
     * Determines if the key exists
     *
     * @param int $key The key
     */
    public function hasKey(int $key): bool;

    /**
     * Removes a value by its key
     *
     * @param int $key The key to remove
     *
     * @return self The modified collection
     */
    public function removeKey(int $key): self;

    /**
     * Inserts a new value at the corresponding key
     *
     * @param int $key The key for the value
     * @param mixed $value The value
     *
     * @return self The modified collection
     */
    public function set(int $key, mixed $value): self;
}
