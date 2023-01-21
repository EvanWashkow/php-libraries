<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

interface Collector
{
    /**
     * Retrieve the value type
     */
    public function getValueType(): Type;
}
