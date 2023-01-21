<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a collection with key => value mapping
 * 
 * @template TKey
 * @template TValue
 * @extends KeyedCollector<TKey, TValue>
 */
interface Mapper extends KeyedCollector { }
