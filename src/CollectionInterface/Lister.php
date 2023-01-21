<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a list of indexed values
 *
 * @template TValue
 *
 * @extends KeyedCollector<int, TValue>
 */
interface Lister extends KeyedCollector
{
}
