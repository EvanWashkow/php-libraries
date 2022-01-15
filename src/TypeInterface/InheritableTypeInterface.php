<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\TypeInterface;

/**
 * Describes a Type that can inherit another Type.
 */
interface InheritableTypeInterface extends TypeInterface
{
    /**
     * Check type inheritance.
     * 
     * True if this type is:
     * - the same as the given type
     * - derived from the given type
     * 
     * @param TypeInterface $type The type to check.
     * @return boolean
     */
    function is(TypeInterface $type): bool;
}