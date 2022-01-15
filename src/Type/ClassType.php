<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * A Class Type.
 */
final class ClassType implements TypeInterface
{
    private \ReflectionClass $reflector;

    /**
     * Create a new ClassType.
     *
     * @param string $class The class name.
     * @throws \DomainException
     */
    public function __construct(string $class)
    {
        $exception = "not a class name: \"{$class}\"";

        try {
            $this->reflector = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \DomainException($exception);
        }

        if ($this->reflector->isInterface()) {
            throw new \DomainException($exception);
        }
    }

    public function equals($value): bool
    {
        return $value instanceof self && $this->reflector->getName() == $value->reflector->getName();
    }

    public function is(TypeInterface $type): bool
    {
        if ($type instanceof ClassType) {
            return $this->reflector->getName() == $type->reflector->getName() || $this->reflector->isSubclassOf($type->reflector);
        }
        return false;
    }

    public function isValueOfType($value): bool
    {
        return is_object($value) && $this->reflector->isInstance($value);
    }
}
