<?php

declare(strict_types=1);

namespace EvanWashkow\PHPLibraries\Collection;

use EvanWashkow\PHPLibraries\Type\IntegerType;
use EvanWashkow\PHPLibraries\Type\StringType;
use EvanWashkow\PHPLibraries\TypeInterface\Type;

/**
 * Defines a key => value map
 */
final class Map
{
    private Type $keyType;

    public function __construct(Type $keyType, Type $valueType)
    {
        if (! ($keyType instanceof IntegerType || $keyType instanceof StringType)) {
            throw new \InvalidArgumentException('The Map key type must be an integer or string');
        }
        $this->keyType = $keyType;
    }

    public function getKeyType(): Type {
        return $this->keyType;
    }
}
