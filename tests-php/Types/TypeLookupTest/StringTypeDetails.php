<?php

declare(strict_types=1);

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\Models\Type;
use PHP\Types\TypeNames;

class StringTypeDetails extends TypeDetails
{
    public function getNames(): array
    {
        return [ TypeNames::STRING ];
    }
}
