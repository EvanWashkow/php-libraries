<?php

declare(strict_types=1);

namespace PHP\Enums;

use PHP\Types\TypeLookupSingleton;

/**
 * Defines a set of bit maps, allowing the user to specify one or more of them in a bitwise OR (|) operation.
 *
 * All constants must be public and integers.
 */
abstract class BitMapEnum extends IntegerEnum
{
    /**
     * Determines if the given bits are set in the current value.
     *
     * @param BitMapEnum|int $bitMap The bits to check
     */
    public function isSet($bitMap): bool
    {
        if ($bitMap instanceof BitMapEnum) {
            $bitMap = $bitMap->getValue();
        }
        if (!is_int($bitMap)) {
            $type = TypeLookupSingleton::getInstance()->getByValue($bitMap);

            throw new \InvalidArgumentException("BitMapEnum->isSet() expects an Integer or BitMapEnum. {$type->getName()} given.");
        }

        return $this->isSubset($this->getValue(), $bitMap);
    }

    /**
     * Sanitizes the value before it is set by the constructor.
     *
     * Returns the value if it is valid. Otherwise, it should throw a DomainException.
     *
     * @param mixed $value the bitmap value to sanitize before setting
     *
     * @throws \DomainException       If the value is not supported
     * @throws MalformedEnumException If an Enum constant is not public or not an integer
     *
     * @return int the value after sanitizing
     */
    protected function sanitizeValue($value): int
    {
        $constantBitMap = 0;
        foreach (self::getConstants()->toArray() as $constantValue) {
            $constantBitMap = $constantBitMap | $constantValue;
        }
        if (!$this->isSubset($constantBitMap, $value)) {
            $className = static::class;

            throw new \DomainException(
                "The value is not a bitmap of the constants defined on the class {$className}."
            );
        }

        return $value;
    }

    /**
     * Determine if B is a bitwise subset of A.
     *
     * @param int $a The master bitmap to compare against
     * @param int $b The bitmap to be compared against $a
     */
    private function isSubset(int $a, int $b): bool
    {
        // If B is a subset of A, ANDing them together should produce B.
        return ($a & $b) === $b;
    }
}
