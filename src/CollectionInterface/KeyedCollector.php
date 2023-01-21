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
     * Retrieve the value by its key
     *
     * @param int $key The key for the value
     *
     * @return mixed The value
     *
     * @throws \OutOfBoundsException
     */
    public function get(int $key): mixed;

    /**
     * Retrieve the key type
     */
    public function getKeyType(): Type;
}
