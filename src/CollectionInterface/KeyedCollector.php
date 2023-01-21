<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

use EvanWashkow\PhpLibraries\TypeInterface\Type;

/**
 * Describes a collection with key => value mapping
 */
interface KeyedCollector extends Collector
{
    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type;
}
