<?php

declare(strict_types=1);

namespace EvanWashkow\PhpLibraries\CollectionInterface;

/**
 * Describes a collection with key => value mapping
 * 
 * @template KeyType
 * @template ValueType
 * @extends KeyedCollector<KeyType, ValueType>
 */
interface Mapper extends KeyedCollector { }
