<?php
declare( strict_types = 1 );

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\FunctionInstanceType;
use PHP\Types\Models\FunctionType;

class FunctionInstanceTypeDetails extends FunctionTypeDetails
{

    public function getTypeTypes(): array
    {
        return [ FunctionInstanceType::class, FunctionType::class ];
    }
}