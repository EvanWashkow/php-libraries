<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\TypeInterface\NameableType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Helper class for the ClassType and InterfaceType classes
 */
final class ClassInterfaceTypeHelper
{
    private \ReflectionClass $reflectionClass;

    /**
     * Create a new ClassInterfaceTypeHelper
     *
     * @param string $name The class or interface name
     *
     * @throws \DomainException
     */
    public function __construct(string $name)
    {
        try {
            $this->reflectionClass = new \ReflectionClass($name);
        } catch (\ReflectionException $e) {
            throw new \DomainException("The type does not exist: {$name}");
        }
    }

    /**
     * Compare values for equality.
     *
     * @param NameableType $type the value to compare
     */
    public function equals(NameableType $type): bool
    {
        return $this->getName() === $type->getName();
    }

    /**
     * Get the Type name.
     */
    public function getName(): string
    {
        return $this->reflectionClass->getName();
    }

    /**
     * Retrieves the reflection class for the Class or Interface
     */
    public function getReflectionClass(): \ReflectionClass
    {
        return $this->reflectionClass;
    }

    /**
     * Check type inheritance.
     *
     * @param Type $type the type to check
     */
    public function is(Type $type): bool
    {
        return ($type instanceof NameableType) &&
            ($this->reflectionClass->getName() === $type->getName() ||
                $this->reflectionClass->isSubclassOf($type->getName()));
    }

    /**
     * Determines if the given value is of this type.
     *
     * @param mixed $value the value to check
     */
    public function isValueOfType(mixed $value): bool
    {
        return is_object($value) && $this->reflectionClass->isInstance($value);
    }
}
