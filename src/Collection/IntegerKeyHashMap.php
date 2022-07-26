<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Collection;

use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Defines an integer key => value map
 */
final class IntegerKeyHashMap implements Mapper
{
    private PrimitiveKeyHashMapHelper $helper;

    /**
     * Create a new IntegerKeyHashMap instance
     *
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(Type $valueType) {
        $this->helper = new PrimitiveKeyHashMapHelper(new IntegerType(), $valueType);
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
    public function removeKey($key): IntegerKeyHashMap {
        $this->helper->removeKey($key);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value): IntegerKeyHashMap {
        $this->helper->set($key, $value);
        return $this;
    }
}
