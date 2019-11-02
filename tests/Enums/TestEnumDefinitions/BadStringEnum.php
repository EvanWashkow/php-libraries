<?php
declare( strict_types = 1 );

namespace PHP\Tests\Enums\TestEnumDefinitions;

use PHP\Enums\StringEnum;

class BadStringEnum extends StringEnum
{

    const A = 'a';

    const NUMBERS = 123;
}
