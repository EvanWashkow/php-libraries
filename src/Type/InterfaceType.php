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
    private ClassInterfaceTypeHelper $helper;

    /**
     * Create a new ClassType.
     *
     * @param string $interfaceName the interface name
     *
     * @throws \DomainException
     */
    public function __construct(string $interfaceName)
    {
        $this->helper = new ClassInterfaceTypeHelper($interfaceName);
        if (! $this->helper->getReflectionClass()->isInterface()) {
            throw new \DomainException("The type is not an interface: {$interfaceName}");
        }
    }

    public function equals(Equatable $value): bool
    {
        return $value instanceof self && $this->helper->equals($value);
    }

    public function getName(): string
    {
        return $this->helper->getName();
    }

    public function is(Type $type): bool
    {
        return $this->helper->is($type);
    }

    /**
     * @inheritDoc
     */
    public function isValueOfType($value): bool
    {
        return $this->helper->isValueOfType($value);
    }
}
