<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Collection;

use EvanWashkow\PHPLibraries\CollectionInterface\Mapper;
use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Defines an integer key => value map
 */
final class IntegerKeyHashMap implements Mapper
{
    /** @var array<int|string, mixed> The hash map */
    private array $hashMap;
    private Type $keyType;
    private Type $valueType;

    /**
     * Create a new IntegerKeyHashMap instance
     *
     * @param Type $valueType The value type requirement for all values in the map
     */
    public function __construct(Type $valueType) {
        $this->hashMap = [];
        $this->keyType = new IntegerType();
        $this->valueType = $valueType;
    }

    public function count(): int {
        return count($this->hashMap);
    }

    /**
     * @inheritDoc
     */
    public function get($key) {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnMissingKey($key);
        return $this->hashMap[$key];
    }

    public function getKeyType(): Type {
        return $this->keyType;
    }

    public function getValueType(): Type {
        return $this->valueType;
    }

    /**
     * @inheritDoc
     */
    public function hasKey($key): bool {
        $this->throwOnInvalidKeyType($key);
        return array_key_exists($key, $this->hashMap);
    }

    /**
     * @inheritDoc
     */
    public function removeKey($key): HashMap {
        $this->throwOnInvalidKeyType($key);
        $this->throwOnMissingKey($key);
        unset($this->hashMap[$key]);
        return $this;
    }

    /**
     * @inheritDoc
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
