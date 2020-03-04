<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\FunctionType;
use PHP\Types\TypeNames;

class FunctionTypeDetails implements IExpectedTypeDetails
{


    public function getTypeNames(): array
    {
        return [ TypeNames::FUNCTION ];
    }


    public function getTypeClassName(): string
    {
        return FunctionType::class;
    }
}