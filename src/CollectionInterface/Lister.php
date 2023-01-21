<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a list of indexed values
 */
interface Lister extends KeyedCollector
{
    /**
     * Add a new value to the list
     *
     * @param mixed $value The value
     *
     * @return self The modified list
     */
    public function add(mixed $value): self;

    /**
     * @param int $key The key
     *
     * @return mixed The value
     */
    public function get(mixed $key): mixed;

    /**
     * @param int $key The key
     */
    public function hasKey(mixed $key): bool;

    /**
     * @param int $key The key to remove
     *
     * @return self The modified collection
     */
    public function removeKey(mixed $key): self;

    /**
     * @param int $key The key for the value
     * @param mixed $value The value
     *
     * @return self The modified collection
     */
    public function set(mixed $key, mixed $value): self;
}
