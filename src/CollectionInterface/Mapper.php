<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a collection with key => value mapping
 */
interface Mapper extends KeyedCollector
{
    /**
     * @param int|string $key The key
     */
    public function get(int|string $key): mixed;

    /**
     * @param int|string $key The key
     */
    public function hasKey(int|string $key): bool;

    /**
     * @param int|string $key The key to remove
     */
    public function removeKey(int|string $key): self;

    /**
     * Adds a new value with the corresponding key
     *
     * @param int|string $key The key for the value
     * @param mixed $value The value
     *
     * @return self The modified map instance
     */
    public function set(int|string $key, mixed $value): self;
}
