<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Collection;

use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

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
    public function __construct(Type $valueType) {
        $this->helper = new PrimitiveKeyHashMapHelper(new StringType(), $valueType);
    }

    public function clone(): StringKeyHashMap
    {
        $clone = clone $this;
        $clone->helper = clone $this->helper;
        return $clone;
    }

    public function count(): int {
        return $this->helper->count();
    }

    /**
     * @inheritDoc
     */
    public function get($key) {
        return $this->helper->get($key);
    }

    public function getKeyType(): Type {
        return $this->helper->getKeyType();
    }

    public function getValueType(): Type {
        return $this->helper->getValueType();
    }

    /**
     * @inheritDoc
     */
    public function hasKey($key): bool {
        return $this->helper->hasKey($key);
    }

    /**
     * @inheritDoc
     */
    public function removeKey($key): self {
        $this->helper->removeKey($key);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value): self {
        $this->helper->set($key, $value);
        return $this;
    }
}
