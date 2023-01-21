<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Collection;

use EvanWashkow\PhpLibraries\CollectionInterface\Mapper;
use EvanWashkow\PhpLibraries\Type\IntegerType;
use EvanWashkow\PhpLibraries\Type\StringType;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Defines an integer/string key => value map
 * 
 * @implements Mapper<int|string, mixed>
 */
final class HashMap implements Mapper
{
    private Mapper $map;

    /**
     * Create a new HashMap instance
     *
     * @param Type $keyType The key type requirement for all keys in the map
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(Type $keyType, Type $valueType)
    {
        if ($keyType instanceof IntegerType) {
            $this->map = new IntegerKeyHashMap($valueType);
        } elseif ($keyType instanceof StringType) {
            $this->map = new StringKeyHashMap($valueType);
        } else {
            throw new \InvalidArgumentException('The Map key type must be an integer or string');
        }
    }

    public function clone(): HashMap
    {
        $clone = clone $this;
        $clone->map = $this->map->clone();
        return $clone;
    }

    public function count(): int
    {
        return $this->map->count();
    }

    public function get(mixed $key): mixed
    {
        return $this->map->get($key);
    }

    public function getKeyType(): Type
    {
        return $this->map->getKeyType();
    }

    public function getValueType(): Type
    {
        return $this->map->getValueType();
    }

    public function hasKey(mixed $key): bool
    {
        return $this->map->hasKey($key);
    }

    public function removeKey(mixed $key): self
    {
        $this->map->removeKey($key);
        return $this;
    }

    public function set(mixed $key, mixed $value): self
    {
        $this->map->set($key, $value);
        return $this;
    }
}
