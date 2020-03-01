<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

class FloatTypeDetails implements IExpectedTypeDetails
{


    public function getTypeNames(): array
    {
        return [ TypeNames::FLOAT, TypeNames::DOUBLE ];
    }


    public function getTypeClassName(): string
    {
        return Type::class;
    }
}