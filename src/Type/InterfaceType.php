<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\TypeInterface\InheritableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\NameableTypeInterface;
use EvanWashkow\PHPLibraries\TypeInterface\TypeInterface;

/**
 * An Interface Type.
 */
final class InterfaceType implements InheritableTypeInterface, NameableTypeInterface
{
    private \ReflectionClass $reflector;

    /**
     * Create a new ClassType.
     *
     * @param string $name the interface name
     *
     * @throws \DomainException
     */
    public function __construct(string $name)
    {
        $exception = "not an interface name: \"{$name}\"";

        try {
            $this->reflector = new \ReflectionClass($name);
        } catch (\ReflectionException $e) {
            throw new \DomainException($exception);
        }

        if (!$this->reflector->isInterface()) {
            throw new \DomainException($exception);
        }
    }

    public function equals($value): bool
    {
        return $value instanceof self && $this->reflector->getName() == $value->getName();
    }

    public function getName(): string
    {
        return $this->reflector->getName();
    }

    public function is(TypeInterface $type): bool
    {
        if ($type instanceof NameableTypeInterface) {
            return
                $this->reflector->getName() == $type->getName()
                || $this->reflector->isSubclassOf($type->getName());
        }

        return false;
    }

    public function isValueOfType($value): bool
    {
        return is_object($value) && $this->reflector->isInstance($value);
    }
}
