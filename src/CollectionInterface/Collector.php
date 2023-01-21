<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

use EvanWashkow\PhpLibraries\Cloneable;

interface Collector extends \Countable, Cloneable
{
    /**
     * Retrieve the value type
     */
    public function getValueType(): Type;
}
