<?php

declare(strict_types=1);

namespace PHP\Tests\Types\TypeLookupTest;

use PHP\Types\TypeNames;

class NullTypeDetails extends TypeDetails
{
    public function getNames(): array
    {
        return [TypeNames::NULL];
    }
}
