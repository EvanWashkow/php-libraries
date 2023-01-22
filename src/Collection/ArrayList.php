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
    public function add(mixed $value): static
    {
        return $this;
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
