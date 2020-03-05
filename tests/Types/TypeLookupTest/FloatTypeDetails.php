<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

class FloatTypeDetails implements IExpectedTypeDetails
{


    public function getNames(): array
    {
        return [ TypeNames::FLOAT, TypeNames::DOUBLE ];
    }


    public function getTypeTypes(): array
    {
        return [ Type::class ];
    }
}