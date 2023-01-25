<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a collection which can add values
 */
interface AddableCollector extends Collector
{
    /**
     * Add a new value to the collection
     *
     * @param mixed $value The value
     *
     * @return static The modified collection
     * 
     * @throws \TypeError
     */
    public function add(mixed $value): static;
}
