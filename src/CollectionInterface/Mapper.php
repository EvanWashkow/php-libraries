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
     *
     * @return mixed The value
     */
    public function get(mixed $key): mixed;

    /**
     * @param int|string $key The key
     */
    public function hasKey(mixed $key): bool;

    /**
     * @param int|string $key The key to remove
     *
     * @return self The modified collection
     */
    public function removeKey(mixed $key): self;

    /**
     * @param int|string $key The key for the value
     * @param mixed $value The value
     *
     * @return self The modified collection
     */
    public function set(mixed $key, mixed $value): self;
}
