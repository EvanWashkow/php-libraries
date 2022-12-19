<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\CollectionInterface;

use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Describes a Collection with key => value mapping
 */
interface Mapper extends \Countable
{
    /**
     * Returns a copy of the object
     */
    public function clone(): self;

    /**
     * Retrieve the value by with its key
     *
     * @param int|string $key The key for the value
     *
     * @return mixed The value
     *
     * @throws \OutOfBoundsException
     */
    public function get($key);

    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type;

    /**
     * Retrieve the value type
     */
    public function getValueType(): Type;

    /**
     * Determines if the key exists
     *
     * @param int|string $key The key
     */
    public function hasKey($key): bool;

    /**
     * Removes a value by its key
     *
     * @param int|string $key The key, of the corresponding value, to remove
     */
    public function removeKey($key): self;

    /**
     * Adds a new value with the corresponding key
     *
     * @param int|string $key The key for the value
     * @param mixed $value The value
     *
     * @return self The modified map instance
     */
    public function set($key, $value): self;
}
