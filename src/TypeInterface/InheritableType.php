<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\TypeInterface;

/**
 * Describes a Type that can inherit another Type.
 */
interface InheritableType extends Type
{
    /**
     * Check type inheritance.
     *
     * True if this type is:
     * - the same as the given type
     * - derived from the given type
     *
     * @param Type $type the type to check
     */
    public function is(Type $type): bool;
}
