<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

/**
 * Describes a Type.
 */
interface TypeInterface extends \EvanWashkow\PHPLibraries\TypeInterface\TypeInterface
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