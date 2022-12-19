<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\TypeInterface;

use EvanWashkow\PHPLibraries\Equatable;

/**
 * Describes a Type.
 */
interface Type extends Equatable
{
    /**
     * Determines if the given value is of this type.
     *
     * @param mixed $value the value to check
     */
    public function isValueOfType(mixed $value): bool;
}
