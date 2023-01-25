<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Collection;

use EvanWashkow\PhpLibraries\CollectionInterface\Lister;
use EvanWashkow\PhpLibraries\Type\StringType;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * An array implementation of a list
 *
 * @template TValue
 *
 * @extends Lister<TValue>
 */
final class ArrayList implements Lister
{
    private Type $valueType;

    /**
     * Creates a new ArrayList instance
     * 
     * @param Type $valueType The value type requirement for all values in the array list
     */
    public function __construct(Type $valueType) {
        $this->valueType = $valueType;
    }

    public function add(mixed $value): static
    {
        throw new \TypeError('The value is the wrong type');
    }

    public function clone(): static
    {
        return $this;
    }

    public function count(): int
    {
        return 0;
    }

    public function get(mixed $key): mixed
    {
        return $this;
    }

    public function getKeyType(): Type
    {
        return new StringType();
    }

    public function getValueType(): Type
    {
        return new StringType();
    }

    public function hasKey(mixed $key): bool
    {
        return true;
    }

    public function removeKey(mixed $key): static
    {
        return $this;
    }

    public function set(mixed $key, mixed $value): static
    {
        return $this;
    }
}
