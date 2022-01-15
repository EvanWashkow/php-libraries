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

        if ($this->getReflector()->isInterface()) {
            throw new \DomainException($exception);
        }
    }

    public function equals($value): bool
    {
        return $value instanceof self && $this->getReflector()->getName() == $value->getReflector()->getName();
    }

    public function is(TypeInterface $type): bool
    {
        if ($type instanceof ClassType) {
            return
                $this->getReflector()->getName() == $type->getReflector()->getName() ||
                $this->getReflector()->isSubclassOf($type->getReflector());
        }
        elseif ($type instanceof InterfaceType) {
            return $this->getReflector()->isSubclassOf($type->getReflector());
        }
        return false;
    }

    public function isValueOfType($value): bool
    {
        return is_object($value) && $this->getReflector()->isInstance($value);
    }

    /**
     * Retrieve the Reflection of the interface.
     */
    public function getReflector(): \ReflectionClass
    {
        return $this->reflector;
    }
}
