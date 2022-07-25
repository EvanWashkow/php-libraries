<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Collection;

use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Defines an integer/string key => value map
 */
final class HashMap
{
    private Type $keyType;
    private Type $valueType;

    /**
     * Create a new Map instance
     *
     * @param Type $keyType The key type requirement for all keys in the map
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(Type $keyType, Type $valueType)
    {
        if (! ($keyType instanceof IntegerType || $keyType instanceof StringType)) {
            throw new \InvalidArgumentException('The Map key type must be an integer or string');
        }
        $this->keyType = $keyType;
        $this->valueType = $valueType;
    }

    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type {
        return $this->keyType;
    }

    /**
     * Retrieve the value type
     */
    public function getValueType(): Type {
        return $this->valueType;
    }

    /**
     * Adds a new value with the corresponding key
     *
     * @param mixed $key The key for the value
     * @param mixed $value The value
     */
    public function set($key, $value) {
        if (!$this->getKeyType()->isValueOfType($key)) {
            throw new \InvalidArgumentException('Cannot set key: the key is the wrong type');
        }
        if (!$this->getValueType()->isValueOfType($value)) {
            throw new \InvalidArgumentException('Cannot set value: the value is the wrong type');
        }
    }
}
