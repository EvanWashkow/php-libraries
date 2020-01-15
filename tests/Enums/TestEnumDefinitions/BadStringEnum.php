<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\StringEnum;

class BadStringEnum extends StringEnum
{

    const ONE = '1';

    const TWO = 2;
}
