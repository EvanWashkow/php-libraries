<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\FunctionInstanceType;

class FunctionInstanceTypeDetails extends FunctionTypeDetails
{

    public function getTypeClassName(): string
    {
        return FunctionInstanceType::class;
    }
}