<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

class BooleanTypeDetails implements IExpectedTypeDetails
{


    public function getNames(): array
    {
        return [ TypeNames::BOOL, TypeNames::BOOLEAN ];
    }


    public function getTypeNames(): array
    {
        return [ Type::class ];
    }
}