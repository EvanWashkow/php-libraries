<?php
declare(strict_types=1);

namespace PHP\Type\Model;

use PHP\Collections\ByteArray;

/**
 * Defines a PHP Type
 */
abstract class Type extends \PHP\ObjectClass
{
    /** @var string The type name */
    private $name;


    /**
     * Creates a new Type instance
     *
     * @param string $name The type name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * Determine if a value is of this Type
     *
     * @param mixed $value The value
     */
    abstract public function isValueOfType($value): bool;


    /**
     * Determines if this Type is of another Type
     *
     * @param self $type The Type instance
     */
    abstract protected function isOfType(self $type): bool;


    /**
     * Retrieves this type name
     */
    final public function getName(): string
    {
        return $this->name;
    }


    /**
     * Determine if this Type is of the specified type
     *
     * @param self|string $type The Type or Type name
     */
    final public function is($type): bool
    {
        $isOfType = false;
        if ($type instanceof self)
        {
            $isOfType = $this->isOfType($type);
        }
        return $isOfType;
    }


    final public function hash(): ByteArray
    {
        return new ByteArray($this->getName());
    }


    /**
     * Determines if this Type is exactly the given Type
     *
     * @interal For consistency with IEquatable->equals(), this will accept any value type without throwing an exception
     *
     * @param self|string $value The Type or Type name
     */
    final public function equals($value): bool
    {
        $isEqual = false;
        if ($value instanceof Type)
        {
            $isEqual = $this->getName() === $value->getName();
        }
        elseif (is_string($value))
        {
            $isEqual = $this->getName() === $value;
        }
        return $isEqual;
    }
}
