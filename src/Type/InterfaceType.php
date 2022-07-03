<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableType;
use EvanWashkow\PHPLibraries\TypeInterface\NameableType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * An Interface Type.
 */
final class InterfaceType implements InheritableType, NameableType
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

        if (! $this->reflector->isInterface()) {
            throw new \DomainException($exception);
        }
    }

    public function equals(Equatable $value): bool
    {
        return $value instanceof self && $this->reflector->getName() === $value->getName();
    }

    public function getName(): string
    {
        return $this->reflector->getName();
    }

    public function is(Type $type): bool
    {
        if ($type instanceof NameableType) {
            return $this->reflector->getName() === $type->getName()
                || $this->reflector->isSubclassOf($type->getName());
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function isValueOfType($value): bool
    {
        return is_object($value) && $this->reflector->isInstance($value);
    }
}
