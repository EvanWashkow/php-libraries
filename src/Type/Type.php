<?php
declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Type;

use EvanWashkow\PHPLibraries\Equatable;

/**
 * Describes a Type.
 */
interface Type extends Equatable
{
    /**
     * Check type inheritance.
     * 
     * True if this type is:
     * - the same as the given type
     * - derived from the given type
     */
    function is(Type $type): bool;
}