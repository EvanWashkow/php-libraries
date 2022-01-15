<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * A Interface Type.
 */
final class InterfaceType implements TypeInterface
{
    private \ReflectionClass $class;

    /**
     * Create a new ClassType.
     *
     * @param string $class The class name.
     * @throws \DomainException
     */
    public function __construct(string $class)
    {
        $exception = "not an interface name: \"{$class}\"";

        try {
            $this->class = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \DomainException($exception);
        }

        if (!$this->class->isInterface()) {
            throw new \DomainException($exception);
        }
    }

    public function equals($value): bool
    {
        return $value instanceof self && $this->class->getName() == $value->class->getName();
    }

    public function is(TypeInterface $type): bool
    {
        if ($type instanceof InterfaceType) {
            return $this->class->getName() == $type->class->getName() || $this->class->isSubclassOf($type->class);
        }
        return false;
    }

    public function isValueOfType($value): bool
    {
        return is_object($value) && $this->class->isInstance($value);
    }
}
