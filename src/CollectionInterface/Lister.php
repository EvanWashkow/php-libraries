<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a list of indexed values
 */
interface Lister extends KeyedCollector
{
    /**
     * Add a new value to the list
     *
     * @param mixed $value The value
     *
     * @return self The modified list
     */
    public function add(mixed $value): self;

    /**
     * Removes a value by its index
     *
     * @param int $index The index to remove
     */
    public function removeKey(int $index): self;
}
