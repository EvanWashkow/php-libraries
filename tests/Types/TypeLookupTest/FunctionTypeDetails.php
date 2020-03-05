<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\FunctionType;
use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

class FunctionTypeDetails implements IExpectedTypeDetails
{


    public function getNames(): array
    {
        return [ TypeNames::FUNCTION ];
    }


    public function getTypeNames(): array
    {
        return [ FunctionType::class, Type::class ];
    }
}