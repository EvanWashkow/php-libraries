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
     * Retrieves this type name
     */
    final public function getName(): string
    {
        return $this->name;
    }


    final public function hash(): ByteArray
    {
        return new ByteArray($this->name);
    }


    /**
     * Determines if this Type is exactly the same Type as the other
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
