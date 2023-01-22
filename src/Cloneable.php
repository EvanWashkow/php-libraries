<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries;

interface Cloneable
{
    /**
     * Returns a copy of the object
     */
    public function clone(): static;
}
