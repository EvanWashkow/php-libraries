<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Collection;

use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Defines an integer/string key => value map
 */
final class HashMap implements \Countable
{
    /** @var array<int|string, mixed> The hash map */
    private array $hashMap;
    private Type $keyType;
    private Type $valueType;

    /**
     * Create a new Map instance
     *
     * @param Type $keyType The key type requirement for all keys in the map
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(Type $keyType, Type $valueType) {
        if (! ($keyType instanceof IntegerType || $keyType instanceof StringType)) {
            throw new \InvalidArgumentException('The Map key type must be an integer or string');
        }
        $this->hashMap = [];
        $this->keyType = $keyType;
        $this->valueType = $valueType;
    }

    public function count(): int {
        return count($this->hashMap);
    }

    /**
     * Retrieve the value by with its key
     *
     * @param int|string $key The key for the value
     *
     * @return mixed The value
     *
     * @throws \OutOfBoundsException
     */
    public function get($key) {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnMissingKey($key);
        return $this->hashMap[$key];
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
     * Determines if the key exists
     *
     * @param int|string $key The key
     */
    public function hasKey($key): bool {
        $this->throwOnInvalidKeyType($key);
        return array_key_exists($key, $this->hashMap);
    }

    /**
     * Removes a value by its key
     *
     * @param int|string $key The key, of the corresponding value, to remove
     */
    public function removeKey($key): HashMap {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnMissingKey($key);
        unset($this->hashMap[$key]);
        return $this;
    }

    /**
     * Adds a new value with the corresponding key
     *
     * @param int|string $key The key for the value
     * @param mixed $value The value
     *
     * @return HashMap The modified HashMap instance
     */
    public function set($key, $value): HashMap {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnInvalidValueType($value);
        $this->hashMap[$key] = $value;
        return $this;
    }

    /**
     * Throws an exception on an invalid key type
     *
     * @param int|string $key The key
     *
     * @throws \InvalidArgumentException
     */
    private function throwOnInvalidKeyType($key): void {
        if (! $this->getKeyType()->isValueOfType($key)) {
            throw new \InvalidArgumentException('The key is the wrong type');
        }
    }

    /**
     * Throws an exception on an invalid value type
     *
     * @param mixed $value The value
     *
     * @throws \InvalidArgumentException
     */
    private function throwOnInvalidValueType($value): void {
        if (! $this->getValueType()->isValueOfType($value)) {
            throw new \InvalidArgumentException('Cannot set value: the value is the wrong type');
        }
    }

    /**
     * Throws an exception on a missing key
     *
     * @param int|string $key
     *
     * @throws \OutOfBoundsException
     */
    private function throwOnMissingKey($key): void {
        if (! $this->hasKey($key)) {
            throw new \OutOfBoundsException('The key does not exist');
        }
    }
}
