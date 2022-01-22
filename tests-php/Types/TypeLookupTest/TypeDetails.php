<?php

declare(strict_types=1);

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\Type;

abstract class TypeDetails
{
    /**
     * Return the expected Type->getNames() as an array.
     *
     * @return string[]
     */
    abstract public function getNames(): array;

    /**
     * Return the expected classes / interface names for a Type instance.
     *
     * Testing that a Type is an ObjectClass is done once, in the TypeTest
     *
     * @return string[]
     */
    public function getTypeNames(): array
    {
        return [Type::class];
    }
}
