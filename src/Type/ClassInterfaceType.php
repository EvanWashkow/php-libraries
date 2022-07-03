<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Base type for Classes and Interfaces.
 */
abstract class ClassInterfaceType implements \EvanWashkow\PHPLibraries\TypeInterface\InheritableType, \EvanWashkow\PHPLibraries\TypeInterface\NameableType
{
    /**
     * Initialized the ClassInterfaceType.
     *
     * @param string $name the class or interface name
     */
    public function __construct(string $name)
    {
    }

    public function equals(Equatable $value): bool
    {
        // TODO: Implement equals() method.
    }

    public function is(Type $type): bool
    {
        // TODO: Implement is() method.
    }

    /**
     * @inheritDoc
     */
    public function isValueOfType($value): bool
    {
        // TODO: Implement isValueOfType() method.
    }
}
