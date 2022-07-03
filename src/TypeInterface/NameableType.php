<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\TypeInterface;

/**
 * Describes a Type with a name.
 */
interface NameableType extends Type
{
    /**
     * Get the Type name.
     */
    public function getName(): string;
}
