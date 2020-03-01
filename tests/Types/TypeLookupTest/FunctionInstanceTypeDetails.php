<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\FunctionType;

class FunctionInstanceTypeDetails extends FunctionTypeDetails
{

    public function getTypeClassName(): string
    {
        return FunctionType::class;
    }
}