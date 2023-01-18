<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\Collection;

use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Helper class for hash maps with primitive (string / integer) keys
 */
final class PrimitiveKeyHashMapHelper
{
    /** @var array<int|string, mixed> The hash map */
    private array $hashMap;

    /**
     * Create a new PrimitiveKeyHashMap instance
     *
     * @param Type $keyType The key type requirement for all keys in the map
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(private Type $keyType, private Type $valueType)
    {
        $this->hashMap = [];
    }

    /**
     * Retrieve the number of items in the hash map
     */
    public function count(): int
    {
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
    public function get(int|string $key): mixed
    {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnMissingKey($key);
        return $this->hashMap[$key];
    }

    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type
    {
        return $this->keyType;
    }

    /**
     * Retrieve the value type
     */
    public function getValueType(): Type
    {
        return $this->valueType;
    }

    /**
     * Determines if the key exists
     *
     * @param int|string $key The key
     */
    public function hasKey(int|string $key): bool
    {
        $this->throwOnInvalidKeyType($key);
        return array_key_exists($key, $this->hashMap);
    }

    /**
     * Removes a value by its key
     *
     * @param int|string $key The key, of the corresponding value, to remove
     */
    public function removeKey(int|string $key): void
    {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnMissingKey($key);
        unset($this->hashMap[$key]);
    }

    /**
     * Adds a new value with the corresponding key
     *
     * @param int|string $key The key for the value
     * @param mixed $value The value
     */
    public function set(int|string $key, mixed $value): void
    {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnInvalidValueType($value);
        $this->hashMap[$key] = $value;
    }

    /**
     * Throws an exception on an invalid key type
     *
     * @param int|string $key The key
     *
     * @throws \InvalidArgumentException
     */
    private function throwOnInvalidKeyType(int|string $key): void
    {
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
    private function throwOnInvalidValueType(mixed $value): void
    {
        if (! $this->getValueType()->isValueOfType($value)) {
            throw new \InvalidArgumentException('Cannot set value: the value is the wrong type');
        }
    }

    /**
     * Throws an exception on a missing key
     *
     * @throws \OutOfBoundsException
     */
    private function throwOnMissingKey(int|string $key): void
    {
        if (! $this->hasKey($key)) {
            throw new \OutOfBoundsException('The key does not exist');
        }
    }
}
