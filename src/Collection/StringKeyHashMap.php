<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Collection;

use EvanWashkow\PhpLibraries\CollectionInterface\Mapper;
use EvanWashkow\PhpLibraries\Type\StringType;
use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Defines an string key => value map
 */
final class StringKeyHashMap implements Mapper
{
    private PrimitiveKeyHashMapHelper $helper;

    /**
     * Create a new StringKeyHashMap instance
     *
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(Type $valueType)
    {
        $this->helper = new PrimitiveKeyHashMapHelper(new StringType(), $valueType);
    }

    public function clone(): StringKeyHashMap
    {
        $clone = clone $this;
        $clone->helper = clone $this->helper;
        return $clone;
    }

    public function count(): int
    {
        return $this->helper->count();
    }

    public function get(int|string $key): mixed
    {
        return $this->helper->get($key);
    }

    public function getKeyType(): Type
    {
        return $this->helper->getKeyType();
    }

    public function getValueType(): Type
    {
        return $this->helper->getValueType();
    }

    public function hasKey(int|string $key): bool
    {
        return $this->helper->hasKey($key);
    }

    public function removeKey(int|string $key): self
    {
        $this->helper->removeKey($key);
        return $this;
    }

    public function set(int|string $key, mixed $value): self
    {
        $this->helper->set($key, $value);
        return $this;
    }
}
