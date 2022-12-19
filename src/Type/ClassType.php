<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\InheritableType;
use EvanWashkow\PHPLibraries\TypeInterface\NameableType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * A Class Type.
 */
final class ClassType implements InheritableType, NameableType
{
    private ClassInterfaceTypeHelper $helper;

    /**
     * Create a new ClassType.
     *
     * @param string $className the class name
     *
     * @throws \DomainException
     */
    public function __construct(string $className)
    {
        $this->helper = new ClassInterfaceTypeHelper($className);
        if ($this->helper->getReflectionClass()->isInterface()) {
            throw new \DomainException("The type is not a class: {$className}");
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
    public function isValueOfType(mixed $value): bool
    {
        return $this->helper->isValueOfType($value);
    }
}
