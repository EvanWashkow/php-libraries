<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

use EvanWashkow\PhpLibraries\Cloneable;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Describes a Collection with key => value mapping
 */
interface Mapper extends \Countable, Cloneable
{
    /**
     * Retrieve the value by with its key
     *
     * @param int|string $key The key for the value
     *
     * @return mixed The value
     *
     * @throws \OutOfBoundsException
     */
    public function get(int|string $key): mixed;

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
    public function hasKey(int|string $key): bool;

    /**
     * Removes a value by its key
     *
     * @param int|string $key The key, of the corresponding value, to remove
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
